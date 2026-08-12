<x-layouts.app title="Campaign Dungeons / Maps">

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
                        border border-indigo-500/20
                        bg-gradient-to-br from-slate-900 via-slate-950 to-slate-950
                        p-7 md:p-8">

            {{-- Ambient decoration --}}
            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-indigo-500/[0.05] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-14 -top-16
                        h-44 w-44 rounded-full
                        border border-indigo-500/[0.07]">
            </div>


            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div>
                    <div class="mb-3 inline-flex items-center gap-2
                                rounded-full border border-indigo-500/20
                                bg-indigo-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-indigo-300">

                        <svg class="h-3.5 w-3.5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M3 6h18v12H3z"/>
                            <path d="m7 14 3-3 2 2 2-2 3 3"/>
                            <circle cx="8" cy="9" r="1"/>
                        </svg>

                        World Building
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-50">
                        Dungeons & Maps
                    </h1>

                    <p class="mt-2 text-sm text-slate-400">
                        Create and manage locations for
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
             GENERATION OPTIONS
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-indigo-400">
                    Create
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Build a new location
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Choose how you want to generate your next dungeon or map.
                </p>
            </div>


            <div class="grid gap-4 md:grid-cols-2">

                {{-- ====================================================
                     AI MAP GENERATION
                ==================================================== --}}
                <div class="relative overflow-hidden rounded-2xl
                            border border-indigo-500/20
                            bg-gradient-to-br from-indigo-950/30
                            via-slate-950 to-slate-950 p-6">

                    <div class="pointer-events-none absolute -right-12 -top-12
                                h-36 w-36 rounded-full
                                bg-indigo-500/[0.06] blur-2xl">
                    </div>


                    <div class="relative">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0
                                        items-center justify-center
                                        rounded-xl border border-indigo-500/20
                                        bg-indigo-500/10 text-indigo-300">

                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path d="m12 3 1.4 4.2L18 9l-4.6 1.8L12 15l-1.4-4.2L6 9l4.6-1.8Z"/>
                                    <path d="M5 15 3.8 18.2 1 19.5l2.8 1.3L5 24"/>
                                </svg>

                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.14em] text-indigo-400">
                                    AI Generation
                                </p>

                                <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                    Generate AI Map
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Generate a themed dungeon map using the
                                    AI-powered map generation workflow.
                                </p>
                            </div>

                        </div>


                        <a href="{{ route('dungeons.generate', ['campaign' => $campaign->id]) }}"
                           class="mt-6 inline-flex items-center gap-2
                                  rounded-xl bg-indigo-500 px-4 py-2.5
                                  text-sm font-semibold text-white
                                  transition hover:bg-indigo-400">

                            Generate AI Map

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


                {{-- ====================================================
                     PROCEDURAL GENERATION
                ==================================================== --}}
                <div class="relative overflow-hidden rounded-2xl
                            border border-emerald-500/20
                            bg-gradient-to-br from-emerald-950/20
                            via-slate-950 to-slate-950 p-6">

                    <div class="pointer-events-none absolute -right-12 -top-12
                                h-36 w-36 rounded-full
                                bg-emerald-500/[0.05] blur-2xl">
                    </div>


                    <div class="relative">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0
                                        items-center justify-center
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
                                    <path d="M17 10v4"/>
                                    <path d="M10 17h4"/>
                                </svg>

                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.14em] text-emerald-400">
                                    Procedural Generation
                                </p>

                                <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                    Generate Dungeon
                                </h3>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Build an editable dungeon layout using the
                                    procedural room and corridor generator.
                                </p>
                            </div>

                        </div>


                        <a href="{{ route('dungeon-new.create', ['campaign' => $campaign->id]) }}"
                           class="mt-6 inline-flex items-center gap-2
                                  rounded-xl bg-emerald-500 px-4 py-2.5
                                  text-sm font-semibold text-slate-950
                                  transition hover:bg-emerald-400">

                            Create Procedural Dungeon

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

            </div>
        </section>


        {{-- ============================================================
             CAMPAIGN LOCATIONS
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-amber-400">
                    Campaign Locations
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Attached maps & dungeons
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Locations currently connected to {{ $campaign->name }}.
                </p>
            </div>


            {{-- ========================================================
                 ATTACHED AI MAPS
            ======================================================== --}}
            <div class="rounded-2xl border border-indigo-500/20
                        bg-slate-950 p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center
                                rounded-lg border border-indigo-500/20
                                bg-indigo-500/10 text-indigo-300">

                        <svg class="h-4 w-4"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="m12 3 1.4 4.2L18 9l-4.6 1.8L12 15l-1.4-4.2L6 9l4.6-1.8Z"/>
                        </svg>

                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-100">
                            AI Generated Maps
                        </h3>

                        <p class="text-xs text-slate-500">
                            AI-created locations attached to this campaign.
                        </p>
                    </div>

                </div>


                <div class="mt-5 grid gap-4 md:grid-cols-2">

                    @forelse($attachedMaps as $map)

                        <div class="group rounded-xl border border-slate-800
                                    bg-slate-950/60 p-4
                                    transition hover:border-indigo-500/30
                                    hover:bg-slate-900/50">

                            <div class="flex items-start justify-between gap-4">

                                <div class="min-w-0">

                                    <div class="truncate font-semibold text-slate-100">
                                        {{ $map->name ?: 'Untitled Map' }}
                                    </div>

                                    <div class="mt-1 flex flex-wrap items-center
                                                gap-x-2 gap-y-1
                                                text-sm text-slate-400">

                                        <span>
                                            {{ $map->theme ?? 'Unknown theme' }}
                                        </span>

                                        @if($map->room_count)
                                            <span class="text-indigo-500">•</span>

                                            <span>
                                                {{ $map->room_count }} rooms
                                            </span>
                                        @endif

                                    </div>

                                </div>


                                <div class="flex shrink-0 gap-2">

                                    <a href="{{ route('saves.show', ['type' => 'maps', 'id' => $map->id]) }}"
                                       class="inline-flex items-center gap-1.5
                                              rounded-lg bg-indigo-500
                                              px-3 py-2 text-xs font-semibold
                                              text-white transition
                                              hover:bg-indigo-400">
                                        Open
                                        <span>→</span>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('campaigns.maps.detach', [$campaign, $map]) }}">
                                        @csrf

                                        <button type="submit"
                                                class="rounded-lg border
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
                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed
                                    border-slate-800 px-5 py-8
                                    text-center md:col-span-2">

                            <p class="text-sm text-slate-400">
                                No AI maps attached yet.
                            </p>

                            <a href="{{ route('dungeons.generate', ['campaign' => $campaign->id]) }}"
                               class="mt-2 inline-block text-sm font-medium
                                      text-indigo-400 hover:text-indigo-300">
                                Generate your first AI map →
                            </a>

                        </div>

                    @endforelse

                </div>
            </div>


            {{-- ========================================================
                 ATTACHED PROCEDURAL DUNGEONS
            ======================================================== --}}
            <div class="mt-4 rounded-2xl border border-emerald-500/20
                        bg-slate-950 p-6">

                <div class="flex items-center gap-3">

                    <div class="flex h-9 w-9 items-center justify-center
                                rounded-lg border border-emerald-500/20
                                bg-emerald-500/10 text-emerald-300">

                        <svg class="h-4 w-4"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M4 4h6v6H4z"/>
                            <path d="M14 4h6v6h-6z"/>
                            <path d="M4 14h6v6H4z"/>
                            <path d="M14 14h6v6h-6z"/>
                        </svg>

                    </div>

                    <div>
                        <h3 class="font-semibold text-slate-100">
                            Procedural Dungeons
                        </h3>

                        <p class="text-xs text-slate-500">
                            Editable procedural layouts attached to this campaign.
                        </p>
                    </div>

                </div>


                <div class="mt-5 grid gap-4 md:grid-cols-2">

                    @forelse($attachedDungeons as $dungeon)

                        <div class="group rounded-xl border border-slate-800
                                    bg-slate-950/60 p-4
                                    transition hover:border-emerald-500/30
                                    hover:bg-slate-900/50">

                            <div class="flex items-start justify-between gap-4">

                                <div class="min-w-0">

                                    <div class="truncate font-semibold text-slate-100">
                                        {{ $dungeon->name }}
                                    </div>

                                    <div class="mt-1 flex flex-wrap items-center
                                                gap-x-2 gap-y-1
                                                text-sm text-slate-400">

                                        <span>
                                            {{ ucfirst($dungeon->type) }}
                                        </span>

                                        @if($dungeon->seed)
                                            <span class="text-emerald-500">•</span>

                                            <span>
                                                Seed {{ $dungeon->seed }}
                                            </span>
                                        @endif

                                    </div>

                                </div>


                                <div class="flex shrink-0 gap-2">

                                    <a href="{{ route('dungeon-new.show', $dungeon) }}"
                                       class="inline-flex items-center gap-1.5
                                              rounded-lg bg-emerald-500
                                              px-3 py-2 text-xs font-semibold
                                              text-slate-950 transition
                                              hover:bg-emerald-400">
                                        Open
                                        <span>→</span>
                                    </a>

                                    <form method="POST"
                                          action="{{ route('campaigns.dungeons.detach', [$campaign, $dungeon]) }}">
                                        @csrf

                                        <button type="submit"
                                                class="rounded-lg border
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
                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed
                                    border-slate-800 px-5 py-8
                                    text-center md:col-span-2">

                            <p class="text-sm text-slate-400">
                                No procedural dungeons attached yet.
                            </p>

                            <a href="{{ route('dungeon-new.create', ['campaign' => $campaign->id]) }}"
                               class="mt-2 inline-block text-sm font-medium
                                      text-emerald-400 hover:text-emerald-300">
                                Create your first procedural dungeon →
                            </a>

                        </div>

                    @endforelse

                </div>
            </div>

        </section>


        {{-- ============================================================
             IMPORT EXISTING CONTENT
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
                    Attach maps and dungeons you've already created.
                </p>
            </div>


            <div class="grid gap-4 lg:grid-cols-2">

                {{-- ====================================================
                     IMPORT AI MAPS
                ==================================================== --}}
                <div class="rounded-2xl border border-slate-800
                            bg-slate-950 p-5">

                    <div class="flex items-center gap-3">

                        <div class="flex h-8 w-8 items-center justify-center
                                    rounded-lg bg-indigo-500/10
                                    text-indigo-300">
                            ✦
                        </div>

                        <h3 class="font-semibold text-slate-100">
                            AI Maps
                        </h3>

                    </div>


                    <div class="mt-4 space-y-3">

                        @forelse($availableMaps as $map)

                            <div class="flex items-center justify-between gap-4
                                        rounded-xl border border-slate-800
                                        bg-slate-950/50 p-4">

                                <div class="min-w-0">

                                    <div class="truncate text-sm font-semibold
                                                text-slate-200">
                                        {{ $map->name ?: 'Untitled Map' }}
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        {{ $map->theme ?? 'Unknown theme' }}
                                    </div>

                                </div>


                                <form method="POST"
                                      action="{{ route('campaigns.maps.attach', [$campaign, $map]) }}">
                                    @csrf

                                    <button type="submit"
                                            class="rounded-lg border
                                                   border-indigo-500/30
                                                   bg-indigo-500/10
                                                   px-3 py-2 text-xs
                                                   font-semibold text-indigo-300
                                                   transition
                                                   hover:bg-indigo-500/20">
                                        Attach
                                    </button>
                                </form>

                            </div>

                        @empty

                            <div class="rounded-xl border border-dashed
                                        border-slate-800 px-4 py-7
                                        text-center text-sm text-slate-500">
                                No unattached AI maps available.
                            </div>

                        @endforelse

                    </div>
                </div>


                {{-- ====================================================
                     IMPORT PROCEDURAL DUNGEONS
                ==================================================== --}}
                <div class="rounded-2xl border border-slate-800
                            bg-slate-950 p-5">

                    <div class="flex items-center gap-3">

                        <div class="flex h-8 w-8 items-center justify-center
                                    rounded-lg bg-emerald-500/10
                                    text-emerald-300">

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <path d="M4 4h6v6H4z"/>
                                <path d="M14 4h6v6h-6z"/>
                                <path d="M4 14h6v6H4z"/>
                                <path d="M14 14h6v6h-6z"/>
                            </svg>

                        </div>

                        <h3 class="font-semibold text-slate-100">
                            Procedural Dungeons
                        </h3>

                    </div>


                    <div class="mt-4 space-y-3">

                        @forelse($availableDungeons as $dungeon)

                            <div class="flex items-center justify-between gap-4
                                        rounded-xl border border-slate-800
                                        bg-slate-950/50 p-4">

                                <div class="min-w-0">

                                    <div class="truncate text-sm font-semibold
                                                text-slate-200">
                                        {{ $dungeon->name }}
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        {{ ucfirst($dungeon->type) }}
                                    </div>

                                </div>


                                <form method="POST"
                                      action="{{ route('campaigns.dungeons.attach', [$campaign, $dungeon]) }}">
                                    @csrf

                                    <button type="submit"
                                            class="rounded-lg border
                                                   border-emerald-500/30
                                                   bg-emerald-500/10
                                                   px-3 py-2 text-xs
                                                   font-semibold text-emerald-300
                                                   transition
                                                   hover:bg-emerald-500/20">
                                        Attach
                                    </button>
                                </form>

                            </div>

                        @empty

                            <div class="rounded-xl border border-dashed
                                        border-slate-800 px-4 py-7
                                        text-center text-sm text-slate-500">
                                No unattached procedural dungeons available.
                            </div>

                        @endforelse

                    </div>
                </div>

            </div>
        </section>

    </div>

</x-layouts.app>
