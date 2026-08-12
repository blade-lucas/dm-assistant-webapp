<x-layouts.app title="Encounter Generator">

    @php
        $typesSelected = $selected['types'] ?? [];
        $diceSelected = $selected['dice'] ?? '1d20';
    @endphp


    <div class="mx-auto max-w-7xl space-y-8">

        {{-- ============================================================
             HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-violet-500/20
                        bg-gradient-to-br from-slate-900
                        via-violet-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-80 w-80 rounded-full
                        bg-violet-500/[0.07] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-16 -top-20
                        h-48 w-48 rounded-full
                        border border-violet-500/[0.08]">
            </div>


            <div class="relative flex flex-col gap-7
                        lg:flex-row lg:items-start lg:justify-between">

                <div class="max-w-3xl">

                    <div class="mb-4 inline-flex items-center gap-2
                                rounded-full border border-violet-500/20
                                bg-violet-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-violet-300">

                        <svg class="h-3.5 w-3.5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M7 4 17 20"/>
                            <path d="M17 4 7 20"/>
                            <path d="M5 3 7 4 5 5"/>
                            <path d="M19 3 17 4 19 5"/>
                        </svg>

                        Encounter Studio
                    </div>


                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Encounter Table Generator
                    </h1>


                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                        Build randomized encounter tables from your encounter pool
                        or use AI to generate encounters tailored to party level,
                        tone, location, and campaign context.
                    </p>


                    <div class="mt-6 flex flex-wrap gap-2">

                        <span class="rounded-full border border-slate-700
                                     bg-slate-900/60 px-3 py-1.5
                                     text-xs text-slate-400">
                            Manual Tables
                        </span>

                        <span class="rounded-full border border-violet-500/20
                                     bg-violet-500/[0.06] px-3 py-1.5
                                     text-xs text-violet-300">
                            AI Generation
                        </span>

                        <span class="rounded-full border border-amber-500/20
                                     bg-amber-500/[0.06] px-3 py-1.5
                                     text-xs text-amber-300">
                            Dice Tables
                        </span>

                        @if($campaignId)
                            <span class="rounded-full border border-emerald-500/20
                                         bg-emerald-500/[0.06] px-3 py-1.5
                                         text-xs text-emerald-300">
                                Campaign-Aware
                            </span>
                        @endif

                    </div>

                </div>


                <div class="flex shrink-0 flex-wrap gap-2">

                    @if($campaignId)
                        <a href="{{ route('campaigns.encounters.index', $campaignId) }}"
                           class="inline-flex items-center gap-2
                                  rounded-xl border border-slate-700
                                  bg-slate-900/60 px-4 py-2
                                  text-sm font-medium text-slate-300
                                  transition hover:border-violet-500/30
                                  hover:bg-slate-800">

                            ← Campaign
                        </a>
                    @endif


                    <a href="{{ route('encounters.saved') }}"
                       class="inline-flex items-center gap-2
                              rounded-xl border border-slate-700
                              bg-slate-900/60 px-4 py-2
                              text-sm font-medium text-slate-300
                              transition hover:border-violet-500/30
                              hover:bg-slate-800">

                        Saved Tables
                    </a>

                </div>

            </div>
        </section>


        {{-- ============================================================
             STATUS / ERRORS
        ============================================================ --}}
        @if(session('status'))
            <div class="flex items-center gap-3 rounded-2xl
                        border border-emerald-800/60
                        bg-emerald-950/30 px-5 py-4
                        text-sm text-emerald-200">
                <span>✓</span>
                {{ session('status') }}
            </div>
        @endif


        @if($errors->any())
            <div class="rounded-2xl border border-red-900
                        bg-red-950/30 p-5 text-sm text-red-200">

                <div class="font-semibold">
                    Fix these before generating:
                </div>

                <ul class="mt-2 list-disc pl-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- ============================================================
             CAMPAIGN CONTEXT
        ============================================================ --}}
        @if($campaignId)

            <section class="relative overflow-hidden rounded-2xl
                            border border-emerald-500/20
                            bg-gradient-to-r from-emerald-950/20
                            via-slate-950 to-slate-950 p-5">

                <div class="relative flex items-start gap-4">

                    <div class="flex h-10 w-10 shrink-0 items-center
                                justify-center rounded-xl
                                border border-emerald-500/20
                                bg-emerald-500/10 text-emerald-300">
                        ✦
                    </div>


                    <div>
                        <div class="flex flex-wrap items-center gap-2">

                            <h2 class="font-semibold text-emerald-300">
                                Campaign Context Active
                            </h2>

                            <span class="rounded-full bg-emerald-500/10
                                         px-2 py-0.5 text-[10px]
                                         font-semibold uppercase tracking-wider
                                         text-emerald-400">
                                AI Context
                            </span>

                        </div>


                        <p class="mt-1 max-w-3xl text-sm leading-6
                                  text-slate-400">
                            AI encounters can reference campaign characters,
                            recent sessions, important events, unresolved hooks,
                            and other relevant campaign information.
                        </p>

                    </div>

                </div>
            </section>

        @endif


        {{-- ============================================================
             WORKSPACE
        ============================================================ --}}
        <div class="grid gap-6 lg:grid-cols-[380px_minmax(0,1fr)]">

            {{-- ========================================================
                 PARAMETERS
            ======================================================== --}}
            <aside class="overflow-hidden rounded-3xl
                          border border-slate-800 bg-slate-950">

                <div class="border-b border-slate-800 px-5 py-4">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] text-violet-400">
                        Step 1
                    </p>

                    <h2 class="mt-1 text-lg font-semibold text-slate-100">
                        Encounter Parameters
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Control where, how, and what kind of encounters appear.
                    </p>

                </div>


                <form method="POST"
                      action="{{ route('encounters.roll') }}"
                      class="grid gap-5 p-5">

                    @csrf

                    @if($campaignId)
                        <input type="hidden"
                               name="campaign_id"
                               value="{{ $campaignId }}">
                    @endif


                    {{-- LOCATION --}}
                    <div class="grid gap-4">

                        <div>
                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Location Type
                            </label>

                            <select name="location_type"
                                    class="mt-2 w-full rounded-xl
                                           border border-slate-800
                                           bg-slate-950 px-4 py-3
                                           text-sm text-slate-100
                                           outline-none transition
                                           focus:border-violet-500/40">

                                <option value="">Any Location</option>

                                @foreach($locationTypes as $t)
                                    <option value="{{ $t }}"
                                        @selected(($selected['location_type'] ?? null) === $t)>
                                        {{ $t }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                        <div>
                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Location Subtype
                            </label>

                            <select name="location_subtype"
                                    class="mt-2 w-full rounded-xl
                                           border border-slate-800
                                           bg-slate-950 px-4 py-3
                                           text-sm text-slate-100
                                           outline-none transition
                                           focus:border-violet-500/40">

                                <option value="">Any Subtype</option>

                                @foreach($subtypes as $st)
                                    <option value="{{ $st }}"
                                        @selected(($selected['location_subtype'] ?? null) === $st)>
                                        {{ $st }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>


                    {{-- ENCOUNTER TYPES --}}
                    <div>

                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Encounter Types
                        </label>


                        <div class="mt-2 grid grid-cols-2 gap-2">

                            @foreach(['Combat','Friendly','Interaction','Puzzle'] as $value)

                                <label class="flex cursor-pointer items-center
                                              gap-2 rounded-xl border
                                              border-slate-800 bg-slate-950
                                              px-3 py-2.5 text-sm
                                              text-slate-300 transition
                                              hover:border-violet-500/30
                                              hover:bg-slate-900">

                                    <input type="checkbox"
                                           name="types[]"
                                           value="{{ $value }}"
                                           @checked(in_array($value, $typesSelected, true))
                                           class="accent-violet-500">

                                    {{ $value }}

                                </label>

                            @endforeach

                        </div>
                    </div>


                    {{-- DICE --}}
                    <div>

                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Encounter Table Dice
                        </label>


                        <div class="mt-2 grid grid-cols-2 gap-2">

                            @foreach(['1d20','1d12','2d6','1d12+1d6'] as $opt)

                                <label class="flex cursor-pointer items-center
                                              gap-2 rounded-xl border
                                              border-slate-800 bg-slate-950
                                              px-3 py-2.5 text-sm
                                              text-slate-300 transition
                                              hover:border-amber-500/30
                                              hover:bg-slate-900">

                                    <input type="radio"
                                           name="dice"
                                           value="{{ $opt }}"
                                           @checked($diceSelected === $opt)
                                           class="accent-amber-400">

                                    <span class="font-mono">
                                        {{ strtoupper($opt) }}
                                    </span>

                                </label>

                            @endforeach

                        </div>
                    </div>


                    {{-- AI SETTINGS --}}
                    <div class="border-t border-slate-800 pt-5">

                        <div class="mb-4">
                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.14em] text-violet-400">
                                AI Options
                            </p>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Used when generating a custom AI table.
                            </p>
                        </div>


                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            AI Prompt
                        </label>

                        <textarea name="ai_prompt"
                                  rows="4"
                                  placeholder="Generate eerie forest encounters for a level 3 party traveling at night..."
                                  class="mt-2 w-full rounded-xl
                                         border border-slate-800
                                         bg-slate-950 px-4 py-3
                                         text-sm leading-6 text-slate-100
                                         outline-none
                                         placeholder:text-slate-600
                                         focus:border-violet-500/40">{{ old('ai_prompt', $selected['ai_prompt'] ?? '') }}</textarea>

                    </div>


                    <div class="grid grid-cols-2 gap-3">

                        <div>
                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Party Level
                            </label>

                            <input type="number"
                                   name="party_level"
                                   min="1"
                                   max="20"
                                   value="{{ old('party_level', $selected['party_level'] ?? '') }}"
                                   placeholder="5"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none
                                          placeholder:text-slate-600
                                          focus:border-violet-500/40">
                        </div>


                        <div>
                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Tone
                            </label>

                            <select name="tone"
                                    class="mt-2 w-full rounded-xl
                                           border border-slate-800
                                           bg-slate-950 px-4 py-3
                                           text-sm text-slate-100
                                           outline-none
                                           focus:border-violet-500/40">

                                <option value="">Any</option>

                                @foreach(['Dark','Heroic','Mysterious','Whimsical','Tense','Gritty'] as $tone)
                                    <option value="{{ $tone }}"
                                        @selected(($selected['tone'] ?? null) === $tone)>
                                        {{ $tone }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>


                    {{-- ACTIONS --}}
                    <div class="grid gap-2 border-t border-slate-800 pt-5">

                        <button type="submit"
                                formaction="{{ route('encounters.roll') }}"
                                class="inline-flex w-full items-center
                                       justify-center gap-2 rounded-xl
                                       border border-amber-500/30
                                       bg-amber-500/10 px-4 py-3
                                       text-sm font-semibold text-amber-300
                                       transition hover:bg-amber-500/20">

                            🎲 Roll from Encounter Pool

                        </button>


                        <button type="submit"
                                formaction="{{ route('encounters.aiGenerate') }}"
                                class="inline-flex w-full items-center
                                       justify-center gap-2 rounded-xl
                                       bg-violet-500 px-4 py-3
                                       text-sm font-semibold text-white
                                       transition hover:bg-violet-400">

                            ✦ Generate with AI

                        </button>

                    </div>

                </form>
            </aside>


            {{-- ========================================================
                 RESULT PANEL
            ======================================================== --}}
            <section class="overflow-hidden rounded-3xl
                            border border-violet-500/20
                            bg-slate-950">

                <div class="flex flex-col gap-4
                            border-b border-slate-800
                            bg-gradient-to-r from-violet-950/20
                            to-slate-950 px-6 py-5
                            sm:flex-row sm:items-center
                            sm:justify-between">

                    <div>

                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.16em] text-violet-400">
                            Step 2
                        </p>

                        <h2 class="mt-1 text-lg font-semibold text-slate-100">
                            Encounter Table
                        </h2>


                        @if($generated)

                            <div class="mt-2 flex flex-wrap gap-2">

                                @if(($generated['params']['source'] ?? 'manual') === 'ai')

                                    <span class="rounded-full
                                                 border border-violet-500/20
                                                 bg-violet-500/10
                                                 px-2.5 py-1
                                                 text-[10px] font-semibold
                                                 uppercase tracking-wider
                                                 text-violet-300">
                                        ✦ AI Generated
                                    </span>

                                @else

                                    <span class="rounded-full
                                                 border border-slate-700
                                                 bg-slate-900
                                                 px-2.5 py-1
                                                 text-[10px] font-semibold
                                                 uppercase tracking-wider
                                                 text-slate-400">
                                        Encounter Pool
                                    </span>

                                @endif


                                @if(data_get($generated, 'params.campaign_context_used'))

                                    <span class="rounded-full
                                                 border border-emerald-500/20
                                                 bg-emerald-500/10
                                                 px-2.5 py-1
                                                 text-[10px] font-semibold
                                                 uppercase tracking-wider
                                                 text-emerald-300">
                                        ✦ Campaign Context
                                    </span>

                                @endif


                                <span class="rounded-full
                                             border border-amber-500/20
                                             bg-amber-500/[0.06]
                                             px-2.5 py-1
                                             text-[10px] font-semibold
                                             uppercase tracking-wider
                                             text-amber-300">
                                    {{ strtoupper($generated['params']['dice'] ?? $diceSelected) }}
                                </span>

                            </div>

                        @endif

                    </div>


                    @if($generated)

                        <a href="{{ route('encounters.index', $campaignId ? ['campaign' => $campaignId] : []) }}"
                           class="rounded-xl border border-slate-700
                                  px-4 py-2 text-sm text-slate-400
                                  transition hover:bg-slate-900
                                  hover:text-white">
                            Clear
                        </a>

                    @endif

                </div>


                @if(!$generated)

                    {{-- EMPTY --}}
                    <div class="flex min-h-[620px] flex-col
                                items-center justify-center
                                px-8 text-center">

                        <div class="flex h-16 w-16 items-center
                                    justify-center rounded-2xl
                                    border border-violet-500/20
                                    bg-violet-500/10
                                    text-2xl text-violet-300">
                            ⚔
                        </div>

                        <h3 class="mt-5 text-lg font-semibold text-slate-200">
                            No encounter table generated yet
                        </h3>

                        <p class="mt-2 max-w-md text-sm
                                  leading-6 text-slate-500">
                            Choose your parameters, then roll from the encounter
                            pool or generate a custom table with AI.
                        </p>

                    </div>


                @else

                    {{-- ====================================================
                         SAVE BAR
                    ==================================================== --}}
                    <div class="border-b border-slate-800
                                bg-slate-900/20 p-4">

                        <div class="flex flex-col gap-3
                                    xl:flex-row xl:items-center
                                    xl:justify-between">


                            <form method="POST"
                                  action="{{ route('encounters.save') }}"
                                  class="flex flex-1 flex-col gap-2
                                         sm:flex-row">

                                @csrf

                                @if($campaignId)
                                    <input type="hidden"
                                           name="campaign_id"
                                           value="{{ $campaignId }}">
                                @endif


                                <input name="name"
                                       placeholder="Name this encounter table..."
                                       class="w-full rounded-xl border
                                              border-slate-800 bg-slate-950
                                              px-4 py-2.5 text-sm
                                              text-slate-100 outline-none
                                              placeholder:text-slate-600
                                              focus:border-violet-500/40">


                                <button class="shrink-0 rounded-xl
                                               bg-violet-500 px-5 py-2.5
                                               text-sm font-semibold text-white
                                               transition hover:bg-violet-400">
                                    Save Table
                                </button>

                            </form>


                            <div class="flex flex-wrap gap-2">

                                @if($campaignId)

                                    <a href="{{ route('campaigns.encounters.index', $campaignId) }}"
                                       class="rounded-xl border
                                              border-emerald-500/20
                                              bg-emerald-500/10
                                              px-4 py-2.5 text-sm
                                              font-medium text-emerald-300
                                              transition
                                              hover:bg-emerald-500/20">
                                        Campaign
                                    </a>

                                @endif


                                <a href="{{ route('encounters.saved') }}"
                                   class="rounded-xl border border-slate-700
                                          px-4 py-2.5 text-sm
                                          text-slate-400 transition
                                          hover:bg-slate-900
                                          hover:text-white">
                                    Saved Tables
                                </a>

                            </div>

                        </div>
                    </div>


                    {{-- ====================================================
                         TABLE
                    ==================================================== --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full text-sm">

                            <thead class="bg-slate-900/40
                                          text-left text-xs
                                          uppercase tracking-wide
                                          text-slate-500">

                            <tr class="border-b border-slate-800">

                                <th class="w-20 px-5 py-3">
                                    Roll
                                </th>

                                <th class="w-32 px-5 py-3">
                                    Type
                                </th>

                                <th class="px-5 py-3">
                                    Encounter
                                </th>

                                <th class="w-44 px-5 py-3">
                                    Monsters
                                </th>

                            </tr>

                            </thead>


                            <tbody>

                            @foreach($generated['rows'] as $rowIndex => $row)

                                @php
                                    $e = $row['encounter'];
                                    $template = (string)($e['encounterDetails'] ?? '');

                                    preg_match_all('/\[MONSTER\]/', $template, $matches);
                                    $slotsNeeded = count($matches[0]);

                                    $selectedMonsters = $row['selected_monsters'] ?? [];

                                    $i = 0;

                                    $details = preg_replace_callback(
                                        '/\[MONSTER\]/',
                                        function () use (&$i, $selectedMonsters) {
                                            $i++;
                                            return $selectedMonsters[$i]['name'] ?? '[MONSTER]';
                                        },
                                        $template
                                    );
                                @endphp


                                <tr class="border-b border-slate-900
                                               transition
                                               hover:bg-slate-900/30">

                                    {{-- ROLL --}}
                                    <td class="px-5 py-4 align-top">

                                            <span class="inline-flex min-w-10
                                                         items-center justify-center
                                                         rounded-lg
                                                         border border-amber-500/20
                                                         bg-amber-500/[0.06]
                                                         px-2.5 py-1.5
                                                         font-mono font-bold
                                                         text-amber-300">
                                                {{ $row['roll'] }}
                                            </span>

                                    </td>


                                    {{-- TYPE --}}
                                    <td class="px-5 py-4 align-top">

                                            <span class="rounded-full
                                                         border border-slate-700
                                                         bg-slate-900
                                                         px-2.5 py-1
                                                         text-xs text-slate-300">
                                                {{ $e['encounterTypes'] ?? '—' }}
                                            </span>

                                    </td>


                                    {{-- DETAILS --}}
                                    <td class="px-5 py-4 align-top
                                                   leading-6 text-slate-300">

                                        {{ $details }}

                                    </td>


                                    {{-- MONSTERS --}}
                                    <td class="px-5 py-4 align-top">

                                        @if($slotsNeeded > 0)

                                            <div class="flex flex-wrap gap-2">

                                                @for($slot = 1; $slot <= $slotsNeeded; $slot++)

                                                    <a href="{{ route('encounters.pickMonster', [
                                                                'row' => $rowIndex,
                                                                'slot' => $slot,
                                                                'show' => 1,
                                                                'campaign' => $campaignId,
                                                            ]) }}"
                                                       class="rounded-lg
                                                                  border border-violet-500/20
                                                                  bg-violet-500/[0.06]
                                                                  px-2.5 py-1.5
                                                                  text-xs font-medium
                                                                  text-violet-300
                                                                  transition
                                                                  hover:bg-violet-500/15">

                                                        {{ isset($selectedMonsters[$slot])
                                                            ? "Change #{$slot}"
                                                            : "Choose #{$slot}" }}

                                                    </a>

                                                @endfor

                                            </div>

                                        @else

                                            <span class="text-xs text-slate-600">
                                                    —
                                                </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                            </tbody>
                        </table>
                    </div>

                @endif

            </section>

        </div>

    </div>

</x-layouts.app>
