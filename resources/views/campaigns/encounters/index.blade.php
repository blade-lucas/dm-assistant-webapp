<x-layouts.app title="Campaign Encounter Tables">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- ============================================================
             SUCCESS MESSAGE
        ============================================================ --}}
        @if(session('success'))
            <div class="flex items-center gap-3 rounded-2xl
                        border border-emerald-800/60
                        bg-emerald-950/30 px-5 py-4
                        text-sm text-emerald-200">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center
                            rounded-full bg-emerald-500/10 text-emerald-300">
                    ✓
                </div>

                {{ session('success') }}
            </div>
        @endif


        {{-- ============================================================
             PAGE HEADER
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-violet-500/20
                        bg-gradient-to-br from-slate-900 via-slate-950 to-slate-950
                        p-7 md:p-8">

            {{-- Ambient decoration --}}
            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-violet-500/[0.05] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-14 -top-16
                        h-44 w-44 rounded-full
                        border border-violet-500/[0.07]">
            </div>


            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div>
                    <div class="mb-3 inline-flex items-center gap-2
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
                            <path d="m5 3 2 1-2 1"/>
                            <path d="m19 3-2 1 2 1"/>
                        </svg>

                        Encounters
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-50">
                        Encounter Tables
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-400">
                        Create and manage encounters for
                        <span class="font-medium text-slate-300">
                            {{ $campaign->name }}
                        </span>.
                    </p>
                </div>


                <a href="{{ route('campaigns.show', $campaign) }}"
                   class="inline-flex shrink-0 items-center gap-2
                          rounded-xl border border-slate-700
                          bg-slate-900/50 px-4 py-2
                          text-sm font-medium text-slate-300
                          transition hover:border-amber-500/30
                          hover:bg-slate-800 hover:text-slate-100">

                    <svg class="h-4 w-4"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>

                    Campaign
                </a>

            </div>
        </section>


        {{-- ============================================================
             CREATE ENCOUNTER TABLE
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-violet-400">
                    Create
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Build a new encounter table
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Create encounters manually or use AI generation tailored
                    to your campaign.
                </p>
            </div>


            <div class="relative overflow-hidden rounded-2xl
                        border border-violet-500/20
                        bg-gradient-to-r from-violet-950/25
                        via-slate-950 to-slate-950 p-6">

                <div class="pointer-events-none absolute -right-16 -top-16
                            h-48 w-48 rounded-full
                            bg-violet-500/[0.06] blur-3xl">
                </div>


                <div class="relative flex flex-col gap-6
                            md:flex-row md:items-center
                            md:justify-between">

                    <div class="flex items-start gap-4">

                        <div class="flex h-12 w-12 shrink-0
                                    items-center justify-center
                                    rounded-xl border border-violet-500/20
                                    bg-violet-500/10 text-violet-300">

                            <svg class="h-6 w-6"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <path d="M7 4 17 20"/>
                                <path d="M17 4 7 20"/>
                                <path d="M5 3 7 4 5 5"/>
                                <path d="M19 3 17 4 19 5"/>
                                <path d="M5 19 7 20 5 21"/>
                                <path d="M19 19 17 20 19 21"/>
                            </svg>

                        </div>


                        <div>
                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.14em] text-violet-400">
                                Encounter Generator
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                Manual & AI Generation
                            </h3>

                            <p class="mt-2 max-w-xl text-sm leading-6
                                      text-slate-400">
                                Choose encounter types, location, dice table,
                                party level, and tone, then build the table
                                manually or let AI generate campaign-aware
                                encounters.
                            </p>


                            <div class="mt-4 flex flex-wrap gap-2">

                                <span class="rounded-full border
                                             border-violet-500/20
                                             bg-violet-500/[0.06]
                                             px-2.5 py-1 text-[10px]
                                             font-medium uppercase
                                             tracking-wider text-violet-300">
                                    AI Generation
                                </span>

                                <span class="rounded-full border
                                             border-slate-700
                                             bg-slate-900
                                             px-2.5 py-1 text-[10px]
                                             font-medium uppercase
                                             tracking-wider text-slate-400">
                                    Manual Tables
                                </span>

                                <span class="rounded-full border
                                             border-slate-700
                                             bg-slate-900
                                             px-2.5 py-1 text-[10px]
                                             font-medium uppercase
                                             tracking-wider text-slate-400">
                                    Monster Selection
                                </span>

                            </div>
                        </div>

                    </div>


                    <a href="{{ route('encounters.index', ['campaign' => $campaign->id]) }}"
                       class="inline-flex shrink-0 items-center
                              justify-center gap-2 rounded-xl
                              bg-violet-500 px-5 py-2.5
                              text-sm font-semibold text-white
                              transition hover:bg-violet-400">

                        Create Encounter Table

                        <svg class="h-4 w-4"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M5 12h14"/>
                            <path d="m13 6 6 6-6 6"/>
                        </svg>

                    </a>

                </div>
            </div>
        </section>


        {{-- ============================================================
             ATTACHED TABLES
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-amber-400">
                    Campaign Encounters
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Attached encounter tables
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Tables currently connected to {{ $campaign->name }}.
                </p>
            </div>


            <div class="grid gap-4 md:grid-cols-2">

                @forelse($attachedTables as $table)

                    @php
                        $mode = strtolower($table->payload['params']['mode'] ?? 'manual');
                        $dice = $table->payload['params']['dice'] ?? null;
                    @endphp


                    <div class="group relative overflow-hidden rounded-2xl
                                border border-slate-800 bg-slate-950 p-5
                                transition duration-200
                                hover:border-violet-500/30
                                hover:bg-slate-900/40">

                        <div class="absolute inset-y-0 left-0 w-1
                                    bg-violet-500 opacity-0
                                    transition group-hover:opacity-100">
                        </div>


                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                {{-- Type badges --}}
                                <div class="mb-3 flex flex-wrap items-center gap-2">

                                    @if($mode === 'ai')
                                        <span class="inline-flex items-center gap-1.5
                                                     rounded-full
                                                     border border-violet-500/25
                                                     bg-violet-500/10
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-violet-300">

                                            <span>✦</span>
                                            AI Generated

                                        </span>
                                    @else
                                        <span class="inline-flex items-center
                                                     rounded-full
                                                     border border-slate-700
                                                     bg-slate-900
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-slate-400">
                                            Manual
                                        </span>
                                    @endif


                                    @if($dice)
                                        <span class="inline-flex items-center
                                                     rounded-full
                                                     border border-amber-500/20
                                                     bg-amber-500/[0.06]
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-amber-300">
                                            {{ strtoupper($dice) }}
                                        </span>
                                    @endif

                                </div>


                                <h3 class="truncate text-lg font-semibold
                                           text-slate-100">
                                    {{ $table->name }}
                                </h3>


                                <p class="mt-2 text-sm leading-6 text-slate-500">
                                    {{ $mode === 'ai'
                                        ? 'AI-generated encounter table ready for use during your campaign.'
                                        : 'Custom encounter table ready for use during your campaign.' }}
                                </p>

                            </div>


                            <div class="flex shrink-0 flex-col gap-2">

                                <form method="POST"
                                      action="{{ route('encounters.saved.load', $table) }}">
                                    @csrf

                                    <button type="submit"
                                            class="inline-flex w-full
                                                   items-center justify-center
                                                   gap-1.5 rounded-lg
                                                   bg-violet-500 px-3 py-2
                                                   text-xs font-semibold
                                                   text-white transition
                                                   hover:bg-violet-400">
                                        Open
                                        <span>→</span>
                                    </button>
                                </form>


                                <form method="POST"
                                      action="{{ route('campaigns.encounters.detach', [$campaign, $table]) }}">
                                    @csrf

                                    <button type="submit"
                                            class="w-full rounded-lg border
                                                   border-slate-700 px-3 py-2
                                                   text-xs text-slate-400
                                                   transition
                                                   hover:border-red-500/30
                                                   hover:bg-red-950/20
                                                   hover:text-red-300">
                                        Remove
                                    </button>
                                </form>

                            </div>

                        </div>


                        <div class="mt-5 flex items-center gap-2
                                    border-t border-slate-800/70
                                    pt-4 text-xs text-slate-600">

                            <svg class="h-3.5 w-3.5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path d="M4 5h16"/>
                                <path d="M4 12h16"/>
                                <path d="M4 19h16"/>
                            </svg>

                            Encounter Table

                            @if($dice)
                                <span>•</span>
                                <span>Roll {{ strtoupper($dice) }}</span>
                            @endif

                        </div>

                    </div>

                @empty

                    <div class="rounded-2xl border border-dashed
                                border-slate-700 bg-slate-950/50
                                px-6 py-12 text-center md:col-span-2">

                        <div class="mx-auto flex h-12 w-12
                                    items-center justify-center
                                    rounded-xl border border-violet-500/20
                                    bg-violet-500/10 text-violet-300">

                            <svg class="h-6 w-6"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <path d="M7 4 17 20"/>
                                <path d="M17 4 7 20"/>
                            </svg>

                        </div>

                        <h3 class="mt-4 font-semibold text-slate-200">
                            No encounter tables yet
                        </h3>

                        <p class="mx-auto mt-2 max-w-md
                                  text-sm leading-6 text-slate-500">
                            Generate a new encounter table or attach one
                            you've already created.
                        </p>

                        <a href="{{ route('encounters.index', ['campaign' => $campaign->id]) }}"
                           class="mt-5 inline-flex items-center gap-2
                                  rounded-xl bg-violet-500 px-4 py-2
                                  text-sm font-semibold text-white
                                  transition hover:bg-violet-400">
                            Create Encounter Table →
                        </a>

                    </div>

                @endforelse

            </div>
        </section>


        {{-- ============================================================
             IMPORT EXISTING TABLES
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-slate-500">
                    Existing Content
                </p>

                <h2 class="mt-1 text-xl font-semibold tracking-tight
                           text-slate-100">
                    Import into this campaign
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Attach encounter tables you've previously created.
                </p>
            </div>


            <div class="rounded-2xl border border-slate-800
                        bg-slate-950 p-5">

                <div class="grid gap-3 md:grid-cols-2">

                    @forelse($availableTables as $table)

                        @php
                            $mode = strtolower($table->payload['params']['mode'] ?? 'manual');
                            $dice = $table->payload['params']['dice'] ?? null;
                        @endphp


                        <div class="flex items-center justify-between gap-4
                                    rounded-xl border border-slate-800
                                    bg-slate-950/50 p-4
                                    transition hover:border-violet-500/20">

                            <div class="min-w-0">

                                <div class="truncate text-sm font-semibold
                                            text-slate-200">
                                    {{ $table->name }}
                                </div>


                                <div class="mt-2 flex flex-wrap gap-2">

                                    @if($mode === 'ai')
                                        <span class="rounded-full
                                                     border border-violet-500/20
                                                     bg-violet-500/[0.06]
                                                     px-2 py-0.5
                                                     text-[10px] font-medium
                                                     uppercase tracking-wider
                                                     text-violet-300">
                                            AI
                                        </span>
                                    @else
                                        <span class="rounded-full
                                                     border border-slate-700
                                                     bg-slate-900
                                                     px-2 py-0.5
                                                     text-[10px] font-medium
                                                     uppercase tracking-wider
                                                     text-slate-400">
                                            Manual
                                        </span>
                                    @endif


                                    @if($dice)
                                        <span class="rounded-full
                                                     border border-amber-500/20
                                                     bg-amber-500/[0.06]
                                                     px-2 py-0.5
                                                     text-[10px] font-medium
                                                     uppercase tracking-wider
                                                     text-amber-300">
                                            {{ strtoupper($dice) }}
                                        </span>
                                    @endif

                                </div>

                            </div>


                            <form method="POST"
                                  action="{{ route('campaigns.encounters.attach', [$campaign, $table]) }}">
                                @csrf

                                <button type="submit"
                                        class="shrink-0 rounded-lg
                                               border border-violet-500/30
                                               bg-violet-500/10
                                               px-3 py-2 text-xs
                                               font-semibold text-violet-300
                                               transition
                                               hover:bg-violet-500/20">
                                    Attach
                                </button>
                            </form>

                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed
                                    border-slate-800 px-5 py-8
                                    text-center md:col-span-2">

                            <p class="text-sm text-slate-500">
                                No unattached encounter tables available.
                            </p>

                            <p class="mt-1 text-xs text-slate-600">
                                Tables you create outside this campaign
                                will appear here.
                            </p>

                        </div>

                    @endforelse

                </div>
            </div>
        </section>

    </div>

</x-layouts.app>
