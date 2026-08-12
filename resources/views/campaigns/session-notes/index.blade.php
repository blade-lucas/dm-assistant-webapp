<x-layouts.app title="Session Notes">

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
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900 via-slate-950 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-amber-500/[0.05] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-14 -top-16
                        h-44 w-44 rounded-full
                        border border-amber-500/[0.07]">
            </div>


            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div>
                    <div class="mb-3 inline-flex items-center gap-2
                                rounded-full border border-amber-500/20
                                bg-amber-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-amber-300">

                        <svg class="h-3.5 w-3.5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M5 4h14v16H5z"/>
                            <path d="M8 8h8"/>
                            <path d="M8 12h8"/>
                            <path d="M8 16h5"/>
                        </svg>

                        Campaign Journal
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-50">
                        Session Notes
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-400">
                        Track the story, choices, consequences, and unresolved
                        threads of
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
             CREATE NOTE
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-amber-400">
                    Record
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Add a session entry
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Capture what happened and what the Dungeon Master
                    needs to remember next.
                </p>
            </div>


            <div class="relative overflow-hidden rounded-2xl
                        border border-amber-500/20
                        bg-gradient-to-r from-amber-950/20
                        via-slate-950 to-slate-950 p-6">

                <div class="pointer-events-none absolute -right-16 -top-16
                            h-48 w-48 rounded-full
                            bg-amber-500/[0.05] blur-3xl">
                </div>


                <div class="relative flex flex-col gap-6
                            md:flex-row md:items-center md:justify-between">

                    <div class="flex items-start gap-4">

                        <div class="flex h-12 w-12 shrink-0
                                    items-center justify-center
                                    rounded-xl border border-amber-500/20
                                    bg-amber-500/10 text-amber-300">

                            <svg class="h-6 w-6"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <path d="M5 4h14v16H5z"/>
                                <path d="M8 8h8"/>
                                <path d="M8 12h8"/>
                                <path d="M12 16H8"/>
                                <path d="M17 14v5"/>
                                <path d="M14.5 16.5h5"/>
                            </svg>

                        </div>


                        <div>
                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.14em] text-amber-400">
                                New Session Note
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                Record the latest adventure
                            </h3>

                            <p class="mt-2 max-w-xl text-sm leading-6
                                      text-slate-400">
                                Save summaries, important events, NPCs and
                                locations, player decisions, unresolved hooks,
                                and preparation notes for the next session.
                            </p>


                            <div class="mt-4 flex flex-wrap gap-2">

                                <span class="rounded-full border
                                             border-amber-500/20
                                             bg-amber-500/[0.06]
                                             px-2.5 py-1 text-[10px]
                                             font-medium uppercase
                                             tracking-wider text-amber-300">
                                    Session History
                                </span>

                                <span class="rounded-full border
                                             border-slate-700
                                             bg-slate-900
                                             px-2.5 py-1 text-[10px]
                                             font-medium uppercase
                                             tracking-wider text-slate-400">
                                    Story Hooks
                                </span>

                                <span class="rounded-full border
                                             border-slate-700
                                             bg-slate-900
                                             px-2.5 py-1 text-[10px]
                                             font-medium uppercase
                                             tracking-wider text-slate-400">
                                    AI Context
                                </span>

                            </div>
                        </div>

                    </div>


                    <a href="{{ route('campaigns.session-notes.create', $campaign) }}"
                       class="inline-flex shrink-0 items-center
                              justify-center gap-2 rounded-xl
                              bg-amber-400 px-5 py-2.5
                              text-sm font-semibold text-slate-950
                              transition hover:bg-amber-300">

                        New Note

                        <svg class="h-4 w-4"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>

                    </a>

                </div>
            </div>
        </section>


        {{-- ============================================================
             SESSION JOURNAL
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-amber-400">
                    Campaign History
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Session journal
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    A chronological record of your campaign.
                </p>
            </div>


            <div class="relative">

                @if($sessionNotes->isNotEmpty())
                    {{-- Timeline line --}}
                    <div class="pointer-events-none absolute
                                bottom-6 left-[19px] top-6
                                hidden w-px bg-gradient-to-b
                                from-amber-500/50 via-slate-700
                                to-transparent sm:block">
                    </div>
                @endif


                <div class="space-y-4">

                    @forelse($sessionNotes as $note)

                        <div class="relative sm:pl-14">

                            {{-- Timeline marker --}}
                            <div class="absolute left-0 top-6 hidden
                                        h-10 w-10 items-center justify-center
                                        rounded-full border border-amber-500/30
                                        bg-slate-950 text-amber-300
                                        shadow-lg shadow-black/20
                                        sm:flex">

                                @if($note->session_number)
                                    <span class="text-xs font-bold">
                                        {{ $note->session_number }}
                                    </span>
                                @else
                                    <svg class="h-4 w-4"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path d="M5 4h14v16H5z"/>
                                        <path d="M8 8h8"/>
                                        <path d="M8 12h8"/>
                                    </svg>
                                @endif

                            </div>


                            <div class="group relative overflow-hidden
                                        rounded-2xl border border-slate-800
                                        bg-slate-950 p-5
                                        transition duration-200
                                        hover:border-amber-500/30
                                        hover:bg-slate-900/40">

                                <div class="absolute inset-y-0 left-0 w-1
                                            bg-amber-400 opacity-0
                                            transition group-hover:opacity-100">
                                </div>


                                <div class="flex flex-col gap-5
                                            md:flex-row md:items-start
                                            md:justify-between">

                                    <div class="min-w-0 flex-1">

                                        {{-- Metadata --}}
                                        <div class="mb-3 flex flex-wrap
                                                    items-center gap-2">

                                            @if($note->session_number)
                                                <span class="rounded-full
                                                             border border-amber-500/20
                                                             bg-amber-500/[0.06]
                                                             px-2.5 py-1
                                                             text-[10px]
                                                             font-semibold uppercase
                                                             tracking-wider
                                                             text-amber-300">
                                                    Session {{ $note->session_number }}
                                                </span>
                                            @endif


                                            @if($note->session_date)
                                                <span class="inline-flex
                                                             items-center gap-1.5
                                                             rounded-full
                                                             border border-slate-700
                                                             bg-slate-900
                                                             px-2.5 py-1
                                                             text-[10px]
                                                             font-medium uppercase
                                                             tracking-wider
                                                             text-slate-400">

                                                    <svg class="h-3 w-3"
                                                         viewBox="0 0 24 24"
                                                         fill="none"
                                                         stroke="currentColor"
                                                         stroke-width="1.8">
                                                        <rect x="3" y="5"
                                                              width="18"
                                                              height="16"
                                                              rx="2"/>
                                                        <path d="M16 3v4"/>
                                                        <path d="M8 3v4"/>
                                                        <path d="M3 11h18"/>
                                                    </svg>

                                                    {{ $note->session_date->format('M j, Y') }}

                                                </span>
                                            @endif

                                        </div>


                                        <h3 class="text-xl font-semibold
                                                   tracking-tight text-slate-100
                                                   transition
                                                   group-hover:text-amber-200">
                                            {{ $note->title }}
                                        </h3>


                                        <p class="mt-3 max-w-3xl
                                                  text-sm leading-6
                                                  text-slate-400">
                                            {{ Str::limit($note->summary, 280) ?: 'No summary recorded for this session.' }}
                                        </p>

                                    </div>


                                    {{-- Actions --}}
                                    <div class="flex shrink-0 gap-2">

                                        <a href="{{ route('campaigns.session-notes.show', [$campaign, $note]) }}"
                                           class="inline-flex items-center gap-1.5
                                                  rounded-lg bg-amber-400
                                                  px-3.5 py-2
                                                  text-xs font-semibold
                                                  text-slate-950
                                                  transition
                                                  hover:bg-amber-300">
                                            Open
                                            <span>→</span>
                                        </a>


                                        <a href="{{ route('campaigns.session-notes.edit', [$campaign, $note]) }}"
                                           class="rounded-lg border
                                                  border-slate-700
                                                  px-3.5 py-2
                                                  text-xs font-medium
                                                  text-slate-400
                                                  transition
                                                  hover:border-amber-500/30
                                                  hover:bg-slate-900
                                                  hover:text-slate-200">
                                            Edit
                                        </a>

                                    </div>

                                </div>


                                {{-- Journal footer --}}
                                <div class="mt-5 flex flex-wrap items-center
                                            gap-x-4 gap-y-2
                                            border-t border-slate-800/70
                                            pt-4 text-xs text-slate-600">

                                    <span class="flex items-center gap-1.5">
                                        <svg class="h-3.5 w-3.5"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="1.8">
                                            <path d="M5 4h14v16H5z"/>
                                            <path d="M8 8h8"/>
                                            <path d="M8 12h8"/>
                                        </svg>

                                        Session Record
                                    </span>


                                    @if($note->unresolved_hooks)
                                        <span class="flex items-center gap-1.5
                                                     text-violet-400/70">

                                            <span>◆</span>
                                            Unresolved hooks recorded

                                        </span>
                                    @endif


                                    @if($note->player_decisions)
                                        <span class="flex items-center gap-1.5
                                                     text-blue-400/70">

                                            <span>◆</span>
                                            Player decisions recorded

                                        </span>
                                    @endif

                                </div>

                            </div>
                        </div>


                    @empty

                        <div class="rounded-3xl border border-dashed
                                    border-slate-700
                                    bg-slate-950/50
                                    px-6 py-14 text-center">

                            <div class="mx-auto flex h-14 w-14
                                        items-center justify-center
                                        rounded-2xl border
                                        border-amber-500/20
                                        bg-amber-500/10
                                        text-amber-300">

                                <svg class="h-7 w-7"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path d="M5 4h14v16H5z"/>
                                    <path d="M8 8h8"/>
                                    <path d="M8 12h8"/>
                                    <path d="M8 16h5"/>
                                </svg>

                            </div>


                            <h3 class="mt-5 text-lg font-semibold
                                       text-slate-100">
                                Your campaign story starts here
                            </h3>

                            <p class="mx-auto mt-2 max-w-md
                                      text-sm leading-6 text-slate-400">
                                Add your first session note to begin tracking
                                important events, character decisions,
                                unresolved hooks, and future plans.
                            </p>


                            <a href="{{ route('campaigns.session-notes.create', $campaign) }}"
                               class="mt-6 inline-flex items-center gap-2
                                      rounded-xl bg-amber-400
                                      px-5 py-2.5
                                      text-sm font-semibold
                                      text-slate-950
                                      transition hover:bg-amber-300">

                                Create First Session Note

                                <span>→</span>
                            </a>

                        </div>

                    @endforelse

                </div>
            </div>
        </section>

    </div>

</x-layouts.app>
