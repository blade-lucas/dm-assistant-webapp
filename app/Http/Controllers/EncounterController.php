<?php

namespace App\Http\Controllers;

use App\Repositories\EncounterRepository;
use App\Repositories\MonsterRepository;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    public function index(Request $request, EncounterRepository $repo)
    {
        $locationType = $request->query('location_type');
        $locationType = is_string($locationType) && trim($locationType) !== '' ? $locationType : null;

        $locationSubtype = $request->query('location_subtype');
        $locationSubtype = is_string($locationSubtype) && trim($locationSubtype) !== '' ? $locationSubtype : null;

        $types = $request->query('types', []);
        if (is_string($types)) $types = [$types];
        $types = is_array($types) ? $types : [];

        $dice = (string)($request->query('dice', '1d20'));
        $dice = in_array($dice, ['1d20','1d12','2d6','1d12+1d6'], true) ? $dice : '1d20';

        $locationTypes = $repo->locationTypes();
        $subtypes = $repo->locationSubtypes($locationType);

        $show = $request->query('show') === '1';
        $generated = $show ? session('encounter_generated_table', null) : null;

        $aiPrompt = $request->query('ai_prompt');
        $aiPrompt = is_string($aiPrompt) ? trim($aiPrompt) : '';

        $partyLevel = $request->query('party_level');
        $partyLevel = is_numeric($partyLevel) ? (int)$partyLevel : null;

        $tone = $request->query('tone');
        $tone = is_string($tone) && trim($tone) !== '' ? trim($tone) : null;

        return view('encounters.index', [
            'locationTypes' => $locationTypes,
            'subtypes' => $subtypes,
            'selected' => [
                'location_type' => $locationType,
                'location_subtype' => $locationSubtype,
                'types' => $types,
                'dice' => $dice,
                'ai_prompt' => $aiPrompt,
                'party_level' => $partyLevel,
                'tone' => $tone,
            ],
            'generated' => $generated,
            'show' => $show,
        ]);
    }

    public function roll(Request $request, EncounterRepository $repo)
    {
        $validated = $request->validate([
            'location_type' => ['nullable','string','max:60'],
            'location_subtype' => ['nullable','string','max:60'],
            'types' => ['required','array'],
            'types.*' => ['string','max:30'],
            'dice' => ['required','in:1d20,1d12,2d6,1d12+1d6'],
        ]);

        $locationType = trim((string)($validated['location_type'] ?? '')) ?: null;
        $locationSubtype = trim((string)($validated['location_subtype'] ?? '')) ?: null;
        $types = $validated['types'] ?? [];
        $dice = $validated['dice'];

        $pool = $repo->filter($locationType, $locationSubtype, $types);

        $outcomes = $this->diceOutcomes($dice);

        $tableRows = [];
        foreach ($outcomes as $rollValue) {
            $picked = $this->pickWeighted($pool);

            $tableRows[] = [
                'roll' => $rollValue,
                'encounter' => $picked, // can be null if pool empty
            ];
        }

        session()->put('encounter_generated_table', [
            'params' => [
                'location_type' => $locationType,
                'location_subtype' => $locationSubtype,
                'types' => $types,
                'dice' => $dice,
            ],
            'pool_count' => count($pool),
            'rows' => $tableRows,
            'generated_at' => now()->toISOString(),
        ]);

        return redirect()->route('encounters.index', [
            'show' => 1,
            'location_type' => $locationType,
            'location_subtype' => $locationSubtype,
            'types' => $types,
            'dice' => $dice,
        ])->with('status', 'Encounter table generated.');
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

    /**
     * Weighted random pick (duplicates allowed).
     * If encounterWeight is missing, assume 1.
     */
    private function pickWeighted(array $pool): ?array
    {
        if (empty($pool)) return null;

        $total = 0;
        foreach ($pool as $e) {
            $w = (int)($e['encounterWeight'] ?? 1);
            if ($w < 1) $w = 1;
            $total += $w;
        }

        $r = random_int(1, max(1, $total));
        $running = 0;

        foreach ($pool as $e) {
            $w = (int)($e['encounterWeight'] ?? 1);
            if ($w < 1) $w = 1;
            $running += $w;

            if ($r <= $running) return $e;
        }

        // Fallback
        return $pool[array_key_last($pool)];
    }

    private function rollDice(string $dice): array
    {
        // returns [roll, breakdown string, maxPossible]
        if ($dice === '1d20') {
            $a = random_int(1, 20);
            return [$a, "1d20 = {$a}", 20];
        }

        if ($dice === '1d12') {
            $a = random_int(1, 12);
            return [$a, "1d12 = {$a}", 12];
        }

        if ($dice === '2d6') {
            $a = random_int(1, 6);
            $b = random_int(1, 6);
            $sum = $a + $b;
            return [$sum, "2d6 = {$a} + {$b} = {$sum}", 12];
        }

        // 1d12+1d6
        $a = random_int(1, 12);
        $b = random_int(1, 6);
        $sum = $a + $b;
        return [$sum, "1d12+1d6 = {$a} + {$b} = {$sum}", 18];
    }

    public function pickMonster(int $row, int $slot, Request $request, MonsterRepository $monsters)
    {
        $generated = session('encounter_generated_table');
        if (!$generated || !isset($generated['rows'][$row])) {
            return redirect()->route('encounters.index')->with('status', 'No generated encounter table found.');
        }

        $q = (string)$request->query('q', '');
        $type = $request->query('type');
        $type = is_string($type) && trim($type) !== '' ? $type : null;

        $maxCrRaw = $request->query('max_cr');
        $maxCr = null;
        if (is_string($maxCrRaw) && trim($maxCrRaw) !== '' && is_numeric($maxCrRaw)) {
            $maxCr = (float)$maxCrRaw;
        }

        $results = $monsters->search($q, $type, $maxCr, 200);

        return view('encounters.pick_monster', [
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
            'monster_slug' => ['required','string','max:120'],
        ]);

        $generated = session('encounter_generated_table');
        if (!$generated || !isset($generated['rows'][$row])) {
            return redirect()->route('encounters.index')->with('status', 'No generated encounter table found.');
        }

        $monster = $monsters->findBySlug($validated['monster_slug']);
        if (!$monster) return back()->with('status', 'Monster not found.');

        $generated['rows'][$row]['selected_monsters'] ??= [];
        $generated['rows'][$row]['selected_monsters'][$slot] = [
            'slug' => $validated['monster_slug'],
            'name' => $monster['m_name'] ?? 'Monster',
            'type' => $monster['m_type'] ?? null,
            'cr' => $monster['m_cr'] ?? null,
        ];

        session()->put('encounter_generated_table', $generated);

        return redirect()->route('encounters.index', ['show' => 1])->with('status', "Monster #{$slot} assigned.");
    }

    public function aiGenerate(Request $request)
    {
        $validated = $request->validate([
            'location_type' => ['nullable', 'string', 'max:60'],
            'location_subtype' => ['nullable', 'string', 'max:60'],
            'types' => ['required', 'array'],
            'types.*' => ['string', 'max:30'],
            'dice' => ['required', 'in:1d20,1d12,2d6,1d12+1d6'],
            'ai_prompt' => ['nullable', 'string', 'max:1000'],
            'party_level' => ['nullable', 'integer', 'min:1', 'max:20'],
            'tone' => ['nullable', 'string', 'max:40'],
        ]);

        $locationType = trim((string)($validated['location_type'] ?? '')) ?: null;
        $locationSubtype = trim((string)($validated['location_subtype'] ?? '')) ?: null;
        $types = $validated['types'] ?? [];
        $dice = $validated['dice'];
        $aiPrompt = trim((string)($validated['ai_prompt'] ?? ''));
        $partyLevel = $validated['party_level'] ?? null;
        $tone = trim((string)($validated['tone'] ?? '')) ?: null;

        $outcomes = $this->diceOutcomes($dice);

        $aiRows = $this->generateAiEncounterRows(
            outcomes: $outcomes,
            locationType: $locationType,
            locationSubtype: $locationSubtype,
            types: $types,
            dice: $dice,
            aiPrompt: $aiPrompt,
            partyLevel: $partyLevel,
            tone: $tone
        );

        session()->put('encounter_generated_table', [
            'params' => [
                'location_type' => $locationType,
                'location_subtype' => $locationSubtype,
                'types' => $types,
                'dice' => $dice,
                'ai_prompt' => $aiPrompt,
                'party_level' => $partyLevel,
                'tone' => $tone,
                'source' => 'ai',
            ],
            'pool_count' => count($aiRows),
            'rows' => $aiRows,
            'generated_at' => now()->toISOString(),
        ]);

        return redirect()->route('encounters.index', [
            'show' => 1,
            'location_type' => $locationType,
            'location_subtype' => $locationSubtype,
            'types' => $types,
            'dice' => $dice,
            'ai_prompt' => $aiPrompt,
            'party_level' => $partyLevel,
            'tone' => $tone,
        ])->with('status', 'AI encounter table generated.');
    }

    private function generateAiEncounterRows(
        array $outcomes,
        ?string $locationType,
        ?string $locationSubtype,
        array $types,
        string $dice,
        string $aiPrompt,
        ?int $partyLevel,
        ?string $tone
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
        ];

        // Replace this with your actual AI call.
        // For now this is written as if using Laravel's Http client against an LLM endpoint.
        $response = \Illuminate\Support\Facades\Http::withToken(config('services.openai.api_key'))
            ->withOptions(['verify' => false])
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
            dd($response->status(), $response->body());
        }
        if (!$response->successful()) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'ai_prompt' => 'AI generation failed. Please try again.',
            ]);
        }

        $content = data_get($response->json(), 'choices.0.message.content');

        if (!is_string($content) || trim($content) === '') {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'ai_prompt' => 'AI returned an empty response.',
            ]);
        }

        $decoded = json_decode($content, true);

        if (!is_array($decoded) || !isset($decoded['rows']) || !is_array($decoded['rows'])) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'ai_prompt' => 'AI returned invalid encounter data.',
            ]);
        }

        $normalized = [];
        foreach ($outcomes as $index => $rollValue) {
            $row = $decoded['rows'][$index] ?? null;
            $encounter = is_array($row['encounter'] ?? null) ? $row['encounter'] : [];

            $type = (string)($encounter['encounterTypes'] ?? 'Interaction');
            if (!in_array($type, ['Combat', 'Friendly', 'Interaction', 'Puzzle'], true)) {
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
