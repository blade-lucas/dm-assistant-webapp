<x-layouts.app title="{{ $campaign->name }}">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- ============================================================
             SUCCESS MESSAGE
        ============================================================ --}}
        @if(session('success'))
            <div class="flex items-center gap-3 rounded-2xl
                        border border-emerald-800/60
                        bg-emerald-950/30 px-5 py-4 text-sm text-emerald-200">
                <div class="flex h-8 w-8 shrink-0 items-center justify-center
                            rounded-full bg-emerald-500/10 text-emerald-300">
                    ✓
                </div>

                {{ session('success') }}
            </div>
        @endif


        {{-- ============================================================
             CAMPAIGN HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900 via-slate-950 to-slate-950
                        p-7 shadow-xl shadow-black/10 md:p-8">

            {{-- Ambient decoration --}}
            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-amber-500/[0.04] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-12 top-0
                        h-40 w-40 rounded-full
                        border border-amber-500/[0.06]">
            </div>

            <div class="relative">

                {{-- Header --}}
                <div class="flex flex-col gap-6
                            md:flex-row md:items-start md:justify-between">

                    <div>
                        <div class="mb-3 flex flex-wrap items-center gap-2">

                            <span class="inline-flex items-center gap-2
                                         rounded-full border border-amber-500/20
                                         bg-amber-500/10 px-3 py-1
                                         text-xs font-semibold uppercase
                                         tracking-[0.14em] text-amber-300">
                                <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                                Campaign
                            </span>

                            @if(strtolower($campaign->status) === 'active')
                                <span class="inline-flex items-center gap-1.5
                                             rounded-full border border-emerald-800
                                             bg-emerald-950/30 px-3 py-1
                                             text-xs font-medium text-emerald-300">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    Active
                                </span>
                            @else
                                <span class="inline-flex items-center
                                             rounded-full border border-slate-700
                                             bg-slate-900 px-3 py-1
                                             text-xs font-medium text-slate-400">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            @endif

                        </div>

                        <h1 class="text-3xl font-bold tracking-tight
                                   text-slate-50 md:text-4xl">
                            {{ $campaign->name }}
                        </h1>

                        <p class="mt-3 flex flex-wrap items-center gap-x-2
                                  gap-y-1 text-sm text-slate-400">

                            <span>
                                {{ $campaign->setting_theme ?? 'No theme set' }}
                            </span>

                            <span class="text-amber-500/60">•</span>

                            <span>
                                {{ $campaign->tone ?? 'No tone set' }}
                            </span>

                            <span class="text-amber-500/60">•</span>

                            <span>
                                Levels
                                {{ $campaign->starting_level ?? '?' }}–{{ $campaign->max_level ?? '?' }}
                            </span>
                        </p>
                    </div>


                    {{-- Actions --}}
                    <div class="flex shrink-0 gap-2">

                        <a href="{{ route('campaigns.edit', $campaign) }}"
                           class="inline-flex items-center gap-2 rounded-xl
                                  border border-slate-700 bg-slate-900/50
                                  px-4 py-2 text-sm font-medium text-slate-200
                                  transition hover:border-amber-500/30
                                  hover:bg-slate-800">

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path d="M12 20h9"/>
                                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                            </svg>

                            Edit
                        </a>

                        <form method="POST"
                              action="{{ route('campaigns.destroy', $campaign) }}"
                              onsubmit="return confirm('Archive this campaign?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="inline-flex items-center gap-2 rounded-xl
                                           border border-slate-700 bg-slate-900/50
                                           px-4 py-2 text-sm font-medium text-slate-300
                                           transition hover:border-red-500/30
                                           hover:bg-red-950/20 hover:text-red-300">

                                <svg class="h-4 w-4"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path d="M3 6h18"/>
                                    <path d="M8 6V4h8v2"/>
                                    <path d="M19 6l-1 14H6L5 6"/>
                                    <path d="M10 11v5"/>
                                    <path d="M14 11v5"/>
                                </svg>

                                Archive
                            </button>
                        </form>

                    </div>
                </div>


                {{-- Campaign information --}}
                <div class="mt-8 grid gap-4 md:grid-cols-2">

                    {{-- World Description --}}
                    <div class="rounded-2xl border border-slate-800
                                bg-slate-950/60 p-5">

                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center
                                        rounded-lg border border-amber-500/20
                                        bg-amber-500/10 text-amber-300">

                                <svg class="h-4 w-4"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M3 12h18"/>
                                    <path d="M12 3a15 15 0 0 1 0 18"/>
                                    <path d="M12 3a15 15 0 0 0 0 18"/>
                                </svg>

                            </div>

                            <h2 class="text-sm font-semibold text-slate-200">
                                World Description
                            </h2>
                        </div>

                        <p class="mt-3 whitespace-pre-line
                                  text-sm leading-6 text-slate-400">
                            {{ $campaign->world_description ?: 'No world description yet.' }}
                        </p>

                    </div>


                    {{-- Campaign Summary --}}
                    <div class="rounded-2xl border border-slate-800
                                bg-slate-950/60 p-5">

                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center
                                        rounded-lg border border-amber-500/20
                                        bg-amber-500/10 text-amber-300">

                                <svg class="h-4 w-4"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path d="M4 5h16"/>
                                    <path d="M4 10h16"/>
                                    <path d="M4 15h10"/>
                                    <path d="M4 20h7"/>
                                </svg>

                            </div>

                            <h2 class="text-sm font-semibold text-slate-200">
                                Campaign Summary
                            </h2>
                        </div>

                        <p class="mt-3 whitespace-pre-line
                                  text-sm leading-6 text-slate-400">
                            {{ $campaign->campaign_summary ?: 'No campaign summary yet.' }}
                        </p>

                    </div>

                </div>
            </div>
        </section>


        {{-- ============================================================
             CAMPAIGN TOOLS
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-amber-400">
                    Campaign Workspace
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Build your adventure
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Everything connected to {{ $campaign->name }} lives here.
                </p>
            </div>


            <div class="grid gap-4 md:grid-cols-2">

                {{-- ====================================================
                     DUNGEONS / MAPS
                ==================================================== --}}
                <a href="{{ route('campaigns.dungeons.index', $campaign) }}"
                   class="group relative overflow-hidden rounded-2xl
                          border border-slate-800 bg-slate-950 p-6
                          transition duration-200
                          hover:-translate-y-0.5
                          hover:border-indigo-500/30
                          hover:bg-slate-900/70
                          hover:shadow-lg hover:shadow-black/20">

                    <div class="flex items-start justify-between gap-5">

                        <div class="flex gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center
                                        justify-center rounded-xl
                                        border border-indigo-500/20
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

                            <div>
                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.12em] text-indigo-400">
                                    World Building
                                </p>

                                <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                    Dungeons & Maps
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Generate AI maps, create procedural dungeons,
                                    or attach existing locations to this campaign.
                                </p>
                            </div>

                        </div>

                        <span class="mt-1 text-lg text-slate-600
                                     transition group-hover:translate-x-1
                                     group-hover:text-indigo-300">
                            →
                        </span>

                    </div>
                </a>


                {{-- ====================================================
                     ENCOUNTER TABLES
                ==================================================== --}}
                <a href="{{ route('campaigns.encounters.index', $campaign) }}"
                   class="group relative overflow-hidden rounded-2xl
                          border border-slate-800 bg-slate-950 p-6
                          transition duration-200
                          hover:-translate-y-0.5
                          hover:border-violet-500/30
                          hover:bg-slate-900/70
                          hover:shadow-lg hover:shadow-black/20">

                    <div class="flex items-start justify-between gap-5">

                        <div class="flex gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center
                                        justify-center rounded-xl
                                        border border-violet-500/20
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

                            <div>
                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.12em] text-violet-400">
                                    Encounters
                                </p>

                                <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                    Encounter Tables
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Create, generate, and manage encounter tables
                                    tailored to this campaign.
                                </p>
                            </div>

                        </div>

                        <span class="mt-1 text-lg text-slate-600
                                     transition group-hover:translate-x-1
                                     group-hover:text-violet-300">
                            →
                        </span>

                    </div>
                </a>


                {{-- ====================================================
                     CHARACTERS
                ==================================================== --}}
                <a href="{{ route('campaigns.characters.index', $campaign) }}"
                   class="group relative overflow-hidden rounded-2xl
                          border border-slate-800 bg-slate-950 p-6
                          transition duration-200
                          hover:-translate-y-0.5
                          hover:border-blue-500/30
                          hover:bg-slate-900/70
                          hover:shadow-lg hover:shadow-black/20">

                    <div class="flex items-start justify-between gap-5">

                        <div class="flex gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center
                                        justify-center rounded-xl
                                        border border-blue-500/20
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

                            <div>
                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.12em] text-blue-400">
                                    Party & Cast
                                </p>

                                <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                    Characters & NPCs
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Manage player characters, NPCs, allies,
                                    villains, and the rest of your campaign cast.
                                </p>
                            </div>

                        </div>

                        <span class="mt-1 text-lg text-slate-600
                                     transition group-hover:translate-x-1
                                     group-hover:text-blue-300">
                            →
                        </span>

                    </div>
                </a>


                {{-- ====================================================
                     SESSION NOTES
                ==================================================== --}}
                <a href="{{ route('campaigns.session-notes.index', $campaign) }}"
                   class="group relative overflow-hidden rounded-2xl
                          border border-slate-800 bg-slate-950 p-6
                          transition duration-200
                          hover:-translate-y-0.5
                          hover:border-amber-500/30
                          hover:bg-slate-900/70
                          hover:shadow-lg hover:shadow-black/20">

                    <div class="flex items-start justify-between gap-5">

                        <div class="flex gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center
                                        justify-center rounded-xl
                                        border border-amber-500/20
                                        bg-amber-500/10 text-amber-300">

                                <svg class="h-5 w-5"
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

                            <div>
                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.12em] text-amber-400">
                                    Campaign History
                                </p>

                                <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                    Session Notes
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Record session summaries, major events,
                                    player decisions, and unresolved story hooks.
                                </p>
                            </div>

                        </div>

                        <span class="mt-1 text-lg text-slate-600
                                     transition group-hover:translate-x-1
                                     group-hover:text-amber-300">
                            →
                        </span>

                    </div>
                </a>

            </div>


            {{-- ========================================================
                 CAMPAIGN AI CONTEXT
            ======================================================== --}}
            <div class="relative mt-4 overflow-hidden rounded-2xl
                        border border-emerald-800/60
                        bg-gradient-to-r from-emerald-950/30
                        via-slate-950 to-slate-950 p-6">

                <div class="pointer-events-none absolute -left-20 -top-20
                            h-48 w-48 rounded-full
                            bg-emerald-500/[0.05] blur-3xl">
                </div>

                <div class="relative flex flex-col gap-5
                            md:flex-row md:items-center md:justify-between">

                    <div class="flex max-w-3xl gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center
                                    justify-center rounded-xl
                                    border border-emerald-500/20
                                    bg-emerald-500/10 text-emerald-300">

                            <svg class="h-5 w-5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <path d="m12 3 1.4 4.2L18 9l-4.6 1.8L12 15l-1.4-4.2L6 9l4.6-1.8Z"/>
                                <path d="m19 15 .8 2.2L22 18l-2.2.8L19 21l-.8-2.2L16 18l2.2-.8Z"/>
                            </svg>

                        </div>

                        <div>
                            <div class="flex flex-wrap items-center gap-3">

                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.14em] text-emerald-400">
                                    Campaign Intelligence
                                </p>

                                <span class="inline-flex items-center gap-1.5
                                             rounded-full border border-emerald-800
                                             bg-emerald-950/40 px-2.5 py-1
                                             text-[10px] font-semibold uppercase
                                             tracking-wide text-emerald-300">

                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                    Active
                                </span>

                            </div>

                            <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                Campaign AI Context
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                AI generation can use this campaign's characters,
                                recent sessions, player decisions, unresolved hooks,
                                encounters, and dungeons to maintain continuity across
                                generated content.
                            </p>
                        </div>

                    </div>

                    <div class="hidden shrink-0 lg:block">
                        <div class="grid grid-cols-2 gap-2 text-xs text-slate-500">

                            <span class="rounded-lg border border-emerald-900/50
                                         bg-emerald-950/20 px-3 py-2">
                                Characters
                            </span>

                            <span class="rounded-lg border border-emerald-900/50
                                         bg-emerald-950/20 px-3 py-2">
                                Sessions
                            </span>

                            <span class="rounded-lg border border-emerald-900/50
                                         bg-emerald-950/20 px-3 py-2">
                                Encounters
                            </span>

                            <span class="rounded-lg border border-emerald-900/50
                                         bg-emerald-950/20 px-3 py-2">
                                Dungeons
                            </span>

                        </div>
                    </div>

                </div>
            </div>

        </section>

    </div>

</x-layouts.app>
