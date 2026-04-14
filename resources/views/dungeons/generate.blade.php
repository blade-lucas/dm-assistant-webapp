<x-layouts.app title="Dungeon Generator">
    <div class="mx-auto max-w-7xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">Dungeon Generator</h1>
                    <p class="mt-1 text-sm text-slate-400">
                        Configure a dungeon layout now, then plug in AI generation when the model is ready.
                    </p>
                </div>

                <a href="{{ route('characters.index') }}"
                   class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                    Back
                </a>
            </div>
        </div>

        @if($errors->any())
            <div class="mt-4 rounded-2xl border border-red-900 bg-red-950/30 p-4 text-sm text-red-200">
                <div class="font-semibold">Fix these before generating:</div>
                <ul class="mt-2 list-disc pl-5">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6 grid gap-6">

            {{-- PARAMETERS PANEL --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

                <div class="text-sm font-semibold mb-4">Generation Parameters</div>

                <form method="POST" action="{{ route('dungeons.generate.run') }}" class="grid gap-4 md:grid-cols-4 xl:grid-cols-6">
                    @csrf

                    <div class="col-span-2">
                        <label class="text-xs text-slate-400">Dungeon Name</label>
                        <input name="name" value="{{ old('name') }}"
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Theme</label>
                        <select id="theme" name="theme" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['Crypt','Forest Ruins','Cave','Castle','Sewers','Temple','Volcanic','Ice Cavern'] as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Size</label>
                        <select name="size" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['small','medium','large','huge'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Difficulty</label>
                        <select name="difficulty" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['easy','medium','hard','deadly'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Rooms</label>
                        <input id = "room_count" type="number" name="room_count" min="3" max="50"
                               value="{{ old('room_count',10) }}"
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Encounter Density</label>
                        <select name="encounter_density" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['low','medium','high'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Treasure Density</label>
                        <select name="treasure_density" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['low','medium','high'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Tone</label>
                        <select name="tone" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['Mysterious','Heroic','Dark','Ancient','Creepy'] as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Guidance Strength</label>
                        <input id="guidance" type="range" min="0" max="5" step="0.1" value="2.5"
                            class="mt-1 w-full rounded-xl border">
                    </div>

                    <div class="flex items-end">
                        <button class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                            Generate
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid gap-6 xl:grid-cols-[2fr_1fr]">
                {{-- CENTER: MAP PREVIEW --}}
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold">Map Preview</div>
                        <form id="mapForm" method="POST" action="{{ route('dungeons.generate.map') }}">
                            @csrf
                            <div class="flex items-end">
                                <button
                                    id="generateBtn"
                                    type="submit"
                                    class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-500"
                                >
                                    Generate Map
                                </button>
                            </div>
                        </form>
                    </div>

                        <div id="placeholder" class="mt-4 flex h-[700px] items-center justify-center rounded-2xl border border-dashed border-slate-800 bg-slate-950 text-sm text-slate-500"
                        style="{{ $result ? 'display:none;' : '' }}">
                            No dungeon generated yet.
                        </div>

                        <div id="loading" class="mt-4 flex h-[700px] items-center justify-center rounded-2xl border border-dashed border-slate-800 bg-slate-950 text-sm text-slate-500 hidden">
                            Generating map, please wait...
                        </div>
                        <img
                            id="mapImage"
                            class="w-full h-[700px] object-contain border rounded shadow"
                            style="{{ $result ? '' : 'display:none;' }}"
                        />


                </div>

                {{-- RIGHT: OUTPUT SUMMARY --}}
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                    <div class="text-sm font-semibold">Dungeon Output</div>

                    @if(!$result)
                        <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 p-4 text-sm text-slate-500">
                            Generated dungeon details will appear here.
                        </div>
                    @else
                        <div class="mt-4 grid gap-4">
                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <div class="text-lg font-semibold">{{ $result['name'] }}</div>
                                <div class="mt-2 text-sm text-slate-300">
                                    {{ $result['theme'] }} • {{ ucfirst($result['size']) }} • {{ ucfirst($result['difficulty']) }}
                                </div>
                                <div class="mt-2 text-xs text-slate-500">
                                    {{ $result['room_count'] }} rooms • Encounter {{ ucfirst($result['encounter_density']) }} • Treasure {{ ucfirst($result['treasure_density']) }}
                                </div>
                            </div>

                            @if($result['description'])
                                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                    <div class="text-sm font-semibold">Description</div>
                                    <div class="mt-2 text-sm text-slate-300">
                                        {{ $result['description'] }}
                                    </div>
                                </div>
                            @endif

                            @if(!empty($result['npcs']))
                                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                    <div class="text-sm font-semibold">Generated NPCs</div>
                                    <div class="mt-3 grid gap-2">
                                        @foreach($result['npcs'] as $npc)
                                            <div class="rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                                                <div class="font-semibold">{{ $npc['name'] }}</div>
                                                <div class="text-slate-500">{{ $npc['role'] }}</div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <div class="text-sm font-semibold">Rooms</div>
                                <div class="mt-3 grid gap-2 max-h-[420px] overflow-auto">
                                    @foreach($result['rooms'] as $room)
                                        <div class="rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                                            <div class="font-semibold">{{ $room['name'] }} — {{ $room['type'] }}</div>
                                            <div class="mt-1 text-slate-500">{{ $room['summary'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </div>

        {{-- FEEDBACK PANEL --}}
        <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold">Feedback</h2>
                    <p class="mt-1 text-sm text-slate-400">
                        Let users share what worked, what didn’t, and what they’d like improved in future dungeon generations.
                    </p>
                </div>
            </div>

            <form method="POST" action="#" class="mt-6 grid gap-4">
                @csrf

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs text-slate-400">Feedback Type</label>
                        <select name="feedback_type"
                                class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            <option value="general">General Feedback</option>
                            <option value="bug">Bug Report</option>
                            <option value="balance">Balance Concern</option>
                            <option value="feature">Feature Request</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Dungeon Name</label>
                        <input name="feedback_dungeon_name"
                               value="{{ $result['name'] ?? old('feedback_dungeon_name') }}"
                               placeholder="Auto-filled if generated"
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    </div>
                </div>

                <div>
                    <label class="text-xs text-slate-400">Comments</label>
                    <textarea name="feedback_comments"
                              rows="5"
                              placeholder="What did you think of this generated dungeon?"
                              class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm"></textarea>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-xs text-slate-400">Map Quality</label>
                        <select name="map_rating"
                                class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            <option value="">Select rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Weak</option>
                            <option value="3">3 - Okay</option>
                            <option value="4">4 - Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Layout Quality</label>
                        <select name="layout_rating"
                                class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            <option value="">Select rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Weak</option>
                            <option value="3">3 - Okay</option>
                            <option value="4">4 - Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Overall Experience</label>
                        <select name="overall_rating"
                                class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            <option value="">Select rating</option>
                            <option value="1">1 - Poor</option>
                            <option value="2">2 - Weak</option>
                            <option value="3">3 - Okay</option>
                            <option value="4">4 - Good</option>
                            <option value="5">5 - Excellent</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                        Submit Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
