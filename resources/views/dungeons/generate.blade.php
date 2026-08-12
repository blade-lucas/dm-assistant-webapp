<x-layouts.app title="AI Dungeon Generator">

    <div class="mx-auto max-w-7xl space-y-8">

        {{-- ============================================================
             STATUS
        ============================================================ --}}
        @if(session('status'))
            <div class="flex items-center gap-3 rounded-2xl
                        border border-emerald-800/60
                        bg-emerald-950/30 px-5 py-4
                        text-sm text-emerald-200">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center
                            rounded-full bg-emerald-500/10 text-emerald-300">
                    ✓
                </div>

                {{ session('status') }}
            </div>
        @endif


        {{-- ============================================================
             HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-indigo-500/20
                        bg-gradient-to-br from-slate-900
                        via-indigo-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-80 w-80 rounded-full
                        bg-indigo-500/[0.08] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-16 -top-20
                        h-48 w-48 rounded-full
                        border border-indigo-500/[0.08]">
            </div>

            <div class="relative flex flex-col gap-7
                        lg:flex-row lg:items-start lg:justify-between">

                <div class="max-w-3xl">

                    <div class="mb-4 inline-flex items-center gap-2
                                rounded-full border border-indigo-500/20
                                bg-indigo-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-indigo-300">

                        <svg class="h-3.5 w-3.5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M12 3v4"/>
                            <path d="M12 17v4"/>
                            <path d="M3 12h4"/>
                            <path d="M17 12h4"/>
                            <path d="m5.6 5.6 2.8 2.8"/>
                            <path d="m15.6 15.6 2.8 2.8"/>
                            <path d="m18.4 5.6-2.8 2.8"/>
                            <path d="m8.4 15.6-2.8 2.8"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>

                        AI Generation Studio
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Map & Story Generator
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6
                              text-slate-400">
                        Generate a dungeon map and a playable adventure
                        together. The map is produced by the dungeon model
                        while the story generator builds encounters, clues,
                        treasure, and narrative around the result.
                    </p>


                    <div class="mt-6 flex flex-wrap gap-2">

                        <span class="inline-flex items-center gap-2
                                     rounded-full border border-indigo-500/20
                                     bg-indigo-500/[0.06]
                                     px-3 py-1.5 text-xs text-indigo-300">
                            <span class="h-1.5 w-1.5 rounded-full
                                         bg-indigo-400"></span>
                            AI Map Generation
                        </span>

                        <span class="inline-flex items-center gap-2
                                     rounded-full border border-violet-500/20
                                     bg-violet-500/[0.06]
                                     px-3 py-1.5 text-xs text-violet-300">
                            <span class="h-1.5 w-1.5 rounded-full
                                         bg-violet-400"></span>
                            AI Story Generation
                        </span>

                        @if(request('campaign'))
                            <span class="inline-flex items-center gap-2
                                         rounded-full border
                                         border-emerald-500/20
                                         bg-emerald-500/[0.06]
                                         px-3 py-1.5 text-xs
                                         text-emerald-300">

                                <span class="h-1.5 w-1.5 rounded-full
                                             bg-emerald-400"></span>

                                Campaign-Aware
                            </span>
                        @endif

                    </div>
                </div>


                @if(request('campaign'))

                    <a href="{{ route('campaigns.dungeons.index', request('campaign')) }}"
                       class="inline-flex shrink-0 items-center gap-2
                              rounded-xl border border-slate-700
                              bg-slate-900/60 px-4 py-2
                              text-sm font-medium text-slate-300
                              transition hover:border-indigo-500/30
                              hover:bg-slate-800 hover:text-white">

                        <span>←</span>
                        Back to Campaign
                    </a>

                @else

                    <a href="{{ route('maps.index') }}"
                       class="inline-flex shrink-0 items-center gap-2
                              rounded-xl border border-slate-700
                              bg-slate-900/60 px-4 py-2
                              text-sm font-medium text-slate-300
                              transition hover:border-indigo-500/30
                              hover:bg-slate-800 hover:text-white">

                        <span>←</span>
                        Saved Maps
                    </a>

                @endif

            </div>
        </section>


        {{-- ============================================================
             VALIDATION
        ============================================================ --}}
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
        @if(request('campaign'))
            <section class="relative overflow-hidden rounded-2xl
                            border border-emerald-500/20
                            bg-gradient-to-r from-emerald-950/20
                            via-slate-950 to-slate-950 p-5">

                <div class="absolute -right-12 -top-12 h-36 w-36
                            rounded-full bg-emerald-500/[0.05]
                            blur-2xl">
                </div>

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
                                         font-semibold uppercase
                                         tracking-wider text-emerald-400">
                                RAG Enabled
                            </span>

                        </div>

                        <p class="mt-1 max-w-3xl text-sm leading-6
                                  text-slate-400">
                            Story generation can reference this campaign's
                            characters, recent sessions, player decisions,
                            unresolved hooks, and existing content to maintain
                            continuity with your adventure.
                        </p>

                    </div>
                </div>
            </section>
        @endif


        {{-- ============================================================
             GENERATION PARAMETERS
        ============================================================ --}}
        <section class="overflow-hidden rounded-3xl
                        border border-slate-800 bg-slate-950">

            <div class="border-b border-slate-800 px-6 py-5">

                <div class="flex items-center gap-4">

                    <div class="flex h-10 w-10 items-center justify-center
                                rounded-xl border border-indigo-500/20
                                bg-indigo-500/10 text-indigo-300">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.7">
                            <path d="M4 6h16"/>
                            <path d="M7 12h10"/>
                            <path d="M10 18h4"/>
                        </svg>

                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.16em] text-indigo-400">
                            Step 1
                        </p>

                        <h2 class="text-lg font-semibold text-slate-100">
                            Configure Generation
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Define the dungeon you want the models to create.
                        </p>
                    </div>

                </div>
            </div>


            <form id="dungeonParamsForm"
                  class="grid gap-5 p-6
                         md:grid-cols-2 xl:grid-cols-12">

                @csrf


                {{-- NAME --}}
                <div class="xl:col-span-4">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Dungeon Name
                    </label>

                    <input id="name"
                           name="name"
                           value="{{ old('name') }}"
                           placeholder="e.g. The Forgotten Vaults"
                           class="mt-2 w-full rounded-xl
                                  border border-slate-800
                                  bg-slate-950 px-4 py-3
                                  text-sm text-slate-100
                                  outline-none transition
                                  placeholder:text-slate-600
                                  focus:border-indigo-500/40
                                  focus:ring-1
                                  focus:ring-indigo-500/20">

                </div>


                {{-- THEME --}}
                <div class="xl:col-span-2">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Theme
                    </label>

                    <select id="theme"
                            name="theme"
                            class="mt-2 w-full rounded-xl
                                   border border-slate-800
                                   bg-slate-950 px-4 py-3
                                   text-sm text-slate-100
                                   outline-none transition
                                   focus:border-indigo-500/40
                                   focus:ring-1
                                   focus:ring-indigo-500/20">

                        <option value="dungeon">Dungeon</option>
                        <option value="crypt">Crypt</option>
                        <option value="cave">Cave</option>
                        <option value="forest">Forest</option>
                        <option value="volcanic">Volcanic</option>
                        <option value="ice_cavern">Ice Cavern</option>

                    </select>

                </div>


                {{-- ROOMS --}}
                <div class="xl:col-span-2">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Rooms
                    </label>

                    <input id="room_count"
                           type="number"
                           name="room_count"
                           min="3"
                           max="50"
                           value="{{ old('room_count', 10) }}"
                           class="mt-2 w-full rounded-xl
                                  border border-slate-800
                                  bg-slate-950 px-4 py-3
                                  text-sm text-slate-100
                                  outline-none transition
                                  focus:border-indigo-500/40
                                  focus:ring-1
                                  focus:ring-indigo-500/20">

                </div>


                {{-- TONE --}}
                <div class="xl:col-span-2">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Story Tone
                    </label>

                    <select id="tone"
                            name="tone"
                            class="mt-2 w-full rounded-xl
                                   border border-slate-800
                                   bg-slate-950 px-4 py-3
                                   text-sm text-slate-100
                                   outline-none transition
                                   focus:border-violet-500/40
                                   focus:ring-1
                                   focus:ring-violet-500/20">

                        @foreach(['Mysterious','Heroic','Dark','Ancient','Creepy'] as $opt)
                            <option value="{{ $opt }}">
                                {{ $opt }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- GENERATE --}}
                <div class="flex items-end xl:col-span-2">

                    <button id="generateMapBtn"
                            type="button"
                            class="group inline-flex w-full
                                   items-center justify-center gap-2
                                   rounded-xl bg-indigo-500
                                   px-5 py-3
                                   text-sm font-semibold text-white
                                   shadow-lg shadow-indigo-950/20
                                   transition
                                   hover:bg-indigo-400
                                   disabled:cursor-not-allowed
                                   disabled:opacity-50">

                        <svg class="h-4 w-4"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M12 3v4"/>
                            <path d="M12 17v4"/>
                            <path d="M3 12h4"/>
                            <path d="M17 12h4"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>

                        Generate Dungeon

                    </button>

                </div>


                {{-- ====================================================
                     CURRENTLY DISABLED / FUTURE PARAMETERS
                ==================================================== --}}
                <div class="md:col-span-2 xl:col-span-12">

                    <div class="mt-1 flex flex-wrap gap-3
                                border-t border-slate-800 pt-5">

                        <div class="mr-2 flex items-center">
                            <span class="text-[10px] font-semibold
                                         uppercase tracking-[0.14em]
                                         text-slate-600">
                                Future Controls
                            </span>
                        </div>


                        <div>
                            <label class="sr-only">Size</label>

                            <select disabled
                                    id="size"
                                    name="size"
                                    class="rounded-lg border border-slate-800
                                           bg-slate-900 px-3 py-2
                                           text-xs text-slate-600
                                           opacity-60">

                                @foreach(['small','medium','large','huge'] as $opt)
                                    <option value="{{ $opt }}">
                                        Size: {{ ucfirst($opt) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                        <div>
                            <label class="sr-only">Difficulty</label>

                            <select disabled
                                    id="difficulty"
                                    name="difficulty"
                                    class="rounded-lg border border-slate-800
                                           bg-slate-900 px-3 py-2
                                           text-xs text-slate-600
                                           opacity-60">

                                @foreach(['easy','medium','hard','deadly'] as $opt)
                                    <option value="{{ $opt }}">
                                        Difficulty: {{ ucfirst($opt) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                        <div>
                            <label class="sr-only">Encounter Density</label>

                            <select disabled
                                    id="encounter_density"
                                    name="encounter_density"
                                    class="rounded-lg border border-slate-800
                                           bg-slate-900 px-3 py-2
                                           text-xs text-slate-600
                                           opacity-60">

                                @foreach(['low','medium','high'] as $opt)
                                    <option value="{{ $opt }}">
                                        Encounters: {{ ucfirst($opt) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>


                        <div>
                            <label class="sr-only">Treasure Density</label>

                            <select disabled
                                    id="treasure_density"
                                    name="treasure_density"
                                    class="rounded-lg border border-slate-800
                                           bg-slate-900 px-3 py-2
                                           text-xs text-slate-600
                                           opacity-60">

                                @foreach(['low','medium','high'] as $opt)
                                    <option value="{{ $opt }}">
                                        Treasure: {{ ucfirst($opt) }}
                                    </option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                </div>

            </form>
        </section>


        {{-- ============================================================
             GENERATED OUTPUT
        ============================================================ --}}
        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-indigo-400">
                    Step 2
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Generated Dungeon
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Your map and adventure are generated together as a
                    single playable dungeon.
                </p>

            </div>


            <div class="grid gap-6 xl:grid-cols-[minmax(0,1.6fr)_minmax(360px,1fr)]">

                {{-- ====================================================
                     MAP
                ==================================================== --}}
                <div class="overflow-hidden rounded-3xl
                            border border-indigo-500/20
                            bg-slate-950">

                    <div class="flex items-center justify-between
                                border-b border-slate-800
                                bg-gradient-to-r
                                from-indigo-950/20 to-slate-950
                                px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center
                                        justify-center rounded-lg
                                        bg-indigo-500/10 text-indigo-300">

                                <svg class="h-4 w-4"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.8">
                                    <path d="M3 6h18v12H3z"/>
                                    <path d="m7 14 3-3 2 2 2-2 3 3"/>
                                </svg>

                            </div>

                            <div>
                                <div class="text-sm font-semibold
                                            text-slate-100">
                                    Dungeon Map
                                </div>

                                <div class="text-xs text-slate-500">
                                    AI-generated layout
                                </div>
                            </div>

                        </div>


                        <span class="rounded-full border
                                     border-indigo-500/20
                                     bg-indigo-500/10
                                     px-2.5 py-1
                                     text-[10px] font-semibold
                                     uppercase tracking-wider
                                     text-indigo-300">
                            Map Model
                        </span>

                    </div>


                    <div class="p-4">

                        {{-- EMPTY --}}
                        <div id="placeholder"
                             class="flex h-[650px]
                                    flex-col items-center justify-center
                                    rounded-2xl border border-dashed
                                    border-slate-800
                                    bg-slate-950/50 px-6 text-center">

                            <div class="flex h-14 w-14 items-center
                                        justify-center rounded-2xl
                                        border border-indigo-500/20
                                        bg-indigo-500/10 text-indigo-300">

                                <svg class="h-7 w-7"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.6">
                                    <path d="M4 4h6v6H4z"/>
                                    <path d="M14 4h6v6h-6z"/>
                                    <path d="M4 14h6v6H4z"/>
                                    <path d="M14 14h6v6h-6z"/>
                                </svg>

                            </div>

                            <h3 class="mt-4 font-semibold text-slate-300">
                                No map generated yet
                            </h3>

                            <p class="mt-2 max-w-sm text-sm
                                      leading-6 text-slate-500">
                                Configure your dungeon above and generate
                                to create a new map.
                            </p>

                        </div>


                        {{-- LOADING --}}
                        <div id="loading"
                             class="hidden h-[650px]
                                    flex-col items-center justify-center
                                    rounded-2xl border border-dashed
                                    border-indigo-500/20
                                    bg-indigo-950/10 text-center">

                            <div class="h-10 w-10 animate-spin
                                        rounded-full border-2
                                        border-indigo-500/20
                                        border-t-indigo-400">
                            </div>

                            <h3 class="mt-5 font-semibold text-indigo-200">
                                Generating dungeon map...
                            </h3>

                            <p class="mt-2 text-sm text-slate-500">
                                The map model is building your layout.
                            </p>

                        </div>


                        {{-- IMAGE --}}
                        <img id="mapImage"
                             alt="Generated dungeon map"
                             class="hidden h-[650px] w-full
                                    rounded-2xl border border-slate-800
                                    bg-black/20 object-contain shadow-2xl" />


                        {{-- SAVE --}}
                        <div id="saveMapContainer"
                             class="mt-4 hidden rounded-2xl
                                    border border-slate-800
                                    bg-slate-900/40 p-4">

                            @auth

                                <form method="POST"
                                      action="{{ route('maps.store') }}"
                                      class="flex flex-col gap-3
                                             lg:flex-row lg:items-center">

                                    @csrf

                                    <div class="flex-1">

                                        <label class="text-[10px] font-semibold
                                                      uppercase tracking-wider
                                                      text-slate-500">
                                            Save Generated Dungeon
                                        </label>

                                        <input type="text"
                                               name="name"
                                               id="save_name"
                                               placeholder="Name this map..."
                                               class="mt-1.5 w-full
                                                      rounded-xl border
                                                      border-slate-800
                                                      bg-slate-950
                                                      px-4 py-2.5
                                                      text-sm text-slate-100
                                                      outline-none
                                                      placeholder:text-slate-600
                                                      focus:border-indigo-500/40">

                                    </div>


                                    @if(request('campaign'))
                                        <input type="hidden"
                                               name="campaign_id"
                                               value="{{ (int) request('campaign') }}">
                                    @endif

                                    <input type="hidden" name="theme" id="save_theme">
                                    <input type="hidden" name="size" id="save_size">
                                    <input type="hidden" name="difficulty" id="save_difficulty">
                                    <input type="hidden" name="room_count" id="save_room_count">
                                    <input type="hidden" name="encounter_density" id="save_encounter_density">
                                    <input type="hidden" name="treasure_density" id="save_treasure_density">
                                    <input type="hidden" name="tone" id="save_tone">
                                    <input type="hidden" name="image_base64" id="save_image_base64">
                                    <input type="hidden" name="story_text" id="save_story_text">
                                    <input type="hidden" name="story_meta" id="save_story_meta">


                                    <button type="submit"
                                            class="inline-flex shrink-0
                                                   items-center justify-center
                                                   gap-2 rounded-xl
                                                   bg-indigo-500
                                                   px-5 py-2.5
                                                   text-sm font-semibold
                                                   text-white transition
                                                   hover:bg-indigo-400">

                                        Save Dungeon
                                        <span>→</span>

                                    </button>

                                </form>

                            @else

                                <div class="flex items-center justify-between gap-4">

                                    <p class="text-sm text-slate-400">
                                        Want to keep this dungeon?
                                    </p>

                                    <a href="{{ route('login') }}"
                                       class="rounded-xl bg-indigo-500
                                              px-4 py-2 text-sm
                                              font-semibold text-white
                                              transition hover:bg-indigo-400">
                                        Log in to Save
                                    </a>

                                </div>

                            @endauth

                        </div>
                    </div>
                </div>


                {{-- ====================================================
                     STORY
                ==================================================== --}}
                <div class="overflow-hidden rounded-3xl
                            border border-violet-500/20
                            bg-slate-950">

                    <div class="flex items-center justify-between
                                border-b border-slate-800
                                bg-gradient-to-r
                                from-violet-950/20 to-slate-950
                                px-5 py-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center
                                        justify-center rounded-lg
                                        bg-violet-500/10 text-violet-300">
                                ✦
                            </div>

                            <div>
                                <div class="text-sm font-semibold
                                            text-slate-100">
                                    Adventure Story
                                </div>

                                <div class="text-xs text-slate-500">
                                    Generated from the dungeon
                                </div>
                            </div>

                        </div>


                        <span class="rounded-full border
                                     border-violet-500/20
                                     bg-violet-500/10
                                     px-2.5 py-1
                                     text-[10px] font-semibold
                                     uppercase tracking-wider
                                     text-violet-300">

                            @if(request('campaign'))
                                RAG + AI
                            @else
                                AI Story
                            @endif

                        </span>

                    </div>


                    <div class="p-4">

                        <div class="h-[650px] rounded-2xl
                                    border border-slate-800
                                    bg-slate-950/50 p-5">

                            {{-- EMPTY --}}
                            <div id="storyPlaceholder"
                                 class="flex h-full flex-col
                                        items-center justify-center
                                        px-5 text-center">

                                <div class="flex h-14 w-14 items-center
                                            justify-center rounded-2xl
                                            border border-violet-500/20
                                            bg-violet-500/10
                                            text-xl text-violet-300">
                                    ✦
                                </div>

                                <h3 class="mt-4 font-semibold text-slate-300">
                                    Your adventure awaits
                                </h3>

                                <p class="mt-2 max-w-xs text-sm
                                          leading-6 text-slate-500">
                                    The generated dungeon story, encounters,
                                    treasure, and secrets will appear here.
                                </p>

                            </div>


                            {{-- LOADING --}}
                            <div id="storyLoading"
                                 class="hidden h-full
                                        flex-col items-center justify-center
                                        text-center">

                                <div class="h-10 w-10 animate-spin
                                            rounded-full border-2
                                            border-violet-500/20
                                            border-t-violet-400">
                                </div>

                                <h3 class="mt-5 font-semibold
                                           text-violet-200">
                                    Writing your adventure...
                                </h3>

                                <p class="mt-2 max-w-xs text-sm
                                          leading-6 text-slate-500">

                                    @if(request('campaign'))
                                        Retrieving campaign context and
                                        constructing a connected dungeon story.
                                    @else
                                        Building encounters, clues, treasure,
                                        and narrative for this dungeon.
                                    @endif

                                </p>

                            </div>


                            {{-- STORY --}}
                            <div id="storyOutput"
                                 class="hidden h-full overflow-y-auto
                                        whitespace-pre-line pr-3
                                        text-sm leading-7 text-slate-300
                                        scroll-smooth">
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>


        {{-- ============================================================
             FEEDBACK
        ============================================================ --}}
        <section class="overflow-hidden rounded-3xl
                        border border-slate-800 bg-slate-950">

            <div class="border-b border-slate-800 px-6 py-5">

                <div class="flex items-start gap-4">

                    <div class="flex h-10 w-10 shrink-0
                                items-center justify-center
                                rounded-xl border border-slate-700
                                bg-slate-900 text-slate-400">

                        <svg class="h-5 w-5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.7">
                            <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/>
                        </svg>

                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.16em] text-slate-500">
                            Help Improve Generation
                        </p>

                        <h2 class="mt-1 text-lg font-semibold text-slate-100">
                            Generation Feedback
                        </h2>

                        <p class="mt-1 max-w-2xl text-sm
                                  leading-6 text-slate-500">
                            Tell us what worked, what didn't, and how the
                            generated maps or stories could be improved.
                        </p>
                    </div>

                </div>
            </div>


            <form method="POST"
                  action="{{ route('feedback.maps.store') }}"
                  class="grid gap-5 p-6">

                @csrf


                <div class="grid gap-5 md:grid-cols-2">

                    <div>

                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Feedback Type
                        </label>

                        <select name="feedback_type"
                                class="mt-2 w-full rounded-xl
                                       border border-slate-800
                                       bg-slate-950 px-4 py-3
                                       text-sm text-slate-100
                                       outline-none
                                       focus:border-indigo-500/40">

                            <option value="general">General Feedback</option>
                            <option value="bug">Bug Report</option>
                            <option value="balance">Balance Concern</option>
                            <option value="feature">Feature Request</option>

                        </select>

                    </div>


                    <input type="hidden"
                           name="map_id"
                           id="feedback_map_id">

                    <input type="hidden"
                           name="theme"
                           id="feedback_theme">

                    <input type="hidden"
                           name="tone"
                           id="feedback_tone">


                    <div>

                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Dungeon Name
                        </label>

                        <input name="dungeon_name"
                               id="feedback_dungeon_name"
                               placeholder="Auto-filled after generation"
                               class="mt-2 w-full rounded-xl
                                      border border-slate-800
                                      bg-slate-950 px-4 py-3
                                      text-sm text-slate-100
                                      outline-none
                                      placeholder:text-slate-600
                                      focus:border-indigo-500/40">

                    </div>

                </div>


                <div>

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Comments
                    </label>

                    <textarea name="comments"
                              rows="5"
                              placeholder="What did you think of this generated dungeon?"
                              class="mt-2 w-full rounded-xl
                                     border border-slate-800
                                     bg-slate-950 px-4 py-3
                                     text-sm leading-6 text-slate-100
                                     outline-none
                                     placeholder:text-slate-600
                                     focus:border-indigo-500/40"></textarea>

                </div>


                <div class="grid gap-5 md:grid-cols-3">

                    <div>
                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Map Quality
                        </label>

                        <select name="map_rating"
                                class="mt-2 w-full rounded-xl
                                       border border-slate-800
                                       bg-slate-950 px-4 py-3
                                       text-sm text-slate-100">

                            <option value="">Select rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Weak</option>
                            <option value="3">3 - Okay</option>
                            <option value="4">4 - Good</option>
                            <option value="5">5 - Excellent</option>

                        </select>
                    </div>


                    <div>
                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Layout Quality
                        </label>

                        <select name="layout_rating"
                                class="mt-2 w-full rounded-xl
                                       border border-slate-800
                                       bg-slate-950 px-4 py-3
                                       text-sm text-slate-100">

                            <option value="">Select rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Weak</option>
                            <option value="3">3 - Okay</option>
                            <option value="4">4 - Good</option>
                            <option value="5">5 - Excellent</option>

                        </select>
                    </div>


                    <div>
                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Overall Experience
                        </label>

                        <select name="overall_rating"
                                class="mt-2 w-full rounded-xl
                                       border border-slate-800
                                       bg-slate-950 px-4 py-3
                                       text-sm text-slate-100">

                            <option value="">Select rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Weak</option>
                            <option value="3">3 - Okay</option>
                            <option value="4">4 - Good</option>
                            <option value="5">5 - Excellent</option>

                        </select>
                    </div>

                </div>


                <div class="flex justify-end
                            border-t border-slate-800 pt-5">

                    <button type="submit"
                            class="rounded-xl border border-slate-700
                                   bg-slate-900 px-5 py-2.5
                                   text-sm font-semibold text-slate-200
                                   transition hover:border-indigo-500/30
                                   hover:bg-slate-800 hover:text-white">
                        Submit Feedback
                    </button>

                </div>

            </form>
        </section>

    </div>

    <script>
        const generateBtn = document.getElementById('generateMapBtn');
        const placeholder = document.getElementById('placeholder');
        const loading = document.getElementById('loading');
        const mapImage = document.getElementById('mapImage');
        const saveMapContainer = document.getElementById('saveMapContainer');
        const storyPlaceholder = document.getElementById('storyPlaceholder');
        const storyLoading = document.getElementById('storyLoading');
        const storyOutput = document.getElementById('storyOutput');

        generateBtn?.addEventListener('click', async () => {
            const formData = new FormData();

            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('theme', document.getElementById('theme').value);
            formData.append('room_count', document.getElementById('room_count').value);
            formData.append('tone', document.getElementById('tone').value);
            formData.append('difficulty', document.getElementById('difficulty')?.value ?? 'medium');
            @if(request('campaign'))
                formData.append('campaign_id', @json((int) request('campaign')));
            @endif

            // Reset UI state
            placeholder.classList.add('hidden');
            mapImage.classList.add('hidden');
            saveMapContainer.classList.add('hidden');

            storyPlaceholder.classList.add('hidden');
            storyOutput.classList.add('hidden');

            loading.classList.remove('hidden');
            loading.classList.add('flex');

            storyPlaceholder.classList.add('hidden');
            storyOutput.classList.add('hidden');
            storyLoading.classList.remove('hidden');
            storyLoading.classList.add('flex');
            storyOutput.textContent = '';

            generateBtn.disabled = true;

            try {
                const response = await fetch("{{ route('dungeons.generate.map') }}", {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                const contentType = response.headers.get('content-type') || '';

                let data = null;

                if (contentType.includes('application/json')) {
                    data = await response.json();
                } else {
                    const rawText = await response.text();

                    console.error('Map generation returned a non-JSON response:', {
                        status: response.status,
                        statusText: response.statusText,
                        body: rawText,
                    });

                    if (response.status === 504) {
                        throw new Error(
                            'Map generation took too long to respond. Please try again.'
                        );
                    }

                    if (response.status === 502 || response.status === 503) {
                        throw new Error(
                            'The generation service is temporarily unavailable. Please try again shortly.'
                        );
                    }

                    throw new Error(
                        'The server returned an unexpected response. Please try again.'
                    );
                }

                if (!response.ok) {
                    throw new Error(
                        data?.error ||
                        data?.message ||
                        'Map generation failed. Please try again.'
                    );
                }

                if (!data?.image) {
                    throw new Error(
                        data?.error ||
                        'The map service completed without returning an image.'
                    );
                }

                const imageSrc = data.image.startsWith('data:image')
                    ? data.image
                    : `data:image/png;base64,${data.image}`;

                // Display generated map
                mapImage.src = imageSrc;
                mapImage.classList.remove('hidden');

                if (saveMapContainer) {
                    saveMapContainer.classList.remove('hidden');
                }

                // Populate authenticated save form if it exists
                const saveName = document.getElementById('save_name');

                if (saveName) {
                    saveName.value = document.getElementById('name')?.value ?? '';

                    const saveTheme = document.getElementById('save_theme');
                    if (saveTheme) {
                        saveTheme.value = document.getElementById('theme')?.value ?? '';
                    }

                    const saveSize = document.getElementById('save_size');
                    if (saveSize) {
                        saveSize.value = document.getElementById('size')?.value ?? '';
                    }

                    const saveDifficulty = document.getElementById('save_difficulty');
                    if (saveDifficulty) {
                        saveDifficulty.value = document.getElementById('difficulty')?.value ?? '';
                    }

                    const saveRoomCount = document.getElementById('save_room_count');
                    if (saveRoomCount) {
                        saveRoomCount.value = document.getElementById('room_count')?.value ?? '';
                    }

                    const saveEncounterDensity = document.getElementById('save_encounter_density');
                    if (saveEncounterDensity) {
                        saveEncounterDensity.value =
                            document.getElementById('encounter_density')?.value ?? '';
                    }

                    const saveTreasureDensity = document.getElementById('save_treasure_density');
                    if (saveTreasureDensity) {
                        saveTreasureDensity.value =
                            document.getElementById('treasure_density')?.value ?? '';
                    }

                    const saveTone = document.getElementById('save_tone');
                    if (saveTone) {
                        saveTone.value = document.getElementById('tone')?.value ?? '';
                    }

                    const saveImage = document.getElementById('save_image_base64');
                    if (saveImage) {
                        saveImage.value = imageSrc;
                    }

                    const saveStoryText = document.getElementById('save_story_text');
                    if (saveStoryText) {
                        saveStoryText.value = data.story_text || '';
                    }

                    const saveStoryMeta = document.getElementById('save_story_meta');
                    if (saveStoryMeta) {
                        saveStoryMeta.value = data.story_meta
                            ? JSON.stringify(data.story_meta)
                            : '';
                    }
                }

                // Populate feedback fields if they exist
                const feedbackDungeonName =
                    document.getElementById('feedback_dungeon_name');

                if (feedbackDungeonName) {
                    feedbackDungeonName.value =
                        document.getElementById('name')?.value ?? '';

                    const feedbackTheme = document.getElementById('feedback_theme');
                    if (feedbackTheme) {
                        feedbackTheme.value =
                            document.getElementById('theme')?.value ?? '';
                    }

                    const feedbackTone = document.getElementById('feedback_tone');
                    if (feedbackTone) {
                        feedbackTone.value =
                            document.getElementById('tone')?.value ?? '';
                    }
                }

                // Story output
                if (data.story_text) {
                    storyOutput.textContent = data.story_text;
                    storyOutput.classList.remove('hidden');

                    if (storyPlaceholder) {
                        storyPlaceholder.classList.add('hidden');
                    }
                } else {
                    storyPlaceholder.textContent =
                        'Map generated, but no story was returned.';
                    storyPlaceholder.classList.remove('hidden');
                }

            } catch (error) {
                console.error('Dungeon generation error:', error);

                alert(error.message || 'Map generation failed.');

                placeholder.classList.remove('hidden');

                storyPlaceholder.textContent = 'Unable to complete generation.';
                storyPlaceholder.classList.remove('hidden');

            } finally {
                loading.classList.add('hidden');
                loading.classList.remove('flex');

                storyLoading.classList.add('hidden');

                generateBtn.disabled = false;
            }
        });
    </script>
</x-layouts.app>
