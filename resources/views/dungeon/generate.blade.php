<x-layouts.app title="Procedural Dungeon Generator">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- ============================================================
             HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-emerald-500/20
                        bg-gradient-to-br from-slate-900
                        via-emerald-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-80 w-80 rounded-full
                        bg-emerald-500/[0.07] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-14 -top-20
                        h-48 w-48 rounded-full
                        border border-emerald-500/[0.08]">
            </div>

            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div class="max-w-2xl">

                    <div class="mb-4 inline-flex items-center gap-2
                                rounded-full border border-emerald-500/20
                                bg-emerald-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-emerald-300">

                        <svg class="h-3.5 w-3.5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M4 4h6v6H4z"/>
                            <path d="M14 4h6v6h-6z"/>
                            <path d="M4 14h6v6H4z"/>
                            <path d="M14 14h6v6h-6z"/>
                            <path d="M10 7h4"/>
                            <path d="M7 10v4"/>
                            <path d="M17 10v4"/>
                            <path d="M10 17h4"/>
                        </svg>

                        Procedural Generation
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Build an Editable Dungeon
                    </h1>

                    <p class="mt-3 text-sm leading-6 text-slate-400">
                        Generate a structured dungeon from configurable room and
                        map parameters, then open it in the interactive editor
                        to move rooms, resize spaces, place doors, and customize
                        room details.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-2">

                        <span class="rounded-full border border-emerald-500/20
                                     bg-emerald-500/[0.06]
                                     px-3 py-1.5 text-xs text-emerald-300">
                            Deterministic Seeds
                        </span>

                        <span class="rounded-full border border-slate-700
                                     bg-slate-900/60
                                     px-3 py-1.5 text-xs text-slate-400">
                            Interactive Editor
                        </span>

                        <span class="rounded-full border border-slate-700
                                     bg-slate-900/60
                                     px-3 py-1.5 text-xs text-slate-400">
                            Editable Rooms
                        </span>

                        <span class="rounded-full border border-slate-700
                                     bg-slate-900/60
                                     px-3 py-1.5 text-xs text-slate-400">
                            Door Placement
                        </span>

                    </div>

                </div>

                @if(request('campaign'))
                    <a href="{{ route('campaigns.dungeons.index', request('campaign')) }}"
                       class="inline-flex shrink-0 items-center gap-2
                              rounded-xl border border-slate-700
                              bg-slate-900/60 px-4 py-2
                              text-sm font-medium text-slate-300
                              transition hover:border-emerald-500/30
                              hover:bg-slate-800">

                        <span>←</span>
                        Back to Campaign
                    </a>
                @else
                    <a href="{{ route('dungeon-new.list') }}"
                       class="inline-flex shrink-0 items-center gap-2
                              rounded-xl border border-slate-700
                              bg-slate-900/60 px-4 py-2
                              text-sm font-medium text-slate-300
                              transition hover:border-emerald-500/30
                              hover:bg-slate-800">

                        Saved Dungeons
                    </a>
                @endif

            </div>
        </section>


        {{-- ============================================================
             ERRORS
        ============================================================ --}}
        @if ($errors->any())

            <div class="rounded-2xl border border-red-900
                        bg-red-950/30 p-5 text-sm text-red-200">

                <div class="font-semibold">
                    There were problems with your generation settings:
                </div>

                <ul class="mt-2 list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        {{-- ============================================================
             GENERATION FORM
        ============================================================ --}}
        <section class="overflow-hidden rounded-3xl
                        border border-slate-800 bg-slate-950">

            <div class="border-b border-slate-800 px-6 py-5">

                <div class="flex items-center gap-4">

                    <div class="flex h-10 w-10 items-center justify-center
                                rounded-xl border border-emerald-500/20
                                bg-emerald-500/10 text-emerald-300">

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
                                  tracking-[0.16em] text-emerald-400">
                            Generation Settings
                        </p>

                        <h2 class="mt-1 text-lg font-semibold text-slate-100">
                            Configure your dungeon
                        </h2>

                        <p class="mt-0.5 text-xs text-slate-500">
                            Choose a preset for a quick start or customize every setting.
                        </p>
                    </div>

                </div>
            </div>


            <form method="GET"
                  action="{{ route('dungeon-new.viewer') }}"
                  class="grid gap-6 p-6">

                @if(request('campaign'))
                    <input type="hidden"
                           name="campaign_id"
                           value="{{ (int) request('campaign') }}">
                @endif


                {{-- ====================================================
                     PRESET
                ==================================================== --}}
                <div class="rounded-2xl border border-emerald-500/20
                            bg-emerald-950/10 p-5">

                    <div class="grid gap-5 md:grid-cols-[1fr_2fr]
                                md:items-center">

                        <div>
                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.14em] text-emerald-400">
                                Quick Start
                            </p>

                            <h3 class="mt-1 font-semibold text-slate-100">
                                Dungeon Preset
                            </h3>

                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                Load recommended dimensions, room counts, and themes.
                            </p>
                        </div>


                        <select id="preset"
                                class="w-full rounded-xl
                                       border border-emerald-500/20
                                       bg-slate-950 px-4 py-3
                                       text-sm text-slate-100
                                       outline-none transition
                                       focus:border-emerald-500/50
                                       focus:ring-1
                                       focus:ring-emerald-500/20">

                            <option value="custom">Custom Configuration</option>
                            <option value="small_crypt">Small Crypt</option>
                            <option value="large_castle">Large Castle</option>
                            <option value="prison_complex">Prison Complex</option>
                            <option value="temple">Ancient Temple</option>
                            <option value="sewers">Abandoned Sewers</option>
                            <option value="mines">Dwarven Mines</option>
                            <option value="stronghold">Ancient Stronghold</option>

                        </select>

                    </div>
                </div>


                {{-- ====================================================
                     MAP DIMENSIONS
                ==================================================== --}}
                <div>

                    <div class="mb-4">
                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.14em] text-blue-400">
                            Map Structure
                        </p>

                        <h3 class="mt-1 text-lg font-semibold text-slate-100">
                            Dimensions & density
                        </h3>
                    </div>


                    <div class="grid gap-4 md:grid-cols-3">

                        {{-- WIDTH --}}
                        <div>
                            <label for="width"
                                   class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Map Width
                            </label>

                            <input id="width"
                                   name="width"
                                   type="number"
                                   min="30"
                                   max="200"
                                   value="{{ old('width', 80) }}"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          focus:border-blue-500/40
                                          focus:ring-1 focus:ring-blue-500/20">

                            <p class="mt-1.5 text-xs text-slate-600">
                                Recommended: 80–120
                            </p>
                        </div>


                        {{-- HEIGHT --}}
                        <div>
                            <label for="height"
                                   class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Map Height
                            </label>

                            <input id="height"
                                   name="height"
                                   type="number"
                                   min="30"
                                   max="200"
                                   value="{{ old('height', 50) }}"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          focus:border-blue-500/40
                                          focus:ring-1 focus:ring-blue-500/20">

                            <p class="mt-1.5 text-xs text-slate-600">
                                Recommended: 50–100
                            </p>
                        </div>


                        {{-- ROOM COUNT --}}
                        <div>
                            <label for="room_count"
                                   class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Room Count
                            </label>

                            <input id="room_count"
                                   name="room_count"
                                   type="number"
                                   min="3"
                                   max="50"
                                   value="{{ old('room_count', 12) }}"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          focus:border-blue-500/40
                                          focus:ring-1 focus:ring-blue-500/20">

                            <p class="mt-1.5 text-xs text-slate-600">
                                Higher values create denser layouts.
                            </p>
                        </div>

                    </div>
                </div>


                {{-- ====================================================
                     ROOM SETTINGS
                ==================================================== --}}
                <div>

                    <div class="mb-4">
                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.14em] text-amber-400">
                            Room Generation
                        </p>

                        <h3 class="mt-1 text-lg font-semibold text-slate-100">
                            Room sizing
                        </h3>
                    </div>


                    <div class="grid gap-4 md:grid-cols-3">

                        {{-- MIN --}}
                        <div>
                            <label for="min_room_size"
                                   class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Minimum Room Size
                            </label>

                            <input id="min_room_size"
                                   name="min_room_size"
                                   type="number"
                                   min="3"
                                   max="30"
                                   value="{{ old('min_room_size', 5) }}"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          focus:border-amber-500/40
                                          focus:ring-1 focus:ring-amber-500/20">
                        </div>


                        {{-- MAX --}}
                        <div>
                            <label for="max_room_size"
                                   class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Maximum Room Size
                            </label>

                            <input id="max_room_size"
                                   name="max_room_size"
                                   type="number"
                                   min="4"
                                   max="40"
                                   value="{{ old('max_room_size', 12) }}"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          focus:border-amber-500/40
                                          focus:ring-1 focus:ring-amber-500/20">
                        </div>


                        {{-- SEED --}}
                        <div>
                            <label for="seed"
                                   class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Generation Seed
                            </label>

                            <input id="seed"
                                   name="seed"
                                   type="number"
                                   min="1"
                                   value="{{ old('seed') }}"
                                   placeholder="Random"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          placeholder:text-slate-600
                                          focus:border-amber-500/40
                                          focus:ring-1 focus:ring-amber-500/20">

                            <p class="mt-1.5 text-xs text-slate-600">
                                Same seed + settings = same layout.
                            </p>
                        </div>

                    </div>
                </div>


                {{-- ====================================================
                     STYLE
                ==================================================== --}}
                <div>

                    <div class="mb-4">
                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.14em] text-violet-400">
                            Dungeon Identity
                        </p>

                        <h3 class="mt-1 text-lg font-semibold text-slate-100">
                            Type & theme
                        </h3>
                    </div>


                    <div class="grid gap-4 md:grid-cols-2">

                        {{-- TYPE --}}
                        <div>
                            <label for="type"
                                   class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Dungeon Type
                            </label>

                            <select id="type"
                                    name="type"
                                    class="mt-2 w-full rounded-xl
                                           border border-slate-800
                                           bg-slate-950 px-4 py-3
                                           text-sm text-slate-100
                                           outline-none transition
                                           focus:border-violet-500/40
                                           focus:ring-1 focus:ring-violet-500/20">

                                <option value="crypt">Crypt</option>
                                <option value="castle">Castle</option>
                                <option value="sewer">Sewer</option>
                                <option value="temple">Temple</option>
                                <option value="ruins">Ruins</option>
                                <option value="prison">Prison</option>
                                <option value="mine">Mine</option>

                            </select>
                        </div>


                        {{-- THEME --}}
                        <div>
                            <label for="theme"
                                   class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Theme
                            </label>

                            <input id="theme"
                                   name="theme"
                                   type="text"
                                   value="{{ old('theme', 'ancient undead crypt') }}"
                                   placeholder="Ancient undead crypt"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          placeholder:text-slate-600
                                          focus:border-violet-500/40
                                          focus:ring-1 focus:ring-violet-500/20">
                        </div>

                    </div>
                </div>


                {{-- ====================================================
                     GENERATE
                ==================================================== --}}
                <div class="flex flex-col gap-4
                            border-t border-slate-800 pt-6
                            sm:flex-row sm:items-center
                            sm:justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-300">
                            Ready to generate?
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            The generated layout will open directly in the interactive editor.
                        </p>
                    </div>


                    <div class="flex flex-wrap gap-3">

                        <a href="{{ route('dungeon-new.list') }}"
                           class="inline-flex items-center justify-center
                                  rounded-xl border border-slate-700
                                  bg-slate-900 px-4 py-2.5
                                  text-sm font-medium text-slate-300
                                  transition hover:bg-slate-800">
                            Saved Dungeons
                        </a>


                        <button type="submit"
                                class="inline-flex items-center
                                       justify-center gap-2 rounded-xl
                                       bg-emerald-500 px-5 py-2.5
                                       text-sm font-semibold text-slate-950
                                       shadow-lg shadow-emerald-950/20
                                       transition hover:bg-emerald-400">

                            Generate Dungeon

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M5 12h14"/>
                                <path d="m13 6 6 6-6 6"/>
                            </svg>

                        </button>

                    </div>

                </div>

            </form>
        </section>

    </div>

    <script>

        const presets = {

            small_crypt: {
                width: 60,
                height: 40,
                room_count: 10,
                min_room_size: 5,
                max_room_size: 10,
                type: 'crypt',
                theme: 'Ancient Undead Crypt'
            },

            large_castle: {
                width: 140,
                height: 90,
                room_count: 25,
                min_room_size: 8,
                max_room_size: 20,
                type: 'castle',
                theme: 'Noble Fortress'
            },

            prison_complex: {
                width: 100,
                height: 70,
                room_count: 18,
                min_room_size: 4,
                max_room_size: 12,
                type: 'prison',
                theme: 'Underground Prison'
            },

            temple: {
                width: 90,
                height: 60,
                room_count: 15,
                min_room_size: 6,
                max_room_size: 14,
                type: 'temple',
                theme: 'Ancient Temple'
            },

            sewers: {
                width: 110,
                height: 80,
                room_count: 20,
                min_room_size: 5,
                max_room_size: 12,
                type: 'sewer',
                theme: 'Abandoned Sewers'
            },

            mines: {
                width: 130,
                height: 85,
                room_count: 22,
                min_room_size: 5,
                max_room_size: 15,
                type: 'mine',
                theme: 'Dwarven Mines'
            },

            stronghold: {
                width: 160,
                height: 100,
                room_count: 30,
                min_room_size: 8,
                max_room_size: 18,
                type: 'stronghold',
                theme: 'Ancient Stronghold'
            }

        };


        document
            .getElementById('preset')
            .addEventListener('change', event => {

                const preset = presets[event.target.value];

                if (!preset) {
                    return;
                }

                Object.entries(preset)
                    .forEach(([key, value]) => {

                        const input = document.getElementById(key);

                        if (input) {
                            input.value = value;
                        }

                    });

            });

    </script>

</x-layouts.app>
