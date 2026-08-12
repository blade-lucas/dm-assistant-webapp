<x-layouts.app title="Monster Manual">

    <div class="mx-auto max-w-6xl space-y-8">

        {{-- ============================================================
             HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-red-500/20
                        bg-gradient-to-br from-slate-900
                        via-red-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-80 w-80 rounded-full
                        bg-red-500/[0.06] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-16 -top-20
                        h-48 w-48 rounded-full
                        border border-red-500/[0.08]">
            </div>

            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div class="max-w-3xl">

                    <div class="mb-4 inline-flex items-center gap-2
                                rounded-full border border-red-500/20
                                bg-red-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-red-300">

                        <svg class="h-3.5 w-3.5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <circle cx="12" cy="12" r="8"/>
                            <path d="M9 10h.01"/>
                            <path d="M15 10h.01"/>
                            <path d="M9 15c1.8-1.2 4.2-1.2 6 0"/>
                        </svg>

                        Creature Repository
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Monster Manual
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6
                              text-slate-400">
                        Browse creatures by name, type, and challenge rating,
                        then inspect complete combat statistics, lore, abilities,
                        and actions.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-2">

                        <span class="rounded-full border border-red-500/20
                                     bg-red-500/[0.06]
                                     px-3 py-1.5 text-xs text-red-300">
                            Creature Database
                        </span>

                        <span class="rounded-full border border-amber-500/20
                                     bg-amber-500/[0.06]
                                     px-3 py-1.5 text-xs text-amber-300">
                            Challenge Rating
                        </span>

                        <span class="rounded-full border border-slate-700
                                     bg-slate-900/60
                                     px-3 py-1.5 text-xs text-slate-400">
                            Full Stat Blocks
                        </span>

                    </div>

                </div>

            </div>
        </section>


        {{-- ============================================================
             FILTERS
        ============================================================ --}}
        <section class="overflow-hidden rounded-3xl
                        border border-slate-800 bg-slate-950">

            <div class="border-b border-slate-800 px-6 py-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-red-400">
                    Search the Manual
                </p>

                <h2 class="mt-1 text-lg font-semibold text-slate-100">
                    Find a creature
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Search directly or narrow results by creature type
                    and challenge rating.
                </p>

            </div>


            <form method="GET"
                  action="{{ route('monsters.index') }}"
                  class="grid gap-5 p-6 md:grid-cols-12">

                {{-- SEARCH --}}
                <div class="md:col-span-6">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Search
                    </label>

                    <input name="q"
                           value="{{ $q }}"
                           placeholder="Aarakocra, goblin, dragon..."
                           class="mt-2 w-full rounded-xl
                                  border border-slate-800
                                  bg-slate-950 px-4 py-3
                                  text-sm text-slate-100
                                  outline-none transition
                                  placeholder:text-slate-600
                                  focus:border-red-500/40
                                  focus:ring-1 focus:ring-red-500/20">

                </div>


                {{-- TYPE --}}
                <div class="md:col-span-3">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Creature Type
                    </label>

                    <select name="type"
                            class="mt-2 w-full rounded-xl
                                   border border-slate-800
                                   bg-slate-950 px-4 py-3
                                   text-sm text-slate-100
                                   outline-none transition
                                   focus:border-red-500/40">

                        <option value="">All Types</option>

                        @foreach($types as $t)
                            <option value="{{ $t }}"
                                @selected($type === $t)>
                                {{ $t }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- CR --}}
                <div class="md:col-span-3">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Maximum CR
                    </label>

                    <input name="max_cr"
                           value="{{ $maxCr }}"
                           placeholder="e.g. 1, 5, 10"
                           class="mt-2 w-full rounded-xl
                                  border border-slate-800
                                  bg-slate-950 px-4 py-3
                                  text-sm text-slate-100
                                  outline-none transition
                                  placeholder:text-slate-600
                                  focus:border-amber-500/40">

                </div>


                {{-- FILTER ACTIONS --}}
                <div class="md:col-span-12 flex flex-col gap-4
                            border-t border-slate-800 pt-5
                            xl:flex-row xl:items-center">

                    <div class="flex flex-wrap gap-2">

                        <button type="submit"
                                class="inline-flex items-center gap-2
                                       rounded-xl bg-red-500
                                       px-5 py-2.5 text-sm
                                       font-semibold text-white
                                       transition hover:bg-red-400">

                            Search
                        </button>


                        <a href="{{ route('monsters.index') }}"
                           class="rounded-xl border border-slate-700
                                  px-4 py-2.5 text-sm text-slate-400
                                  transition hover:bg-slate-900
                                  hover:text-white">
                            Reset
                        </a>

                    </div>


                    {{-- QUICK CR --}}
                    <div class="flex flex-wrap items-center gap-2
                                xl:ml-4">

                        <span class="mr-1 text-[10px] font-semibold
                                     uppercase tracking-[0.14em]
                                     text-slate-600">
                            Quick CR
                        </span>

                        @php
                            $noCrFilter = empty($maxCr);
                        @endphp

                        <a href="{{ route('monsters.index', [
        'q' => $q,
        'type' => $type
    ]) }}"
                           class="rounded-lg border px-3 py-1.5 text-xs font-medium transition
          {{ $noCrFilter
              ? 'border-slate-300 bg-slate-200 text-slate-950'
              : 'border-slate-700 bg-slate-900 text-slate-400 hover:bg-slate-800' }}">
                            Any
                        </a>

                        @foreach([
                            '0–1' => 1,
                            '1–5' => 5,
                            '5–10' => 10,
                            '10+' => 999
                        ] as $label => $value)

                            @php
                                $isActiveCr = (string) $maxCr === (string) $value;
                            @endphp

                            <a href="{{ route('monsters.index', [
                                'q' => $q,
                                'type' => $type,
                                'max_cr' => $value
                            ]) }}"
                               class="rounded-lg border px-3 py-1.5 text-xs font-medium transition
              {{ $isActiveCr
                  ? 'border-amber-400 bg-amber-400 text-slate-950 shadow-sm shadow-amber-500/20'
                  : 'border-amber-500/20 bg-amber-500/[0.04] text-amber-300 hover:bg-amber-500/10' }}">

                                {{ $label }}

                            </a>

                        @endforeach

                    </div>


                    <div class="xl:ml-auto">

                        <span class="rounded-full border border-slate-700
                                     bg-slate-900 px-3 py-1.5
                                     text-xs text-slate-400">

                            Results:
                            <span class="font-semibold text-slate-200">
                                {{ count($results) }}
                            </span>

                        </span>

                    </div>

                </div>

            </form>
        </section>


        {{-- ============================================================
             MAIN BROWSER
        ============================================================ --}}
        <div class="grid gap-6 lg:grid-cols-[360px_minmax(0,1fr)]">

            {{-- ========================================================
                 MONSTER LIST
            ======================================================== --}}
            <section class="overflow-hidden rounded-3xl
                            border border-slate-800 bg-slate-950">

                <div class="flex items-center justify-between
                            border-b border-slate-800
                            bg-gradient-to-r from-red-950/10
                            to-slate-950 px-5 py-4">

                    <div>

                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.14em] text-red-400">
                            Bestiary
                        </p>

                        <h2 class="mt-1 font-semibold text-slate-100">
                            Monsters
                        </h2>

                    </div>

                    <span class="text-xs text-slate-600">
                        Select to inspect
                    </span>

                </div>


                <div class="h-[70vh] overflow-y-auto p-2">

                    @forelse($results as $m)

                        @php
                            $slug = \Illuminate\Support\Str::slug($m['m_name'] ?? '');
                            $isActive = $slug === $selectedSlug;

                            $cr = $m['m_cr'] ?? null;
                            $crVal = is_numeric($cr) ? (float) $cr : null;

                            $crClass = 'border-slate-700 bg-slate-900 text-slate-400';

                            if ($crVal !== null) {
                                if ($crVal <= 1) {
                                    $crClass = 'border-emerald-500/20 bg-emerald-500/10 text-emerald-300';
                                } elseif ($crVal <= 5) {
                                    $crClass = 'border-amber-500/20 bg-amber-500/10 text-amber-300';
                                } else {
                                    $crClass = 'border-red-500/20 bg-red-500/10 text-red-300';
                                }
                            }
                        @endphp


                        <a href="{{ route('monsters.index', [
                                'q' => $q,
                                'type' => $type,
                                'max_cr' => $maxCr,
                                'monster' => $slug
                            ]) }}"
                           class="group mb-1 block rounded-xl
                                  border px-3 py-3 transition
                                  {{ $isActive
                                      ? 'border-red-500/30 bg-red-500/[0.07]'
                                      : 'border-transparent hover:border-slate-800 hover:bg-slate-900/70' }}">

                            <div class="flex items-start justify-between gap-3">

                                <div class="min-w-0">

                                    <div class="truncate text-sm font-semibold
                                                {{ $isActive ? 'text-red-200' : 'text-slate-200' }}">
                                        {{ $m['m_name'] ?? 'Unnamed' }}
                                    </div>


                                    <div class="mt-2 flex flex-wrap items-center gap-2">

                                        <span class="text-xs text-slate-500">
                                            {{ $m['m_type'] ?? '—' }}
                                        </span>

                                        <span class="rounded-full border
                                                     px-2 py-0.5 text-[10px]
                                                     font-semibold {{ $crClass }}">
                                            CR {{ $cr ?? '—' }}
                                        </span>

                                    </div>

                                </div>


                                <div class="shrink-0 rounded-lg
                                            border border-blue-500/10
                                            bg-blue-500/[0.04]
                                            px-2 py-1
                                            text-[10px] font-semibold
                                            text-blue-300">
                                    AC {{ $m['m_ac'] ?? '—' }}
                                </div>

                            </div>

                        </a>


                    @empty

                        <div class="flex h-48 flex-col items-center
                                    justify-center px-6 text-center">

                            <div class="flex h-11 w-11 items-center
                                        justify-center rounded-xl
                                        bg-red-500/10 text-red-300">
                                ?
                            </div>

                            <p class="mt-3 text-sm font-medium text-slate-300">
                                No monsters found
                            </p>

                            <p class="mt-1 text-xs text-slate-600">
                                Try adjusting your search filters.
                            </p>

                        </div>

                    @endforelse

                </div>
            </section>


            {{-- ========================================================
                 DETAIL PANEL
            ======================================================== --}}
            <section class="overflow-hidden rounded-3xl
                            border border-red-500/20
                            bg-slate-950">

                @if(!$selected)

                    <div class="flex min-h-[70vh] flex-col
                                items-center justify-center
                                px-8 text-center">

                        <div class="flex h-16 w-16 items-center
                                    justify-center rounded-2xl
                                    border border-red-500/20
                                    bg-red-500/10 text-red-300">

                            <svg class="h-8 w-8"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.6">
                                <circle cx="12" cy="12" r="8"/>
                                <path d="M9 10h.01"/>
                                <path d="M15 10h.01"/>
                            </svg>

                        </div>

                        <h2 class="mt-5 text-lg font-semibold
                                   text-slate-200">
                            Select a monster
                        </h2>

                        <p class="mt-2 max-w-sm text-sm leading-6
                                  text-slate-500">
                            Choose a creature from the bestiary to view
                            its complete statistics, abilities, lore, and actions.
                        </p>

                    </div>


                @else

                    @php
                        $name = $selected['m_name'] ?? 'Unnamed';
                    @endphp


                    {{-- ====================================================
                         MONSTER HEADER
                    ==================================================== --}}
                    <div class="relative overflow-hidden
                                border-b border-slate-800
                                bg-gradient-to-br
                                from-red-950/20 to-slate-950
                                p-6">

                        <div class="pointer-events-none absolute
                                    -right-16 -top-16 h-48 w-48
                                    rounded-full bg-red-500/[0.05]
                                    blur-2xl">
                        </div>


                        <div class="relative flex flex-col gap-5
                                    md:flex-row md:items-start
                                    md:justify-between">

                            <div>

                                <div class="mb-2 flex flex-wrap gap-2">

                                    <span class="rounded-full
                                                 border border-red-500/20
                                                 bg-red-500/10
                                                 px-2.5 py-1
                                                 text-[10px] font-semibold
                                                 uppercase tracking-wider
                                                 text-red-300">

                                        {{ $selected['m_type'] ?? 'Unknown' }}

                                    </span>

                                    <span class="rounded-full
                                                 border border-amber-500/20
                                                 bg-amber-500/[0.06]
                                                 px-2.5 py-1
                                                 text-[10px] font-semibold
                                                 uppercase tracking-wider
                                                 text-amber-300">

                                        CR {{ $selected['m_cr'] ?? '—' }}

                                    </span>

                                </div>


                                <h2 class="text-3xl font-bold
                                           tracking-tight text-slate-50">
                                    {{ $name }}
                                </h2>


                                <div class="mt-2 text-sm text-slate-400">

                                    {{ $selected['m_size'] ?? '—' }}
                                    {{ $selected['m_type'] ?? '—' }}

                                    <span class="mx-1 text-red-500/50">•</span>

                                    {{ $selected['m_alignment'] ?? '—' }}

                                    <span class="mx-1 text-red-500/50">•</span>

                                    {{ $selected['m_exp'] ?? '—' }} XP

                                </div>

                            </div>


                            {{-- COMBAT SUMMARY --}}
                            <div class="grid min-w-[230px]
                                        grid-cols-3 gap-2">

                                <div class="rounded-xl border
                                            border-blue-500/20
                                            bg-blue-500/[0.06]
                                            p-3 text-center">

                                    <div class="text-[10px] font-semibold
                                                uppercase tracking-wider
                                                text-blue-400">
                                        AC
                                    </div>

                                    <div class="mt-1 text-xl font-bold
                                                text-blue-200">
                                        {{ $selected['m_ac'] ?? '—' }}
                                    </div>

                                </div>


                                <div class="rounded-xl border
                                            border-red-500/20
                                            bg-red-500/[0.06]
                                            p-3 text-center">

                                    <div class="text-[10px] font-semibold
                                                uppercase tracking-wider
                                                text-red-400">
                                        HP
                                    </div>

                                    <div class="mt-1 text-xl font-bold
                                                text-red-200">
                                        {{ $selected['m_defaultHP'] ?? '—' }}
                                    </div>

                                </div>


                                <div class="rounded-xl border
                                            border-emerald-500/20
                                            bg-emerald-500/[0.06]
                                            p-3 text-center">

                                    <div class="text-[10px] font-semibold
                                                uppercase tracking-wider
                                                text-emerald-400">
                                        Speed
                                    </div>

                                    <div class="mt-1 text-sm font-bold
                                                text-emerald-200">
                                        {{ $selected['m_speed'] ?? '—' }}
                                    </div>

                                </div>

                            </div>

                        </div>


                        @if(!empty($selected['m_specialSpeed']))
                            <div class="relative mt-3 text-xs text-slate-500">
                                Additional movement:
                                <span class="text-slate-300">
                                    {{ $selected['m_specialSpeed'] }}
                                </span>
                            </div>
                        @endif

                    </div>


                    <div class="p-6">

                        {{-- ====================================================
                             ABILITY SCORES
                        ==================================================== --}}
                        <section>

                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.15em] text-red-400">
                                Ability Scores
                            </p>


                            <div class="mt-3 grid grid-cols-3 gap-2
                                        sm:grid-cols-6">

                                @foreach([
                                    'STR' => 'm_str',
                                    'DEX' => 'm_dex',
                                    'CON' => 'm_con',
                                    'INT' => 'm_int',
                                    'WIS' => 'm_wis',
                                    'CHA' => 'm_cha',
                                ] as $label => $key)

                                    <div class="rounded-xl border
                                                border-slate-800
                                                bg-slate-900/30
                                                p-3 text-center">

                                        <div class="text-[10px] font-semibold
                                                    uppercase tracking-wider
                                                    text-slate-500">
                                            {{ $label }}
                                        </div>

                                        <div class="mt-1 text-lg font-bold
                                                    text-slate-100">
                                            {{ $selected[$key] ?? '—' }}
                                        </div>

                                    </div>

                                @endforeach

                            </div>
                        </section>


                        {{-- ====================================================
                             GENERAL INFO
                        ==================================================== --}}
                        @if(
                            !empty($selected['m_skills']) ||
                            !empty($selected['m_senses']) ||
                            !empty($selected['m_languages']) ||
                            !empty($selected['m_damageResistance']) ||
                            !empty($selected['m_conditionImmunity'])
                        )

                            <section class="mt-6 rounded-2xl
                                            border border-slate-800
                                            bg-slate-900/20 p-5">

                                <div class="grid gap-3 text-sm">

                                    @if(!empty($selected['m_skills']))
                                        <div>
                                            <span class="font-medium text-slate-500">
                                                Skills
                                            </span>
                                            <span class="ml-2 text-slate-300">
                                                {{ $selected['m_skills'] }}
                                            </span>
                                        </div>
                                    @endif


                                    @if(!empty($selected['m_senses']))
                                        <div>
                                            <span class="font-medium text-slate-500">
                                                Senses
                                            </span>
                                            <span class="ml-2 text-slate-300">
                                                {{ $selected['m_senses'] }}
                                            </span>
                                        </div>
                                    @endif


                                    @if(!empty($selected['m_languages']))
                                        <div>
                                            <span class="font-medium text-slate-500">
                                                Languages
                                            </span>
                                            <span class="ml-2 text-slate-300">
                                                {{ $selected['m_languages'] }}
                                            </span>
                                        </div>
                                    @endif


                                    @if(!empty($selected['m_damageResistance']))
                                        <div>
                                            <span class="font-medium text-slate-500">
                                                Resistances
                                            </span>
                                            <span class="ml-2 text-slate-300">
                                                {{ $selected['m_damageResistance'] }}
                                            </span>
                                        </div>
                                    @endif


                                    @if(!empty($selected['m_conditionImmunity']))
                                        <div>
                                            <span class="font-medium text-slate-500">
                                                Condition Immunities
                                            </span>
                                            <span class="ml-2 text-slate-300">
                                                {{ $selected['m_conditionImmunity'] }}
                                            </span>
                                        </div>
                                    @endif

                                </div>
                            </section>

                        @endif


                        {{-- ====================================================
                             DESCRIPTION
                        ==================================================== --}}
                        @php
                            $desc = $selected['m_desc'] ?? [];
                        @endphp

                        @if(is_array($desc) && count($desc))

                            <section class="mt-8">

                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.15em] text-amber-400">
                                    Lore
                                </p>

                                <h3 class="mt-1 text-lg font-semibold
                                           text-slate-100">
                                    Description
                                </h3>


                                <div class="mt-4 grid gap-3">

                                    @foreach($desc as $d)

                                        <div class="rounded-2xl border
                                                    border-amber-500/10
                                                    bg-amber-500/[0.025]
                                                    p-5">

                                            @if(!empty($d['title']))
                                                <div class="font-semibold
                                                            text-amber-200">
                                                    {{ $d['title'] }}
                                                </div>
                                            @endif

                                            <div class="mt-2 text-sm
                                                        leading-6 text-slate-300">
                                                {{ $d['description'] ?? '' }}
                                            </div>

                                        </div>

                                    @endforeach

                                </div>
                            </section>

                        @endif


                        {{-- ====================================================
                             ABILITIES
                        ==================================================== --}}
                        @php
                            $abilities = $selected['m_abilities'] ?? [];
                        @endphp

                        @if(is_array($abilities) && count($abilities))

                            <section class="mt-8">

                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.15em] text-violet-400">
                                    Traits
                                </p>

                                <h3 class="mt-1 text-lg font-semibold
                                           text-slate-100">
                                    Abilities
                                </h3>


                                <div class="mt-4 grid gap-3">

                                    @foreach($abilities as $a)

                                        <div class="rounded-2xl border
                                                    border-violet-500/10
                                                    bg-violet-500/[0.025]
                                                    p-5">

                                            <div class="font-semibold
                                                        text-violet-200">
                                                {{ $a['name'] ?? 'Ability' }}
                                            </div>

                                            <div class="mt-2 text-sm
                                                        leading-6 text-slate-300">
                                                {{ $a['description'] ?? '' }}
                                            </div>

                                        </div>

                                    @endforeach

                                </div>
                            </section>

                        @endif


                        {{-- ====================================================
                             ACTIONS
                        ==================================================== --}}
                        @php
                            $actions = $selected['m_actions'] ?? [];
                        @endphp

                        @if(is_array($actions) && count($actions))

                            <section class="mt-8">

                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.15em] text-red-400">
                                    Combat
                                </p>

                                <h3 class="mt-1 text-lg font-semibold
                                           text-slate-100">
                                    Actions
                                </h3>


                                <div class="mt-4 grid gap-3">

                                    @foreach($actions as $a)

                                        <div class="rounded-2xl border
                                                    border-red-500/10
                                                    bg-red-500/[0.025]
                                                    p-5">

                                            <div class="flex flex-col gap-2
                                                        sm:flex-row
                                                        sm:items-start
                                                        sm:justify-between">

                                                <div class="font-semibold
                                                            text-red-200">
                                                    {{ $a['name'] ?? 'Action' }}
                                                </div>


                                                @if(!empty($a['roll']))

                                                    <span class="shrink-0
                                                                 rounded-full
                                                                 border border-amber-500/20
                                                                 bg-amber-500/[0.06]
                                                                 px-2.5 py-1
                                                                 font-mono text-[10px]
                                                                 font-semibold
                                                                 text-amber-300">

                                                        {{ $a['roll'] }}

                                                    </span>

                                                @endif

                                            </div>


                                            <div class="mt-2 text-sm
                                                        leading-6 text-slate-300">
                                                {{ $a['description'] ?? '' }}
                                            </div>

                                        </div>

                                    @endforeach

                                </div>
                            </section>

                        @endif

                    </div>

                @endif

            </section>

        </div>

    </div>

</x-layouts.app>
