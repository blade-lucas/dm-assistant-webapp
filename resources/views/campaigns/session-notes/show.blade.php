<x-layouts.app title="{{ $sessionNote->title }}">

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
             JOURNAL HEADER
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900 via-slate-950 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-amber-500/[0.05] blur-3xl">
            </div>


            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div class="max-w-3xl">

                    <div class="mb-3 flex flex-wrap items-center gap-2">

                        @if($sessionNote->session_number)
                            <span class="rounded-full border border-amber-500/20
                                         bg-amber-500/10 px-3 py-1
                                         text-xs font-semibold uppercase
                                         tracking-[0.14em] text-amber-300">
                                Session {{ $sessionNote->session_number }}
                            </span>
                        @endif


                        @if($sessionNote->session_date)
                            <span class="rounded-full border border-slate-700
                                         bg-slate-900 px-3 py-1
                                         text-xs text-slate-400">
                                {{ $sessionNote->session_date->format('M j, Y') }}
                            </span>
                        @endif

                    </div>


                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        {{ $sessionNote->title }}
                    </h1>

                    <p class="mt-2 text-sm text-slate-400">
                        Campaign:
                        <span class="font-medium text-slate-300">
                            {{ $campaign->name }}
                        </span>
                    </p>

                </div>


                <div class="flex flex-wrap gap-2">

                    <a href="{{ route('campaigns.session-notes.index', $campaign) }}"
                       class="rounded-xl border border-slate-700
                              bg-slate-900/50 px-4 py-2
                              text-sm text-slate-300 transition
                              hover:bg-slate-800">
                        ← Notes
                    </a>


                    <a href="{{ route('campaigns.session-notes.edit', [$campaign, $sessionNote]) }}"
                       class="rounded-xl border border-amber-500/30
                              bg-amber-500/10 px-4 py-2
                              text-sm font-medium text-amber-300
                              transition hover:bg-amber-500/20">
                        Edit
                    </a>


                    <form method="POST"
                          action="{{ route('campaigns.session-notes.destroy', [$campaign, $sessionNote]) }}"
                          onsubmit="return confirm('Delete this session note?');">

                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="rounded-xl border border-slate-700
                                       bg-slate-900/50 px-4 py-2
                                       text-sm text-slate-400 transition
                                       hover:border-red-500/30
                                       hover:bg-red-950/20
                                       hover:text-red-300">
                            Delete
                        </button>

                    </form>

                </div>

            </div>
        </section>


        {{-- ============================================================
             SUMMARY
        ============================================================ --}}
        <section class="rounded-2xl border border-amber-500/20
                        bg-gradient-to-br from-amber-950/10
                        to-slate-950 p-6">

            <p class="text-xs font-semibold uppercase
                      tracking-[0.16em] text-amber-400">
                Session Recap
            </p>

            <h2 class="mt-1 text-xl font-semibold text-slate-100">
                Summary
            </h2>

            <p class="mt-4 whitespace-pre-line
                      text-sm leading-7 text-slate-300">
                {{ $sessionNote->summary ?: 'No summary added.' }}
            </p>

        </section>


        {{-- ============================================================
             SESSION DETAILS
        ============================================================ --}}
        <section class="grid gap-4 md:grid-cols-2">

            {{-- Important Events --}}
            <div class="rounded-2xl border border-slate-800
                        bg-slate-950 p-6">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.14em] text-amber-400">
                    Highlights
                </p>

                <h2 class="mt-1 text-lg font-semibold text-slate-100">
                    Important Events
                </h2>

                <p class="mt-4 whitespace-pre-line
                          text-sm leading-6 text-slate-400">
                    {{ $sessionNote->important_events ?: 'No important events added.' }}
                </p>

            </div>


            {{-- NPCs & Locations --}}
            <div class="rounded-2xl border border-slate-800
                        bg-slate-950 p-6">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.14em] text-blue-400">
                    World
                </p>

                <h2 class="mt-1 text-lg font-semibold text-slate-100">
                    NPCs & Locations
                </h2>

                <p class="mt-4 whitespace-pre-line
                          text-sm leading-6 text-slate-400">
                    {{ $sessionNote->npcs_locations ?: 'No NPCs or locations added.' }}
                </p>

            </div>


            {{-- Player Decisions --}}
            <div class="rounded-2xl border border-blue-500/20
                        bg-blue-950/10 p-6">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.14em] text-blue-400">
                    Party Actions
                </p>

                <h2 class="mt-1 text-lg font-semibold text-slate-100">
                    Player Decisions
                </h2>

                <p class="mt-4 whitespace-pre-line
                          text-sm leading-6 text-slate-400">
                    {{ $sessionNote->player_decisions ?: 'No player decisions recorded.' }}
                </p>

            </div>


            {{-- Unresolved Hooks --}}
            <div class="rounded-2xl border border-violet-500/20
                        bg-violet-950/10 p-6">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.14em] text-violet-400">
                    Open Threads
                </p>

                <h2 class="mt-1 text-lg font-semibold text-slate-100">
                    Unresolved Hooks
                </h2>

                <p class="mt-4 whitespace-pre-line
                          text-sm leading-6 text-slate-400">
                    {{ $sessionNote->unresolved_hooks ?: 'No unresolved hooks added.' }}
                </p>

            </div>

        </section>


        {{-- ============================================================
             DM NOTES
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-2xl
                        border border-violet-500/20
                        bg-gradient-to-r from-violet-950/15
                        via-slate-950 to-slate-950 p-6">

            <div class="flex items-start gap-4">

                <div class="flex h-10 w-10 shrink-0 items-center
                            justify-center rounded-xl
                            border border-violet-500/20
                            bg-violet-500/10 text-violet-300">
                    ✦
                </div>


                <div>
                    <p class="text-xs font-semibold uppercase
                              tracking-[0.14em] text-violet-400">
                        Private DM Preparation
                    </p>

                    <h2 class="mt-1 text-lg font-semibold text-slate-100">
                        DM Notes / Next Session
                    </h2>

                    <p class="mt-4 whitespace-pre-line
                              text-sm leading-6 text-slate-400">
                        {{ $sessionNote->dm_notes ?: 'No DM notes added.' }}
                    </p>

                </div>

            </div>
        </section>

    </div>

</x-layouts.app>
