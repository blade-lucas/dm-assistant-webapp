<x-layouts.app title="Pick Monster">

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

            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div class="max-w-3xl">

                    <div class="mb-4 inline-flex items-center gap-2
                                rounded-full border border-red-500/20
                                bg-red-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-red-300">

                        Monster Selection
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Pick Monster #{{ $slot }}
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        Choose the creature that will replace
                        <span class="font-semibold text-violet-300">[MONSTER]</span>
                        in encounter row
                        <span class="font-semibold text-slate-200">
                            #{{ $row + 1 }}
                        </span>.
                    </p>

                    @if($encounter)
                        <div class="mt-5 rounded-2xl border
                                    border-violet-500/20
                                    bg-violet-500/[0.06]
                                    px-4 py-3">

                            <p class="text-[10px] font-semibold uppercase
                                      tracking-[0.14em] text-violet-400">
                                Encounter Template
                            </p>

                            <p class="mt-1 text-sm leading-6 text-slate-300">
                                {{ $encounter['encounterDetails'] ?? '' }}
                            </p>

                        </div>
                    @endif

                </div>


                <a href="{{ route('encounters.index', [
                        'show' => 1,
                        'campaign' => $campaignId,
                    ]) }}"
                   class="inline-flex shrink-0 items-center gap-2
                          rounded-xl border border-slate-700
                          bg-slate-900/60 px-4 py-2
                          text-sm font-medium text-slate-300
                          transition hover:border-violet-500/30
                          hover:bg-slate-800">

                    ← Back to Encounter
                </a>

            </div>
        </section>


        {{-- ============================================================
             SEARCH / FILTERS
        ============================================================ --}}
        <section class="overflow-hidden rounded-3xl
                        border border-slate-800 bg-slate-950">

            <div class="border-b border-slate-800 px-6 py-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-red-400">
                    Monster Browser
                </p>

                <h2 class="mt-1 text-lg font-semibold text-slate-100">
                    Find the right creature
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Search by name or narrow the Monster Manual by type and challenge rating.
                </p>

            </div>


            <form method="GET"
                  action="{{ route('encounters.pickMonster', [
                      'row' => $row,
                      'slot' => $slot,
                      'show' => 1,
                  ]) }}"
                  class="grid gap-5 p-6 md:grid-cols-12">

                @if($campaignId)
                    <input type="hidden"
                           name="campaign"
                           value="{{ $campaignId }}">
                @endif


                {{-- SEARCH --}}
                <div class="md:col-span-6">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Search
                    </label>

                    <input name="q"
                           value="{{ $q }}"
                           placeholder="Goblin, dragon, undead..."
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


                {{-- ACTIONS --}}
                <div class="md:col-span-12 flex flex-col gap-3
                            border-t border-slate-800 pt-5
                            sm:flex-row sm:items-center">

                    <button type="submit"
                            class="inline-flex items-center
                                   justify-center gap-2 rounded-xl
                                   bg-red-500 px-5 py-2.5
                                   text-sm font-semibold text-white
                                   transition hover:bg-red-400">

                        Search Monsters
                    </button>


                    <a href="{{ route('encounters.pickMonster', [
                            'row' => $row,
                            'slot' => $slot,
                            'campaign' => $campaignId,
                        ]) }}"
                       class="inline-flex items-center justify-center
                              rounded-xl border border-slate-700
                              px-4 py-2.5 text-sm text-slate-400
                              transition hover:bg-slate-900
                              hover:text-white">

                        Reset Filters
                    </a>


                    <div class="sm:ml-auto">
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
             RESULTS
        ============================================================ --}}
        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-red-400">
                    Monster Manual
                </p>

                <h2 class="mt-1 text-2xl font-semibold
                           tracking-tight text-slate-100">
                    Available monsters
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Select a monster to place it into this encounter slot.
                </p>

            </div>


            <div class="grid gap-4 md:grid-cols-2">

                @forelse($results as $m)

                    @php
                        $slug = \Illuminate\Support\Str::slug($m['m_name'] ?? '');
                    @endphp


                    <div class="group relative overflow-hidden
                                rounded-2xl border border-slate-800
                                bg-slate-950 p-5
                                transition duration-200
                                hover:-translate-y-0.5
                                hover:border-red-500/30
                                hover:bg-slate-900/40">

                        <div class="absolute inset-y-0 left-0
                                    w-1 bg-red-500
                                    opacity-0 transition
                                    group-hover:opacity-100">
                        </div>


                        <div class="flex items-start justify-between gap-5">

                            <div class="flex min-w-0 gap-4">

                                <div class="flex h-11 w-11 shrink-0
                                            items-center justify-center
                                            rounded-xl
                                            border border-red-500/20
                                            bg-red-500/10
                                            text-red-300">

                                    <svg class="h-5 w-5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.7">
                                        <circle cx="12" cy="12" r="8"/>
                                        <path d="M9 10h.01"/>
                                        <path d="M15 10h.01"/>
                                        <path d="M9 15c1.8-1.2 4.2-1.2 6 0"/>
                                    </svg>

                                </div>


                                <div class="min-w-0">

                                    <h3 class="truncate text-lg font-semibold
                                               text-slate-100
                                               transition
                                               group-hover:text-red-200">

                                        {{ $m['m_name'] ?? 'Unnamed' }}

                                    </h3>


                                    <div class="mt-2 flex flex-wrap gap-2">

                                        <span class="rounded-full
                                                     border border-red-500/20
                                                     bg-red-500/[0.06]
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-red-300">

                                            {{ $m['m_type'] ?? 'Unknown' }}

                                        </span>


                                        <span class="rounded-full
                                                     border border-amber-500/20
                                                     bg-amber-500/[0.06]
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-amber-300">

                                            CR {{ $m['m_cr'] ?? '—' }}

                                        </span>


                                        <span class="rounded-full
                                                     border border-blue-500/20
                                                     bg-blue-500/[0.06]
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-blue-300">

                                            AC {{ $m['m_ac'] ?? '—' }}

                                        </span>

                                    </div>

                                </div>

                            </div>


                            <form method="POST"
                                  action="{{ route('encounters.setMonster', [
                                      'row' => $row,
                                      'slot' => $slot,
                                      'show' => 1,
                                  ]) }}"
                                  class="shrink-0">

                                @csrf

                                <input type="hidden"
                                       name="monster_slug"
                                       value="{{ $slug }}">

                                @if($campaignId)
                                    <input type="hidden"
                                           name="campaign_id"
                                           value="{{ $campaignId }}">
                                @endif


                                <button type="submit"
                                        class="inline-flex items-center gap-2
                                               rounded-xl bg-red-500
                                               px-4 py-2.5
                                               text-sm font-semibold text-white
                                               transition hover:bg-red-400">

                                    Select
                                    <span>→</span>

                                </button>

                            </form>

                        </div>
                    </div>


                @empty

                    <div class="rounded-3xl border border-dashed
                                border-slate-700
                                bg-slate-950/50
                                px-6 py-14 text-center
                                md:col-span-2">

                        <div class="mx-auto flex h-14 w-14
                                    items-center justify-center
                                    rounded-2xl
                                    border border-red-500/20
                                    bg-red-500/10
                                    text-red-300">

                            <svg class="h-7 w-7"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <circle cx="12" cy="12" r="8"/>
                                <path d="M9 10h.01"/>
                                <path d="M15 10h.01"/>
                            </svg>

                        </div>

                        <h3 class="mt-5 text-lg font-semibold
                                   text-slate-100">
                            No monsters found
                        </h3>

                        <p class="mx-auto mt-2 max-w-md
                                  text-sm leading-6 text-slate-400">
                            Try widening your search, choosing another creature
                            type, or increasing the maximum challenge rating.
                        </p>

                    </div>

                @endforelse

            </div>
        </section>

    </div>

</x-layouts.app>
