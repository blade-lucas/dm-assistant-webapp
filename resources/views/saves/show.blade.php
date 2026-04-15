<x-layouts.app title="Save Details">
    <div class="mx-auto max-w-5xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight capitalize">{{ $type }} Details</h1>
                    <p class="mt-1 text-sm text-slate-400">
                        View saved {{ rtrim($type, 's') }} information.
                    </p>
                </div>

                <a href="{{ route('saves.index', ['type' => $type]) }}"
                   class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                    Back
                </a>
            </div>

            <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950 p-5">
                @if($type === 'characters')
                    <div class="text-xl font-semibold">{{ $item->name }}</div>
                    <div class="mt-2 text-sm text-slate-400">
                        {{ strtoupper($item->role) }}
                        @if($item->race) • {{ $item->race }} @endif
                        @if($item->class) • {{ $item->class }} @endif
                        • Level {{ $item->level ?? 1 }}
                    </div>

                    <div class="mt-4 grid gap-2 text-sm text-slate-300">
                        <div>Alignment: {{ $item->alignment ?? '—' }}</div>
                        <div>AC: {{ $item->ac ?? '—' }}</div>
                        <div>Initiative: {{ $item->initiative ?? '—' }}</div>
                        <div>Speed: {{ $item->speed ?? '—' }}</div>
                    </div>

                @elseif($type === 'encounters')
                    <div class="text-xl font-semibold">{{ $item->name }}</div>
                    <div class="mt-2 text-sm text-slate-400">
                        Encounter table with {{ count($item->payload['rows'] ?? []) }} rows
                    </div>

                    <div class="mt-4 grid gap-2">
                        @foreach(($item->payload['rows'] ?? []) as $row)
                            <div class="rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                                <span class="font-semibold">{{ $row['roll'] ?? '?' }}</span>
                                —
                                {{ $row['encounter']['encounterDetails'] ?? '—' }}
                            </div>
                        @endforeach
                    </div>

                @elseif($type === 'maps')
                    <div class="text-xl font-semibold">{{ $item->name ?: 'Untitled Map' }}</div>
                    <div class="mt-2 text-sm text-slate-400">
                        {{ $item->theme ?: 'Unknown Theme' }}
                        @if($item->size) • {{ ucfirst($item->size) }} @endif
                        @if($item->difficulty) • {{ ucfirst($item->difficulty) }} @endif
                    </div>

                    <div class="mt-4 overflow-hidden rounded-2xl border border-slate-800 bg-slate-900">
                        @if($item->image_path)
                            <img
                                src="{{ asset('storage/' . $item->image_path) }}"
                                alt="{{ $item->name ?: 'Saved map' }}"
                                class="w-full object-contain"
                            >
                        @else
                            <div class="flex h-80 items-center justify-center text-sm text-slate-500">
                                No map image available.
                            </div>
                        @endif
                    </div>
                    @php
                        $story = \App\Models\MapStory::where('map_id', $item->id)->latest()->first();
                    @endphp

                    @if($story)
                        <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950 p-5">
                            <h2 class="text-lg font-semibold">Generated Story</h2>

                            <div class="mt-3 whitespace-pre-line text-sm text-slate-300">
                                {{ $story->story_text }}
                            </div>
                        </div>
                    @endif

                    <div class="mt-4 grid gap-2 text-sm text-slate-300 md:grid-cols-2">
                        <div>Name: {{ $item->name ?: 'Untitled Map' }}</div>
                        <div>Theme: {{ $item->theme ?? '—' }}</div>
                        <div>Size: {{ $item->size ? ucfirst($item->size) : '—' }}</div>
                        <div>Difficulty: {{ $item->difficulty ? ucfirst($item->difficulty) : '—' }}</div>
                        <div>Room Count: {{ $item->room_count ?? '—' }}</div>
                        <div>Encounter Density: {{ $item->encounter_density ? ucfirst($item->encounter_density) : '—' }}</div>
                        <div>Treasure Density: {{ $item->treasure_density ? ucfirst($item->treasure_density) : '—' }}</div>
                        <div>Tone: {{ $item->tone ?? '—' }}</div>
                        <div>Guidance Strength: {{ $item->guidance_strength ?? '—' }}</div>
                        <div>Saved: {{ $item->created_at->format('Y-m-d H:i') }}</div>
                    </div>

                    @php
                        $feedbackItems = \App\Models\MapFeedback::where('map_id', $item->id)->latest()->get();
                    @endphp

                    @if($feedbackItems->isNotEmpty())
                        <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950 p-5">
                            <h2 class="text-lg font-semibold">Feedback</h2>

                            <div class="mt-4 grid gap-3">
                                @foreach($feedbackItems as $feedback)
                                    <div class="rounded-xl border border-slate-800 bg-slate-900 p-4">
                                        <div class="flex items-center justify-between gap-3">
                                            <div class="text-sm font-medium text-slate-200">
                                                {{ ucfirst($feedback->feedback_type) }}
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                {{ $feedback->created_at->format('Y-m-d H:i') }}
                                            </div>
                                        </div>

                                        <div class="mt-2 text-xs text-slate-400">
                                            Map: {{ $feedback->map_rating ?? '—' }}/5
                                            • Layout: {{ $feedback->layout_rating ?? '—' }}/5
                                            • Overall: {{ $feedback->overall_rating ?? '—' }}/5
                                        </div>

                                        @if($feedback->comments)
                                            <div class="mt-3 whitespace-pre-line text-sm text-slate-300">
                                                {{ $feedback->comments }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
