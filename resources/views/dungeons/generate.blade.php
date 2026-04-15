<x-layouts.app title="Dungeon Generator">
    @if(session('status'))
        <div class="mt-4 rounded-2xl border border-emerald-900 bg-emerald-950/30 p-4 text-sm text-emerald-200">
            {{ session('status') }}
        </div>
    @endif
    <div class="mx-auto max-w-7xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">Dungeon Generator</h1>
                    <p class="mt-1 text-sm text-slate-400">
                        Generate a dungeon map and AI story together.
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
                <div class="mb-4 text-sm font-semibold">Generation Parameters</div>

                <form id="dungeonParamsForm" class="grid gap-4 md:grid-cols-4 xl:grid-cols-6">
                    @csrf

                    <div class="col-span-2">
                        <label class="text-xs text-slate-400">Dungeon Name</label>
                        <input id="name" name="name" value="{{ old('name') }}"
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Theme</label>
                        <select id="theme" name="theme" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['Crypt','Cave','Dungeon'] as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Size</label>
                        <select disabled id="size" name="size" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['small','medium','large','huge'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Difficulty</label>
                        <select disabled id="difficulty" name="difficulty" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['easy','medium','hard','deadly'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Rooms</label>
                        <input id="room_count" type="number" name="room_count" min="3" max="50"
                               value="{{ old('room_count', 10) }}"
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Encounter Density</label>
                        <select disabled id="encounter_density" name="encounter_density" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['low','medium','high'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Treasure Density</label>
                        <select disabled id="treasure_density" name="treasure_density" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['low','medium','high'] as $opt)
                                <option value="{{ $opt }}">{{ ucfirst($opt) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Tone</label>
                        <select id="tone" name="tone" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                            @foreach(['Mysterious','Heroic','Dark','Ancient','Creepy'] as $opt)
                                <option value="{{ $opt }}">{{ $opt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Guidance Strength</label>
                        <input id="guidance" name="guidance" type="range" min="0" max="5" step="0.1" value="2.5"
                               class="mt-1 w-full rounded-xl border">
                    </div>

                    <div class="flex items-end">
                        <button id="generateMapBtn" type="button"
                                class="w-full rounded-xl bg-indigo-600 px-4 py-3 text-sm font-semibold text-white hover:bg-indigo-500">
                            Generate
                        </button>
                    </div>
                </form>
            </div>

            <div class="grid gap-6 xl:grid-cols-[2fr_1fr]">
                {{-- MAP PREVIEW --}}
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                    <div class="flex items-center justify-between">
                        <div class="text-sm font-semibold">Map Preview</div>
                    </div>

                    <div id="placeholder"
                         class="mt-4 flex h-[700px] items-center justify-center rounded-2xl border border-dashed border-slate-800 bg-slate-950 text-sm text-slate-500">
                        No dungeon generated yet.
                    </div>

                    <div id="loading"
                         class="mt-4 hidden h-[700px] items-center justify-center rounded-2xl border border-dashed border-slate-800 bg-slate-950 text-sm text-slate-500">
                        Generating map, please wait...
                    </div>

                    <img id="mapImage"
                         class="mt-4 hidden h-[700px] w-full rounded-2xl border object-contain shadow" />

                    <div id="saveMapContainer" class="mt-4 hidden">
                        @auth
                            <form method="POST" action="{{ route('maps.store') }}" class="flex items-center gap-3">
                                @csrf

                                <input type="hidden" name="name" id="save_name">
                                <input type="hidden" name="theme" id="save_theme">
                                <input type="hidden" name="size" id="save_size">
                                <input type="hidden" name="difficulty" id="save_difficulty">
                                <input type="hidden" name="room_count" id="save_room_count">
                                <input type="hidden" name="encounter_density" id="save_encounter_density">
                                <input type="hidden" name="treasure_density" id="save_treasure_density">
                                <input type="hidden" name="tone" id="save_tone">
                                <input type="hidden" name="guidance_strength" id="save_guidance_strength">
                                <input type="hidden" name="image_base64" id="save_image_base64">
                                <input type="hidden" name="story_text" id="save_story_text">
                                <input type="hidden" name="story_meta" id="save_story_meta">

                                <button type="submit"
                                        class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                    Save Map
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                Log in to save this map
                            </a>
                        @endauth
                    </div>
                </div>

                {{-- RIGHT: OUTPUT SUMMARY --}}
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                    <div class="text-sm font-semibold">Dungeon Output</div>

                    <div class="mt-4 h-[700px] rounded-2xl border border-slate-800 bg-slate-950 p-4">
                        <div id="storyPlaceholder"
                             class="flex h-full items-center justify-center text-sm text-slate-500">
                            Generated dungeon story will appear here.
                        </div>

                        <div id="storyLoading"
                             class="hidden h-full items-center justify-center text-sm text-slate-500">
                            Generating story, please wait...
                        </div>

                        <div id="storyOutput"
                             class="hidden h-full overflow-y-auto whitespace-pre-line pr-2 text-sm leading-6 text-slate-200 scroll-smooth">
                        </div>
                    </div>
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

            <form method="POST" action="{{ route('feedback.maps.store') }}" class="mt-6 grid gap-4">
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
                    <input type="hidden" name="map_id" id="feedback_map_id">
                    <input type="hidden" name="theme" id="feedback_theme">
                    <input type="hidden" name="tone" id="feedback_tone">
                    <div>
                        <label class="text-xs text-slate-400">Dungeon Name</label>
                        <input name="dungeon_name" id="feedback_dungeon_name"
                               placeholder="Auto-filled if generated"
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    </div>
                </div>

                <div>
                    <label class="text-xs text-slate-400">Comments</label>
                    <textarea name="comments"
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
            formData.append('guidance', document.getElementById('guidance').value);
            formData.append('tone', document.getElementById('tone').value);

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
                    },
                    body: formData,
                });

                const data = await response.json();

                if (!response.ok || !data.image) {
                    throw new Error(data.error || 'Map generation failed.');
                }

                const imageSrc = data.image.startsWith('data:image')
                    ? data.image
                    : `data:image/png;base64,${data.image}`;

                mapImage.src = imageSrc;
                mapImage.classList.remove('hidden');
                saveMapContainer.classList.remove('hidden');

                document.getElementById('save_name').value = document.getElementById('name').value;
                document.getElementById('save_theme').value = document.getElementById('theme').value;
                document.getElementById('save_size').value = document.getElementById('size').value;
                document.getElementById('save_difficulty').value = document.getElementById('difficulty').value;
                document.getElementById('save_room_count').value = document.getElementById('room_count').value;
                document.getElementById('save_encounter_density').value = document.getElementById('encounter_density').value;
                document.getElementById('save_treasure_density').value = document.getElementById('treasure_density').value;
                document.getElementById('save_tone').value = document.getElementById('tone').value;
                document.getElementById('save_guidance_strength').value = document.getElementById('guidance').value;
                document.getElementById('save_image_base64').value = imageSrc;
                document.getElementById('save_story_text').value = data.story_text || '';
                document.getElementById('save_story_meta').value = data.story_meta ? JSON.stringify(data.story_meta) : '';
                document.getElementById('feedback_dungeon_name').value = document.getElementById('name').value || '';
                document.getElementById('feedback_theme').value = document.getElementById('theme').value || '';
                document.getElementById('feedback_tone').value = document.getElementById('tone').value || '';

                if (data.story_text) {
                    storyOutput.textContent = data.story_text;
                    storyOutput.classList.remove('hidden');
                } else {
                    storyPlaceholder.textContent = 'Map generated, but no story was returned.';
                    storyPlaceholder.classList.remove('hidden');
                }
            } catch (error) {
                alert(error.message || 'Map generation failed.');
                placeholder.classList.remove('hidden');
                storyPlaceholder.textContent = 'Story generation failed.';
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
