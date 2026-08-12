<x-layouts.app :title="'DM Assistant'">

    <div class="relative">
        {{-- Subtle ambient background --}}
        <div class="pointer-events-none absolute inset-x-0 -top-20 -z-10 overflow-hidden">
            <div class="mx-auto h-[520px] max-w-6xl
                        bg-[radial-gradient(circle_at_top,rgba(245,158,11,0.10),transparent_65%)]">
            </div>
        </div>

        <div class="grid gap-10">

            {{-- ============================================================
                 HERO
            ============================================================ --}}
            <section class="relative overflow-hidden rounded-3xl border border-slate-800
                bg-slate-950 px-6 py-10 shadow-2xl shadow-black/20
                md:px-10 md:py-12">

                {{-- Fantasy map background --}}
                <div
                    class="pointer-events-none absolute inset-0 bg-cover bg-right"
                    style="background-image: url('{{ asset('images/dm-hero-background.png') }}');">
                </div>

                {{-- Dark overlay keeps the content readable --}}
                <div class="pointer-events-none absolute inset-0
                    bg-gradient-to-r from-slate-950/80 via-slate-950/45 to-slate-950/20">
                </div>

                <div class="relative grid gap-10 lg:grid-cols-[1.45fr_0.75fr] lg:items-center">

                    {{-- Hero copy --}}
                    <div class="max-w-3xl">

                        <div class="mb-4 inline-flex items-center gap-2 rounded-full
                                    border border-amber-500/20 bg-amber-500/5
                                    px-3 py-1.5 text-xs font-medium text-amber-300">
                            <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                            Dungeon Master Campaign Workspace
                        </div>

                        <h1 class="text-4xl font-bold tracking-tight text-slate-50
                                   md:text-5xl lg:text-[3.4rem] lg:leading-[1.08]">
                            Run Better Campaigns.
                            <span class="block text-amber-300">
                                Build Better Adventures.
                            </span>
                        </h1>

                        <p class="mt-5 max-w-2xl text-base leading-7 text-slate-300 md:text-lg">
                            Plan campaigns, manage characters, generate encounters,
                            build dungeons, and create campaign-aware stories from
                            one Dungeon Master workspace.
                        </p>

                        <div class="mt-7 flex flex-wrap gap-3">
                            @auth
                                <a href="{{ route('campaigns.index') }}"
                                   class="inline-flex items-center gap-2 rounded-xl
                                          bg-amber-400 px-5 py-2.5 text-sm font-semibold
                                          text-slate-950 transition
                                          hover:bg-amber-300 hover:shadow-lg hover:shadow-amber-500/10">
                                    Open Campaigns

                                    <svg class="h-4 w-4"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path d="M5 12h14"/>
                                        <path d="m13 6 6 6-6 6"/>
                                    </svg>
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="inline-flex items-center gap-2 rounded-xl
                                          bg-amber-400 px-5 py-2.5 text-sm font-semibold
                                          text-slate-950 transition
                                          hover:bg-amber-300">
                                    Start a Campaign
                                </a>
                            @endauth

                            <a href="{{ route('characters.create') }}"
                               class="rounded-xl border border-slate-700
                                      bg-slate-900/40 px-5 py-2.5 text-sm font-medium
                                      text-slate-200 transition
                                      hover:border-slate-600 hover:bg-slate-800/70">
                                Create a Character
                            </a>
                        </div>

                        {{-- Hero feature tags --}}
                        <div class="mt-7 flex flex-wrap gap-x-5 gap-y-2 text-xs text-slate-400">
                            <span class="flex items-center gap-2">
                                <span class="text-emerald-400">✓</span>
                                Campaign-aware AI
                            </span>

                            <span class="flex items-center gap-2">
                                <span class="text-emerald-400">✓</span>
                                Procedural dungeons
                            </span>

                            <span class="flex items-center gap-2">
                                <span class="text-emerald-400">✓</span>
                                Character management
                            </span>

                            <span class="flex items-center gap-2">
                                <span class="text-emerald-400">✓</span>
                                Encounter generation
                            </span>
                        </div>
                    </div>
                </div>
            </section>


            {{-- ============================================================
                 CAMPAIGN MANAGEMENT FEATURE
            ============================================================ --}}
            <section>
                <div class="mb-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-amber-400">
                        Your Adventure Hub
                    </p>

                    <h2 class="mt-1 text-2xl font-semibold tracking-tight text-slate-100">
                        Manage the whole campaign
                    </h2>

                    <p class="mt-1 max-w-2xl text-sm text-slate-400">
                        Keep every part of your adventure connected instead of
                        juggling separate tools and documents.
                    </p>
                </div>

                <div class="relative overflow-hidden rounded-3xl
                            border border-amber-500/20
                            bg-gradient-to-r from-amber-500/[0.06]
                            via-slate-950 to-slate-950 p-6 md:p-8">

                    <div class="grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                        <div>
                            <div class="flex items-center gap-3">
                                <div class="flex h-11 w-11 items-center justify-center
                                            rounded-xl border border-amber-500/20
                                            bg-amber-500/10 text-amber-300">
                                    <svg class="h-6 w-6"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.7">
                                        <path d="M4 19.5V6.5A2.5 2.5 0 0 1 6.5 4H20v15H6.5A2.5 2.5 0 0 0 4 21.5"/>
                                        <path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20"/>
                                        <path d="M8 8h8"/>
                                        <path d="M8 12h5"/>
                                    </svg>
                                </div>

                                <div>
                                    <h3 class="text-xl font-semibold text-slate-100">
                                        Campaign Management
                                    </h3>

                                    <p class="text-sm text-slate-400">
                                        One workspace for the entire adventure.
                                    </p>
                                </div>
                            </div>

                            <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                                @foreach([
                                    ['Characters & NPCs', 'Build and manage your cast.'],
                                    ['Session Notes', 'Track events, decisions, and hooks.'],
                                    ['Encounter Tables', 'Generate and save campaign encounters.'],
                                    ['Dungeons & Maps', 'Create campaign-aware locations.'],
                                ] as [$title, $description])
                                    <div class="rounded-xl border border-slate-800
                                                bg-slate-950/60 p-4">
                                        <div class="text-sm font-medium text-slate-200">
                                            {{ $title }}
                                        </div>

                                        <div class="mt-1 text-xs leading-5 text-slate-500">
                                            {{ $description }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        @auth
                            <a href="{{ route('campaigns.index') }}"
                               class="inline-flex shrink-0 items-center justify-center gap-2
                                      rounded-xl bg-amber-400 px-5 py-2.5
                                      text-sm font-semibold text-slate-950
                                      transition hover:bg-amber-300">
                                View Campaigns
                                <span>→</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex shrink-0 items-center justify-center gap-2
                                      rounded-xl bg-amber-400 px-5 py-2.5
                                      text-sm font-semibold text-slate-950
                                      transition hover:bg-amber-300">
                                Get Started
                                <span>→</span>
                            </a>
                        @endauth
                    </div>
                </div>
            </section>


            {{-- ============================================================
                 DM TOOLS
            ============================================================ --}}
            <section>
                <div class="mb-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                        Dungeon Master Toolkit
                    </p>

                    <h2 class="mt-1 text-2xl font-semibold tracking-tight">
                        Everything you need at the table
                    </h2>
                </div>

                <div class="grid gap-4 md:grid-cols-2">

                    {{-- Item Library --}}
                    <a href="{{ route('items.index') }}"
                       class="group relative overflow-hidden rounded-2xl
                              border border-slate-800 bg-slate-950 p-6
                              transition duration-200
                              hover:-translate-y-0.5 hover:border-amber-500/30
                              hover:bg-slate-900/70 hover:shadow-lg hover:shadow-black/20">

                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center
                                        rounded-xl border border-amber-500/20
                                        bg-amber-500/10 text-amber-300">
                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path d="m14.5 4.5 5 5"/>
                                    <path d="m5 19 4.5-4.5"/>
                                    <path d="m7 17-2-2"/>
                                    <path d="M9.5 14.5 18 6l-3-3-8.5 8.5"/>
                                    <path d="M15 3 21 9"/>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wider text-amber-400/80">
                                            Repository
                                        </p>

                                        <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                            Item Library
                                        </h3>
                                    </div>

                                    <span class="text-slate-600 transition group-hover:translate-x-1 group-hover:text-amber-300">
                                        →
                                    </span>
                                </div>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Browse weapons, equipment, loot, and other items
                                    for your next adventure.
                                </p>
                            </div>
                        </div>
                    </a>


                    {{-- Monster Manual --}}
                    <a href="{{ route('monsters.index') }}"
                       class="group relative overflow-hidden rounded-2xl
                              border border-slate-800 bg-slate-950 p-6
                              transition duration-200
                              hover:-translate-y-0.5 hover:border-red-500/30
                              hover:bg-slate-900/70 hover:shadow-lg hover:shadow-black/20">

                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center
                                        rounded-xl border border-red-500/20
                                        bg-red-500/10 text-red-300">
                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <circle cx="12" cy="12" r="8"/>
                                    <path d="M9 10h.01"/>
                                    <path d="M15 10h.01"/>
                                    <path d="M9 15c1.8-1.2 4.2-1.2 6 0"/>
                                    <path d="m6.5 6.5-2-2"/>
                                    <path d="m17.5 6.5 2-2"/>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wider text-red-400/80">
                                            Repository
                                        </p>

                                        <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                            Monster Manual
                                        </h3>
                                    </div>

                                    <span class="text-slate-600 transition group-hover:translate-x-1 group-hover:text-red-300">
                                        →
                                    </span>
                                </div>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Search creatures by type and challenge rating,
                                    then open complete monster information.
                                </p>
                            </div>
                        </div>
                    </a>


                    {{-- Characters --}}
                    <a href="{{ route('characters.index') }}"
                       class="group relative overflow-hidden rounded-2xl
                              border border-slate-800 bg-slate-950 p-6
                              transition duration-200
                              hover:-translate-y-0.5 hover:border-blue-500/30
                              hover:bg-slate-900/70 hover:shadow-lg hover:shadow-black/20">

                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center
                                        rounded-xl border border-blue-500/20
                                        bg-blue-500/10 text-blue-300">
                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <circle cx="12" cy="8" r="3"/>
                                    <path d="M5 21a7 7 0 0 1 14 0"/>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wider text-blue-400/80">
                                            Character Creation
                                        </p>

                                        <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                            Characters & NPCs
                                        </h3>
                                    </div>

                                    <span class="text-slate-600 transition group-hover:translate-x-1 group-hover:text-blue-300">
                                        →
                                    </span>
                                </div>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Create detailed player characters and NPCs,
                                    manage equipment, spells, traits, and notes.
                                </p>
                            </div>
                        </div>
                    </a>


                    {{-- Encounters --}}
                    <a href="{{ route('encounters.index') }}"
                       class="group relative overflow-hidden rounded-2xl
                              border border-slate-800 bg-slate-950 p-6
                              transition duration-200
                              hover:-translate-y-0.5 hover:border-violet-500/30
                              hover:bg-slate-900/70 hover:shadow-lg hover:shadow-black/20">

                        <div class="flex items-start gap-4">
                            <div class="flex h-11 w-11 shrink-0 items-center justify-center
                                        rounded-xl border border-violet-500/20
                                        bg-violet-500/10 text-violet-300">
                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path d="m14.5 4.5 5 5"/>
                                    <path d="M4 20 20 4"/>
                                    <path d="m4.5 9.5 5-5"/>
                                    <path d="m14.5 19.5 5-5"/>
                                </svg>
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-center justify-between gap-4">
                                    <div>
                                        <p class="text-xs font-medium uppercase tracking-wider text-violet-400/80">
                                            Encounter Generator
                                        </p>

                                        <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                            Build Encounter Tables
                                        </h3>
                                    </div>

                                    <span class="text-slate-600 transition group-hover:translate-x-1 group-hover:text-violet-300">
                                        →
                                    </span>
                                </div>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Generate custom encounter tables manually or
                                    with campaign-aware AI assistance.
                                </p>
                            </div>
                        </div>
                    </a>

                </div>
            </section>


            {{-- ============================================================
                 DUNGEON GENERATION
            ============================================================ --}}
            <section class="pb-4">
                <div class="mb-4">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-500">
                        Adventure Generation
                    </p>

                    <h2 class="mt-1 text-2xl font-semibold tracking-tight">
                        Build the places your players explore
                    </h2>

                    <p class="mt-1 text-sm text-slate-400">
                        Choose between AI-assisted map generation or an editable
                        procedural dungeon workflow.
                    </p>
                </div>

                <div class="grid gap-4 lg:grid-cols-2">

                    {{-- AI/DDPM --}}
                    <a href="{{ route('dungeons.generate') }}"
                       class="group rounded-2xl border border-slate-800
                              bg-gradient-to-br from-slate-950 to-indigo-950/20
                              p-6 transition duration-200
                              hover:-translate-y-0.5 hover:border-indigo-500/30">

                        <div class="flex items-start justify-between gap-4">
                            <div class="flex h-11 w-11 items-center justify-center
                                        rounded-xl border border-indigo-500/20
                                        bg-indigo-500/10 text-indigo-300">
                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path d="M3 6h18v12H3z"/>
                                    <path d="m7 14 3-3 2 2 2-2 3 3"/>
                                    <circle cx="8" cy="9" r="1"/>
                                </svg>
                            </div>

                            <span class="text-slate-600 transition group-hover:translate-x-1 group-hover:text-indigo-300">
                                →
                            </span>
                        </div>

                        <p class="mt-5 text-xs font-semibold uppercase
                                  tracking-[0.14em] text-indigo-400">
                            AI Map Generation
                        </p>

                        <h3 class="mt-1 text-xl font-semibold">
                            Generate a Dungeon Map
                        </h3>

                        <p class="mt-2 text-sm leading-6 text-slate-400">
                            Generate dungeon imagery and pair it with RAG-powered,
                            campaign-aware adventure storytelling.
                        </p>

                        <div class="mt-5 flex flex-wrap gap-2 text-xs">
                            <span class="rounded-full border border-indigo-900
                                         bg-indigo-950/30 px-3 py-1 text-indigo-300">
                                DDPM
                            </span>

                            <span class="rounded-full border border-emerald-900
                                         bg-emerald-950/30 px-3 py-1 text-emerald-300">
                                RAG Storytelling
                            </span>

                            <span class="rounded-full border border-slate-800
                                         px-3 py-1 text-slate-400">
                                Campaign Context
                            </span>
                        </div>
                    </a>


                    {{-- Procedural --}}
                    @auth
                        <a href="{{ route('dungeon-new.create') }}"
                           class="group rounded-2xl border border-slate-800
                                  bg-gradient-to-br from-slate-950 to-emerald-950/20
                                  p-6 transition duration-200
                                  hover:-translate-y-0.5 hover:border-emerald-500/30">

                            <div class="flex items-start justify-between gap-4">
                                <div class="flex h-11 w-11 items-center justify-center
                                            rounded-xl border border-emerald-500/20
                                            bg-emerald-500/10 text-emerald-300">
                                    <svg class="h-5 w-5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.7">
                                        <path d="M4 4h6v6H4z"/>
                                        <path d="M14 4h6v6h-6z"/>
                                        <path d="M4 14h6v6H4z"/>
                                        <path d="M14 14h6v6h-6z"/>
                                        <path d="M10 7h4"/>
                                        <path d="M7 10v4"/>
                                    </svg>
                                </div>

                                <span class="text-slate-600 transition group-hover:translate-x-1 group-hover:text-emerald-300">
                                    →
                                </span>
                            </div>

                            <p class="mt-5 text-xs font-semibold uppercase
                                      tracking-[0.14em] text-emerald-400">
                                Procedural Generation
                            </p>

                            <h3 class="mt-1 text-xl font-semibold">
                                Build an Editable Dungeon
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Generate structured dungeon layouts, then customize
                                rooms, corridors, doors, and the finished map.
                            </p>

                            <div class="mt-5 flex flex-wrap gap-2 text-xs">
                                <span class="rounded-full border border-emerald-900
                                             bg-emerald-950/30 px-3 py-1 text-emerald-300">
                                    Procedural
                                </span>

                                <span class="rounded-full border border-slate-800
                                             px-3 py-1 text-slate-400">
                                    Interactive Editor
                                </span>

                                <span class="rounded-full border border-slate-800
                                             px-3 py-1 text-slate-400">
                                    Save & Reload
                                </span>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="group rounded-2xl border border-slate-800
                                  bg-gradient-to-br from-slate-950 to-emerald-950/20
                                  p-6 transition duration-200
                                  hover:border-emerald-500/30">

                            <p class="text-xs font-semibold uppercase tracking-[0.14em]
                                      text-emerald-400">
                                Procedural Generation
                            </p>

                            <h3 class="mt-2 text-xl font-semibold">
                                Build an Editable Dungeon
                            </h3>

                            <p class="mt-2 text-sm text-slate-400">
                                Sign in to create, customize, and save procedural dungeons.
                            </p>
                        </a>
                    @endauth

                </div>
            </section>

        </div>
    </div>

</x-layouts.app>
