<x-layouts.app title="Dashboard">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- ============================================================
             HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900
                        via-amber-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-80 w-80 rounded-full
                        bg-amber-500/[0.06] blur-3xl">
            </div>

            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div class="max-w-2xl">

                    <div class="mb-4 inline-flex items-center gap-2
                                rounded-full border border-amber-500/20
                                bg-amber-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-amber-300">
                        Account Workspace
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Welcome back, {{ auth()->user()->name }}
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        Manage your saved content, campaigns, and account
                        settings from one place.
                    </p>

                </div>


                <a href="{{ route('account.index') }}"
                   class="inline-flex shrink-0 items-center gap-2
                          rounded-xl border border-slate-700
                          bg-slate-900/60 px-4 py-2
                          text-sm font-medium text-slate-300
                          transition hover:border-amber-500/30
                          hover:bg-slate-800">

                    Account & Security
                    <span>→</span>
                </a>

            </div>
        </section>


        {{-- ============================================================
             MAIN ACTIONS
        ============================================================ --}}
        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-amber-400">
                    Your Workspace
                </p>

                <h2 class="mt-1 text-2xl font-semibold
                           tracking-tight text-slate-100">
                    Continue where you left off
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Jump back into your campaigns or saved creations.
                </p>

            </div>


            <div class="grid gap-4 md:grid-cols-2">

                {{-- CAMPAIGNS --}}
                <a href="{{ route('campaigns.index') }}"
                   class="group relative overflow-hidden
                          rounded-2xl border border-amber-500/20
                          bg-gradient-to-br from-amber-950/15
                          to-slate-950 p-6
                          transition duration-200
                          hover:-translate-y-0.5
                          hover:border-amber-500/35">

                    <div class="flex items-start justify-between gap-5">

                        <div class="flex gap-4">

                            <div class="flex h-11 w-11 shrink-0
                                        items-center justify-center
                                        rounded-xl border
                                        border-amber-500/20
                                        bg-amber-500/10
                                        text-amber-300">

                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path d="M4 19.5V6.5A2.5 2.5 0 0 1 6.5 4H20v15H6.5A2.5 2.5 0 0 0 4 21.5"/>
                                    <path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20"/>
                                </svg>

                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.12em] text-amber-400">
                                    Campaign Management
                                </p>

                                <h3 class="mt-1 text-lg font-semibold
                                           text-slate-100">
                                    Campaigns
                                </h3>

                                <p class="mt-2 text-sm leading-6
                                          text-slate-400">
                                    Open your campaign workspaces and manage
                                    characters, encounters, dungeons, and sessions.
                                </p>
                            </div>

                        </div>

                        <span class="text-slate-600 transition
                                     group-hover:translate-x-1
                                     group-hover:text-amber-300">
                            →
                        </span>

                    </div>
                </a>


                {{-- SAVES --}}
                <a href="{{ route('saves.index') }}"
                   class="group relative overflow-hidden
                          rounded-2xl border border-indigo-500/20
                          bg-gradient-to-br from-indigo-950/15
                          to-slate-950 p-6
                          transition duration-200
                          hover:-translate-y-0.5
                          hover:border-indigo-500/35">

                    <div class="flex items-start justify-between gap-5">

                        <div class="flex gap-4">

                            <div class="flex h-11 w-11 shrink-0
                                        items-center justify-center
                                        rounded-xl border
                                        border-indigo-500/20
                                        bg-indigo-500/10
                                        text-indigo-300">

                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path d="M5 4h14v16H5z"/>
                                    <path d="M8 4v6h8V4"/>
                                </svg>

                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.12em] text-indigo-400">
                                    Saved Content
                                </p>

                                <h3 class="mt-1 text-lg font-semibold
                                           text-slate-100">
                                    Saves
                                </h3>

                                <p class="mt-2 text-sm leading-6
                                          text-slate-400">
                                    View and manage your saved characters,
                                    encounter tables, maps, and generated content.
                                </p>
                            </div>

                        </div>

                        <span class="text-slate-600 transition
                                     group-hover:translate-x-1
                                     group-hover:text-indigo-300">
                            →
                        </span>

                    </div>
                </a>

            </div>
        </section>


        {{-- ============================================================
             QUICK TOOLS
        ============================================================ --}}
        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-slate-500">
                    Quick Access
                </p>

                <h2 class="mt-1 text-xl font-semibold text-slate-100">
                    Create something new
                </h2>

            </div>


            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">

                <a href="{{ route('characters.index') }}"
                   class="rounded-2xl border border-slate-800
                          bg-slate-950 p-4 transition
                          hover:border-blue-500/30
                          hover:bg-slate-900/40">

                    <div class="text-sm font-semibold text-blue-300">
                        Characters
                    </div>

                    <div class="mt-1 text-xs text-slate-500">
                        Build PCs & NPCs
                    </div>
                </a>


                <a href="{{ route('encounters.index') }}"
                   class="rounded-2xl border border-slate-800
                          bg-slate-950 p-4 transition
                          hover:border-violet-500/30
                          hover:bg-slate-900/40">

                    <div class="text-sm font-semibold text-violet-300">
                        Encounters
                    </div>

                    <div class="mt-1 text-xs text-slate-500">
                        Generate encounter tables
                    </div>
                </a>


                <a href="{{ route('dungeons.generate') }}"
                   class="rounded-2xl border border-slate-800
                          bg-slate-950 p-4 transition
                          hover:border-indigo-500/30
                          hover:bg-slate-900/40">

                    <div class="text-sm font-semibold text-indigo-300">
                        AI Maps
                    </div>

                    <div class="mt-1 text-xs text-slate-500">
                        Generate map + story
                    </div>
                </a>


                <a href="{{ route('dungeon-new.create') }}"
                   class="rounded-2xl border border-slate-800
                          bg-slate-950 p-4 transition
                          hover:border-emerald-500/30
                          hover:bg-slate-900/40">

                    <div class="text-sm font-semibold text-emerald-300">
                        Procedural Dungeon
                    </div>

                    <div class="mt-1 text-xs text-slate-500">
                        Build editable layouts
                    </div>
                </a>

            </div>
        </section>

    </div>

</x-layouts.app>
