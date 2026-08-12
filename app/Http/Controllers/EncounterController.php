<?php

namespace App\Http\Controllers;

use App\Services\CampaignContextService;
use App\Repositories\EncounterRepository;
use App\Repositories\MonsterRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class EncounterController extends Controller
{
    private const ENCOUNTER_TYPES = ['Combat', 'Friendly', 'Interaction', 'Puzzle'];
    private const DICE_OPTIONS = ['1d20', '1d12', '2d6', '1d12+1d6'];

    public function index(Request $request, EncounterRepository $repo)
    {
        $campaignId = $request->query('campaign');

        $locationType = $this->normalizeAny($request->query('location_type'));
        $locationSubtype = $this->normalizeAny($request->query('location_subtype'));

        $types = $this->normalizeTypes($request->query('types', []));
        $dice = $this->normalizeDice($request->query('dice', '1d20'));

        $aiPrompt = trim((string) $request->query('ai_prompt', ''));
        $partyLevel = is_numeric($request->query('party_level')) ? (int) $request->query('party_level') : null;
        $tone = $this->normalizeAny($request->query('tone'));

        $mode = $request->query('mode', 'manual');
        $mode = in_array($mode, ['manual', 'ai'], true) ? $mode : 'manual';

        $locationTypes = $repo->locationTypes();
        $subtypes = $repo->locationSubtypes($locationType);

        $show = $request->query('show') === '1';
        $generated = $show ? session('encounter_generated_table', null) : null;

        return view('encounters.index', [
            'campaignId' => $campaignId,
            'locationTypes' => $locationTypes,
            'subtypes' => $subtypes,
            'encounterTypes' => self::ENCOUNTER_TYPES,
            'selected' => [
                'location_type' => $locationType,
                'location_subtype' => $locationSubtype,
                'types' => $types,
                'dice' => $dice,
                'ai_prompt' => $aiPrompt,
                'party_level' => $partyLevel,
                'tone' => $tone,
                'mode' => $mode,
            ],
            'generated' => $generated,
            'show' => $show,
        ]);
    }

    public function roll(Request $request, EncounterRepository $repo)
    {
        $validated = $request->validate([
            'campaign_id' => ['nullable', 'integer', 'exists:campaigns,id'],
            'location_type' => ['nullable', 'string', 'max:60'],
            'location_subtype' => ['nullable', 'string', 'max:60'],
            'types' => ['nullable', 'array'],
            'types.*' => ['string', 'in:Combat,Friendly,Interaction,Puzzle'],
            'dice' => ['required', 'in:1d20,1d12,2d6,1d12+1d6'],
        ]);

        $campaignId = $validated['campaign_id'] ?? null;

        if ($campaignId) {
            \App\Models\Campaign::where('user_id', auth()->id())
                ->findOrFail($campaignId);
        }

        $locationType = $this->normalizeAny($validated['location_type'] ?? null);
        $locationSubtype = $this->normalizeAny($validated['location_subtype'] ?? null);
        $types = $this->normalizeTypes($validated['types'] ?? []);
        $dice = $this->normalizeDice($validated['dice']);

        $pool = $repo->filter($locationType, $locationSubtype, $types);
        $outcomes = $this->diceOutcomes($dice);

        $tableRows = [];
        foreach ($outcomes as $rollValue) {
            $tableRows[] = [
                'roll' => $rollValue,
                'encounter' => $this->pickWeighted($pool),
            ];
        }

        session()->put('encounter_generated_table', [
            'params' => [
                'campaign_id' => $campaignId,
                'location_type' => $locationType,
                'location_subtype' => $locationSubtype,
                'types' => $types,
                'dice' => $dice,
                'mode' => 'manual',
            ],
            'pool_count' => count($pool),
            'rows' => $tableRows,
            'generated_at' => now()->toISOString(),
        ]);

        return redirect()->route('encounters.index', [
            'campaign' => $campaignId,
            'show' => 1,
            'mode' => 'manual',
            'location_type' => $locationType,
            'location_subtype' => $locationSubtype,
            'types' => $types,
            'dice' => $dice,
        ])->with('status', 'Encounter table generated.');
    }

    public function aiGenerate(
        Request $request,
        CampaignContextService $campaignContextService
    )
    {
        $validated = $request->validate([
            'campaign_id' => ['nullable', 'integer', 'exists:campaigns,id'],
            'location_type' => ['nullable', 'string', 'max:60'],
            'location_subtype' => ['nullable', 'string', 'max:60'],
            'types' => ['nullable', 'array'],
            'types.*' => ['string', 'in:Combat,Friendly,Interaction,Puzzle'],
            'dice' => ['required', 'in:1d20,1d12,2d6,1d12+1d6'],
            'ai_prompt' => ['nullable', 'string', 'max:1000'],
            'party_level' => ['nullable', 'integer', 'min:1', 'max:20'],
            'tone' => ['nullable', 'string', 'max:40'],
        ]);

        $campaignId = $validated['campaign_id'] ?? null;
        $campaignContext = null;

        if ($campaignId) {
            $campaign = \App\Models\Campaign::where('user_id', auth()->id())
                ->findOrFail($campaignId);

            $campaignContext = $campaignContextService->build($campaign);
        }

        $locationType = $this->normalizeAny($validated['location_type'] ?? null);
        $locationSubtype = $this->normalizeAny($validated['location_subtype'] ?? null);
        $types = $this->normalizeTypes($validated['types'] ?? []);
        $dice = $this->normalizeDice($validated['dice']);
        $aiPrompt = trim((string)($validated['ai_prompt'] ?? ''));
        $partyLevel = $validated['party_level'] ?? null;
        $tone = $this->normalizeAny($validated['tone'] ?? null);

        $outcomes = $this->diceOutcomes($dice);

        $aiRows = $this->generateAiEncounterRows(
            outcomes: $outcomes,
            locationType: $locationType,
            locationSubtype: $locationSubtype,
            types: $types,
            dice: $dice,
            aiPrompt: $aiPrompt,
            partyLevel: $partyLevel,
            tone: $tone,
            campaignContext: $campaignContext
        );

        session()->put('encounter_generated_table', [
            'params' => [
                'campaign_id' => $campaignId,
                'location_type' => $locationType,
                'location_subtype' => $locationSubtype,
                'types' => $types,
                'dice' => $dice,
                'ai_prompt' => $aiPrompt,
                'party_level' => $partyLevel,
                'tone' => $tone,
                'source' => 'ai',
                'mode' => 'ai',
                'campaign_context_used' => $campaignContext !== null,
            ],
            'pool_count' => count($aiRows),
            'rows' => $aiRows,
            'generated_at' => now()->toISOString(),
        ]);

        return redirect()->route('encounters.index', [
            'campaign' => $campaignId,
            'show' => 1,
            'mode' => 'ai',
            'location_type' => $locationType,
            'location_subtype' => $locationSubtype,
            'types' => $types,
            'dice' => $dice,
            'ai_prompt' => $aiPrompt,
            'party_level' => $partyLevel,
            'tone' => $tone,
        ])->with('status', 'AI encounter table generated.');
    }

    private function normalizeAny(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $value = trim($value);

        return $value === '' ? null : $value;
    }

    private function normalizeTypes(mixed $types): array
    {
        if (is_string($types)) {
            $types = [$types];
        }

        if (!is_array($types)) {
            return self::ENCOUNTER_TYPES;
        }

        $types = array_values(array_filter($types, fn ($t) => in_array($t, self::ENCOUNTER_TYPES, true)));

        return count($types) ? $types : self::ENCOUNTER_TYPES;
    }

    private function normalizeDice(mixed $dice): string
    {
        $dice = is_string($dice) ? $dice : '1d20';
        return in_array($dice, self::DICE_OPTIONS, true) ? $dice : '1d20';
    }

    private function diceOutcomes(string $dice): array
    {
        return match ($dice) {
            '1d20' => range(1, 20),
            '1d12' => range(1, 12),
            '2d6' => range(2, 12),
            '1d12+1d6' => range(2, 18),
            default => range(1, 20),
        };
    }

    private function pickWeighted(array $pool): ?array
    {
        if (empty($pool)) {
            return null;
        }

        $total = 0;
        foreach ($pool as $e) {
            $w = max(1, (int)($e['encounterWeight'] ?? 1));
            $total += $w;
        }

        $r = random_int(1, max(1, $total));
        $running = 0;

        foreach ($pool as $e) {
            $w = max(1, (int)($e['encounterWeight'] ?? 1));
            $running += $w;

            if ($r <= $running) {
                return $e;
            }
        }

        return $pool[array_key_last($pool)];
    }

    public function pickMonster(int $row, int $slot, Request $request, MonsterRepository $monsters)
    {
        $generated = session('encounter_generated_table');
        if (!$generated || !isset($generated['rows'][$row])) {
            return redirect()->route('encounters.index')->with('status', 'No generated encounter table found.');
        }

        $q = (string)$request->query('q', '');
        $type = $this->normalizeAny($request->query('type'));

        $maxCrRaw = $request->query('max_cr');
        $maxCr = null;
        if (is_string($maxCrRaw) && trim($maxCrRaw) !== '' && is_numeric($maxCrRaw)) {
            $maxCr = (float)$maxCrRaw;
        }

        $results = $monsters->search($q, $type, $maxCr, 200);

        return view('encounters.pick_monster', [
            'campaignId' => $request->query('campaign'),
            'row' => $row,
            'slot' => $slot,
            'q' => $q,
            'type' => $type,
            'maxCr' => $maxCrRaw,
            'types' => $monsters->types(),
            'results' => $results,
            'encounter' => $generated['rows'][$row]['encounter'] ?? null,
        ]);
    }

    public function setMonster(int $row, int $slot, Request $request, MonsterRepository $monsters)
    {
        $validated = $request->validate([
            'monster_slug' => ['required', 'string', 'max:120'],
            'campaign_id' => ['nullable', 'integer', 'exists:campaigns,id'],
        ]);

        $generated = session('encounter_generated_table');
        if (!$generated || !isset($generated['rows'][$row])) {
            return redirect()->route('encounters.index')->with('status', 'No generated encounter table found.');
        }

        $monster = $monsters->findBySlug($validated['monster_slug']);
        if (!$monster) {
            return back()->with('status', 'Monster not found.');
        }

        $generated['rows'][$row]['selected_monsters'] ??= [];
        $generated['rows'][$row]['selected_monsters'][$slot] = [
            'slug' => $validated['monster_slug'],
            'name' => $monster['m_name'] ?? 'Monster',
            'type' => $monster['m_type'] ?? null,
            'cr' => $monster['m_cr'] ?? null,
        ];

        session()->put('encounter_generated_table', $generated);

        return redirect()->route('encounters.index', [
            'show' => 1,
            'campaign' => $validated['campaign_id'] ?? null,
        ])->with('status', "Monster #{$slot} assigned.");
    }

    private function generateAiEncounterRows(
        array $outcomes,
        ?string $locationType,
        ?string $locationSubtype,
        array $types,
        string $dice,
        string $aiPrompt,
        ?int $partyLevel,
        ?string $tone,
        ?array $campaignContext = null
    ): array {
        $count = count($outcomes);

        $systemPrompt = <<<PROMPT
You generate Dungeons & Dragons encounter table rows as strict JSON.

Return ONLY valid JSON in this exact shape:
{
  "rows": [
    {
      "roll": 1,
      "encounter": {
        "encounterTypes": "Combat",
        "encounterDetails": "A short encounter description. Use [MONSTER] placeholders when monsters are involved.",
        "encounterWeight": 1,
        "locationType": "Wilderness",
        "locationSubtype": "Forest"
      }
    }
  ]
}

Rules:
- Return exactly {$count} rows.
- Each row roll must match the requested roll values in order.
- encounterTypes must be one of: Combat, Friendly, Interaction, Puzzle.
- encounterDetails must be concise, playable, and DM-friendly.
- If a monster-based encounter is generated, use [MONSTER] placeholders instead of specific monster names.
- Do not include markdown.
- Do not include explanations.
- Keep each encounterDetails under 220 characters.
- If campaign context is provided, use it when relevant to maintain continuity with the campaign.
- Campaign context is supporting continuity, not the primary subject of the encounter table.
- For a table with 8 or more encounters, directly reference established campaign-specific names, NPCs, locations, items, events, or unresolved hooks in no more than half of the encounters.
- The remaining encounters MUST be new situations that do not directly reference named campaign elements, while still matching the campaign's established setting, tone, party level, and current circumstances.
- New encounters may introduce new NPCs, locations, threats, discoveries, complications, or opportunities that could become part of the campaign.
- Do not force campaign references into every encounter.
- Do not contradict established campaign facts.
- Treat DM notes as guidance, not facts that have already occurred.
- Do not reveal hidden DM notes directly unless they naturally become part of the encounter.
PROMPT;

        $userPrompt = [
            'roll_values' => array_values($outcomes),
            'dice' => $dice,
            'location_type' => $locationType,
            'location_subtype' => $locationSubtype,
            'allowed_types' => array_values($types),
            'party_level' => $partyLevel,
            'tone' => $tone,
            'dm_prompt' => $aiPrompt,
            'campaign_context' => $campaignContext,
        ];

        $response = Http::withToken(config('services.openai.api_key'))
            ->connectTimeout(15)
            ->timeout(60)
            ->post(config('services.openai.endpoint'), [
                'model' => config('services.openai.model'),
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => json_encode($userPrompt)],
                ],
                'temperature' => 0.8,
            ]);

        if (!$response->successful()) {
            throw ValidationException::withMessages([
                'ai_prompt' => 'AI generation failed. Please try again.',
            ]);
        }

        $content = data_get($response->json(), 'choices.0.message.content');

        if (!is_string($content) || trim($content) === '') {
            throw ValidationException::withMessages([
                'ai_prompt' => 'AI returned an empty response.',
            ]);
        }

        $content = trim($content);
        $content = preg_replace('/^```json|```$/m', '', $content);

        $decoded = json_decode($content, true);

        if (!is_array($decoded) || !isset($decoded['rows']) || !is_array($decoded['rows'])) {
            throw ValidationException::withMessages([
                'ai_prompt' => 'AI returned invalid encounter data.',
            ]);
        }

        $normalized = [];
        foreach ($outcomes as $index => $rollValue) {
            $row = $decoded['rows'][$index] ?? null;
            $encounter = is_array($row['encounter'] ?? null) ? $row['encounter'] : [];

            $type = (string)($encounter['encounterTypes'] ?? 'Interaction');
            if (!in_array($type, self::ENCOUNTER_TYPES, true)) {
                $type = 'Interaction';
            }

            $details = trim((string)($encounter['encounterDetails'] ?? 'A strange event unfolds.'));
            if ($details === '') {
                $details = 'A strange event unfolds.';
            }

            $normalized[] = [
                'roll' => $rollValue,
                'encounter' => [
                    'encounterTypes' => $type,
                    'encounterDetails' => $details,
                    'encounterWeight' => 1,
                    'locationType' => $locationType,
                    'locationSubtype' => $locationSubtype,
                ],
            ];
        }

        return $normalized;
    }
}
