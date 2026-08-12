<x-layouts.app title="Encounter Generator">
    @php
        $typesSelected = $selected['types'] ?? [];
        $diceSelected = $selected['dice'] ?? '1d20';
    @endphp

    <div class="mx-auto max-w-6xl">

        {{-- HEADER --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">Encounter Generator</h1>
                    <p class="mt-1 text-sm text-slate-400">
                        Choose parameters and click Roll to generate an encounter table.
                    </p>
                </div>

                <a href="{{ route('encounters.saved') }}"
                   class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                    Saved Tables
                </a>
            </div>

            @if(session('status'))
                <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mt-4 rounded-2xl border border-red-900 bg-red-950/30 p-3 text-sm text-red-200">
                    <div class="font-semibold">Fix these before rolling:</div>
                    <ul class="mt-2 list-disc pl-5">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="mt-6 grid gap-6 lg:grid-cols-[360px_1fr]">

            {{-- LEFT PANEL --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">

                <div class="text-sm font-semibold">Parameters</div>

                <form method="POST" action="{{ route('encounters.roll') }}" class="mt-4 grid gap-4">
                    @csrf
                    @if($campaignId)
                        <input type="hidden"
                               name="campaign_id"
                               value="{{ $campaignId }}">
                    @endif
                    {{-- Location Type --}}
                    <div>
                        <label class="text-xs text-slate-400">Location Type</label>
                        <select name="location_type"
                                class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            <option value="">Any</option>
                            @foreach($locationTypes as $t)
                                <option value="{{ $t }}"
                                    @selected(($selected['location_type'] ?? null) === $t)>
                                    {{ $t }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Location Subtype --}}
                    <div>
                        <label class="text-xs text-slate-400">Location Subtype</label>
                        <select name="location_subtype"
                                class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            <option value="">Any</option>
                            @foreach($subtypes as $st)
                                <option value="{{ $st }}"
                                    @selected(($selected['location_subtype'] ?? null) === $st)>
                                    {{ $st }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Encounter Types --}}
                    <div>
                        <label class="text-xs text-slate-400">Encounter Types</label>
                        <div class="mt-2 grid gap-2 text-sm">
                            @foreach(['Combat','Friendly','Interaction','Puzzle'] as $value)
                                <label class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2">
                                    <input type="checkbox"
                                           name="types[]"
                                           value="{{ $value }}"
                                        @checked(in_array($value, $typesSelected, true))>
                                    {{ $value }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Dice --}}
                    <div>
                        <label class="text-xs text-slate-400">Dice</label>
                        <div class="mt-2 grid gap-2 text-sm">
                            @foreach(['1d20','1d12','2d6','1d12+1d6'] as $opt)
                                <label class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2">
                                    <input type="radio"
                                           name="dice"
                                           value="{{ $opt }}"
                                        @checked($diceSelected === $opt)>
                                    {{ strtoupper($opt) }}
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- AI Options --}}
                    <div class="pt-2 border-t border-slate-800">
                        <label class="text-xs text-slate-400">AI Prompt</label>
                        <textarea
                            name="ai_prompt"
                            rows="4"
                            placeholder="Generate eerie forest encounters for a level 3 party traveling at night..."
                            class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm"
                        >{{ old('ai_prompt', $selected['ai_prompt'] ?? '') }}</textarea>
                        <p class="mt-1 text-xs text-slate-500">
                            Optional. Describe tone, party level, pacing, or any special twist.
                        </p>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Party Level</label>
                        <input
                            type="number"
                            name="party_level"
                            min="1"
                            max="20"
                            value="{{ old('party_level', $selected['party_level'] ?? '') }}"
                            placeholder="e.g. 5"
                            class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm"
                        >
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Tone</label>
                        <select
                            name="tone"
                            class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm"
                        >
                            <option value="">Any</option>
                            @foreach(['Dark','Heroic','Mysterious','Whimsical','Tense','Gritty'] as $tone)
                                <option value="{{ $tone }}"
                                    @selected(($selected['tone'] ?? null) === $tone)>
                                    {{ $tone }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid gap-2">
                        <button type="submit"
                                formaction="{{ route('encounters.roll') }}"
                                class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                            Roll Encounter
                        </button>

                        <button type="submit"
                                formaction="{{ route('encounters.aiGenerate') }}"
                                class="w-full rounded-xl bg-violet-600 px-4 py-3 text-sm font-semibold text-white hover:bg-violet-500">
                            Generate with AI
                        </button>
                    </div>
                </form>
            </div>

            {{-- RIGHT PANEL --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">

                <div class="flex items-center justify-between gap-4">
                    <div>
                        <div class="text-sm font-semibold">Encounter Table</div>
                        <div class="text-xs text-slate-500">
                            {{ ($generated['params']['source'] ?? 'manual') === 'ai' ? 'Generated with AI' : 'Generated from encounter pool' }}
                        </div>
                    </div>

                    <a href="{{ route('encounters.index') }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Clear
                    </a>
                </div>

                @if(!$generated)
                    <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950 p-6 text-sm text-slate-400">
                        Choose parameters and click <span class="text-slate-200 font-semibold">Roll</span>.
                    </div>
                @else

                    <div class="mt-3 flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                        <form method="POST" action="{{ route('encounters.save') }}" class="flex w-full gap-2 md:w-auto">
                            @csrf
                            @if($campaignId)
                                <input type="hidden"
                                       name="campaign_id"
                                       value="{{ $campaignId }}">
                            @endif
                            <input name="name"
                                   placeholder="Name this table (e.g., Forest Travel - Friendly)"
                                   class="w-full md:w-96 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm" />
                            <button class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                Save
                            </button>
                        </form>

                        <a href="{{ route('encounters.saved') }}"
                           class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                            Saved Tables
                        </a>
                    </div>
                    <div class="mt-3 overflow-auto rounded-2xl border border-slate-800 bg-slate-950">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-xs text-slate-400">
                            <tr class="border-b border-slate-800">
                                <th class="px-3 py-2 w-16">Roll</th>
                                <th class="px-3 py-2 w-24">Type</th>
                                <th class="px-3 py-2">Details</th>
                                <th class="px-3 py-2 w-40">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($generated['rows'] as $rowIndex => $row)

                                @php
                                    $e = $row['encounter'];
                                    $template = (string)($e['encounterDetails'] ?? '');

                                    preg_match_all('/\[MONSTER\]/', $template, $matches);
                                    $slotsNeeded = count($matches[0]);

                                    $selected = $row['selected_monsters'] ?? [];

                                    $i = 0;
                                    $details = preg_replace_callback('/\[MONSTER\]/', function () use (&$i, $selected) {
                                        $i++;
                                        return $selected[$i]['name'] ?? '[MONSTER]';
                                    }, $template);
                                @endphp

                                <tr class="border-b border-slate-900">
                                    <td class="px-3 py-2 font-semibold text-slate-200">
                                        {{ $row['roll'] }}
                                    </td>

                                    <td class="px-3 py-2 text-slate-300">
                                        {{ $e['encounterTypes'] ?? '—' }}
                                    </td>

                                    <td class="px-3 py-2 text-slate-200">
                                        {{ $details }}
                                    </td>

                                    <td class="px-3 py-2">
                                        @if($slotsNeeded > 0)
                                            <div class="flex flex-wrap gap-2">
                                                @for($slot = 1; $slot <= $slotsNeeded; $slot++)
                                                    <a href="{{ route('encounters.pickMonster', ['row' => $rowIndex, 'slot' => $slot, 'show' => 1, 'campaign' => $campaignId,]) }}"
                                                       class="rounded-lg border border-slate-700 px-2 py-1 text-xs hover:bg-slate-900">
                                                        {{ isset($selected[$slot]) ? "Change #{$slot}" : "Choose #{$slot}" }}
                                                    </a>
                                                @endfor
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-500">—</span>
                                        @endif
                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>

                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
