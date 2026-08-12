<x-layouts.app title="Save Details">

    <div class="mx-auto max-w-5xl space-y-8">

        @php
            $accent = match($type) {
                'characters' => 'blue',
                'encounters' => 'violet',
                'maps' => 'indigo',
                'feedback' => 'amber',
                default => 'slate',
            };
        @endphp


        {{-- ============================================================
             HEADER
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-slate-800
                        bg-gradient-to-br from-slate-900 to-slate-950
                        p-7 md:p-8">

            <div class="relative flex flex-col gap-5
                        sm:flex-row sm:items-start
                        sm:justify-between">

                <div>

                    <div class="mb-3 inline-flex rounded-full
                                border border-slate-700
                                bg-slate-900 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-slate-400">
                        Saved {{ rtrim(ucfirst($type), 's') }}
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50">
                        {{ ucfirst($type) }} Details
                    </h1>

                    <p class="mt-2 text-sm text-slate-400">
                        View saved {{ rtrim($type, 's') }} information.
                    </p>

                </div>


                <a href="{{ route('saves.index', ['type' => $type]) }}"
                   class="inline-flex items-center gap-2
                          rounded-xl border border-slate-700
                          bg-slate-900/60 px-4 py-2
                          text-sm text-slate-300 transition
                          hover:bg-slate-800">

                    ← Back to Saves
                </a>

            </div>
        </section>


        {{-- ============================================================
             CHARACTER DETAILS
        ============================================================ --}}
        @if($type === 'characters')

            <section class="overflow-hidden rounded-3xl
                            border border-blue-500/20
                            bg-slate-950">

                <div class="border-b border-slate-800
                            bg-gradient-to-r from-blue-950/20
                            to-slate-950 p-6">

                    <div class="flex flex-col gap-4
                                sm:flex-row sm:items-start
                                sm:justify-between">

                        <div>

                            <div class="mb-2 flex flex-wrap gap-2">

                                <span class="rounded-full
                                             border border-blue-500/20
                                             bg-blue-500/10
                                             px-2.5 py-1
                                             text-[10px] font-semibold
                                             uppercase tracking-wider
                                             text-blue-300">
                                    {{ strtoupper($item->role) }}
                                </span>

                                <span class="rounded-full
                                             border border-amber-500/20
                                             bg-amber-500/[0.06]
                                             px-2.5 py-1
                                             text-[10px] text-amber-300">
                                    Level {{ $item->level ?? 1 }}
                                </span>

                            </div>

                            <h2 class="text-3xl font-bold text-slate-50">
                                {{ $item->name }}
                            </h2>

                            <p class="mt-2 text-sm text-slate-400">
                                @if($item->race)
                                    {{ $item->race }}
                                @endif

                                @if($item->class)
                                    • {{ $item->class }}
                                @endif
                            </p>

                        </div>

                    </div>
                </div>


                <div class="grid gap-4 p-6
                            sm:grid-cols-2 lg:grid-cols-4">

                    <div class="rounded-xl border border-slate-800
                                bg-slate-900/30 p-4">
                        <div class="text-[10px] uppercase
                                    tracking-wider text-slate-500">
                            Alignment
                        </div>
                        <div class="mt-1 font-semibold text-slate-200">
                            {{ $item->alignment ?? '—' }}
                        </div>
                    </div>

                    <div class="rounded-xl border border-blue-500/20
                                bg-blue-500/[0.05] p-4">
                        <div class="text-[10px] uppercase
                                    tracking-wider text-blue-400">
                            Armor Class
                        </div>
                        <div class="mt-1 text-xl font-bold text-blue-200">
                            {{ $item->ac ?? '—' }}
                        </div>
                    </div>

                    <div class="rounded-xl border border-violet-500/20
                                bg-violet-500/[0.05] p-4">
                        <div class="text-[10px] uppercase
                                    tracking-wider text-violet-400">
                            Initiative
                        </div>
                        <div class="mt-1 text-xl font-bold text-violet-200">
                            {{ $item->initiative ?? '—' }}
                        </div>
                    </div>

                    <div class="rounded-xl border border-emerald-500/20
                                bg-emerald-500/[0.05] p-4">
                        <div class="text-[10px] uppercase
                                    tracking-wider text-emerald-400">
                            Speed
                        </div>
                        <div class="mt-1 text-xl font-bold text-emerald-200">
                            {{ $item->speed ?? '—' }}
                        </div>
                    </div>

                </div>
            </section>


            {{-- ============================================================
                 ENCOUNTER DETAILS
            ============================================================ --}}
        @elseif($type === 'encounters')

            <section class="overflow-hidden rounded-3xl
                            border border-violet-500/20
                            bg-slate-950">

                <div class="border-b border-slate-800
                            bg-gradient-to-r from-violet-950/20
                            to-slate-950 p-6">

                    <h2 class="text-2xl font-semibold text-slate-100">
                        {{ $item->name }}
                    </h2>

                    <p class="mt-2 text-sm text-slate-400">
                        Encounter table with
                        {{ count($item->payload['rows'] ?? []) }}
                        rows
                    </p>

                </div>


                <div class="grid gap-3 p-5">

                    @foreach(($item->payload['rows'] ?? []) as $row)

                        <div class="flex gap-4 rounded-2xl
                                    border border-slate-800
                                    bg-slate-900/20 p-4">

                            <div class="flex h-10 min-w-10
                                        items-center justify-center
                                        rounded-lg
                                        border border-amber-500/20
                                        bg-amber-500/[0.06]
                                        font-mono font-bold
                                        text-amber-300">
                                {{ $row['roll'] ?? '?' }}
                            </div>

                            <div class="text-sm leading-6 text-slate-300">
                                {{ $row['encounter']['encounterDetails'] ?? '—' }}
                            </div>

                        </div>

                    @endforeach

                </div>
            </section>


            {{-- ============================================================
                 MAP DETAILS
            ============================================================ --}}
        @elseif($type === 'maps')

            <section class="overflow-hidden rounded-3xl
                            border border-indigo-500/20
                            bg-slate-950">

                <div class="border-b border-slate-800
                            bg-gradient-to-r from-indigo-950/20
                            to-slate-950 p-6">

                    <div class="flex flex-col gap-4
                                sm:flex-row sm:items-start
                                sm:justify-between">

                        <div>

                            <div class="mb-2 inline-flex
                                        rounded-full
                                        border border-indigo-500/20
                                        bg-indigo-500/10
                                        px-2.5 py-1
                                        text-[10px] font-semibold
                                        uppercase tracking-wider
                                        text-indigo-300">
                                AI Generated Map
                            </div>

                            <h2 class="text-3xl font-bold text-slate-50">
                                {{ $item->name ?: 'Untitled Map' }}
                            </h2>

                            <p class="mt-2 text-sm text-slate-400">
                                {{ $item->theme ?: 'Unknown Theme' }}

                                @if($item->size)
                                    • {{ ucfirst($item->size) }}
                                @endif

                                @if($item->difficulty)
                                    • {{ ucfirst($item->difficulty) }}
                                @endif
                            </p>

                        </div>

                    </div>
                </div>


                {{-- MAP IMAGE --}}
                <div class="p-5">

                    <div class="overflow-hidden rounded-2xl
                                border border-slate-800
                                bg-slate-900">

                        @if($item->image_path)

                            <img src="{{ asset('storage/' . $item->image_path) }}"
                                 alt="{{ $item->name ?: 'Saved map' }}"
                                 class="w-full object-contain">

                        @else

                            <div class="flex h-80 items-center
                                        justify-center
                                        text-sm text-slate-500">
                                No map image available.
                            </div>

                        @endif

                    </div>
                </div>
            </section>


            @php
                $story = \App\Models\MapStory::where('map_id', $item->id)
                    ->latest()
                    ->first();
            @endphp


            @if($story)

                <section class="rounded-3xl border
                                border-violet-500/20
                                bg-gradient-to-br
                                from-violet-950/10
                                to-slate-950 p-6">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] text-violet-400">
                        Generated Adventure
                    </p>

                    <h2 class="mt-1 text-xl font-semibold text-slate-100">
                        Story
                    </h2>

                    <div class="mt-4 whitespace-pre-line
                                text-sm leading-7 text-slate-300">
                        {{ $story->story_text }}
                    </div>

                </section>

            @endif


            {{-- MAP METADATA --}}
            <section class="rounded-3xl border
                            border-slate-800 bg-slate-950 p-6">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-indigo-400">
                    Generation Metadata
                </p>

                <div class="mt-4 grid gap-3
                            sm:grid-cols-2 lg:grid-cols-3">

                    @foreach([
                        'Name' => $item->name ?: 'Untitled Map',
                        'Theme' => $item->theme ?? '—',
                        'Size' => $item->size ? ucfirst($item->size) : '—',
                        'Difficulty' => $item->difficulty ? ucfirst($item->difficulty) : '—',
                        'Room Count' => $item->room_count ?? '—',
                        'Encounter Density' => $item->encounter_density ? ucfirst($item->encounter_density) : '—',
                        'Treasure Density' => $item->treasure_density ? ucfirst($item->treasure_density) : '—',
                        'Tone' => $item->tone ?? '—',
                        'Guidance Strength' => $item->guidance_strength ?? '—',
                        'Saved' => $item->created_at->format('M j, Y H:i'),
                    ] as $label => $value)

                        <div class="rounded-xl border
                                    border-slate-800
                                    bg-slate-900/20 p-4">

                            <div class="text-[10px] font-semibold
                                        uppercase tracking-wider
                                        text-slate-500">
                                {{ $label }}
                            </div>

                            <div class="mt-1 text-sm font-medium
                                        text-slate-200">
                                {{ $value }}
                            </div>

                        </div>

                    @endforeach

                </div>
            </section>


            @php
                $feedbackItems = \App\Models\MapFeedback::where('map_id', $item->id)
                    ->latest()
                    ->get();
            @endphp


            @if($feedbackItems->isNotEmpty())

                <section class="rounded-3xl border
                                border-amber-500/20
                                bg-slate-950 p-6">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] text-amber-400">
                        Evaluation
                    </p>

                    <h2 class="mt-1 text-xl font-semibold text-slate-100">
                        Feedback
                    </h2>


                    <div class="mt-4 grid gap-3">

                        @foreach($feedbackItems as $feedback)

                            <div class="rounded-2xl border
                                        border-slate-800
                                        bg-slate-900/20 p-4">

                                <div class="flex items-center
                                            justify-between gap-3">

                                    <span class="rounded-full
                                                 border border-amber-500/20
                                                 bg-amber-500/[0.06]
                                                 px-2.5 py-1
                                                 text-[10px] font-semibold
                                                 uppercase tracking-wider
                                                 text-amber-300">
                                        {{ ucfirst($feedback->feedback_type) }}
                                    </span>

                                    <div class="text-xs text-slate-600">
                                        {{ $feedback->created_at->format('M j, Y H:i') }}
                                    </div>

                                </div>


                                <div class="mt-3 text-xs text-slate-400">
                                    Map:
                                    <span class="text-slate-200">
                                        {{ $feedback->map_rating ?? '—' }}/5
                                    </span>

                                    • Layout:
                                    <span class="text-slate-200">
                                        {{ $feedback->layout_rating ?? '—' }}/5
                                    </span>

                                    • Overall:
                                    <span class="text-slate-200">
                                        {{ $feedback->overall_rating ?? '—' }}/5
                                    </span>
                                </div>


                                @if($feedback->comments)

                                    <div class="mt-3 whitespace-pre-line
                                                text-sm leading-6
                                                text-slate-300">
                                        {{ $feedback->comments }}
                                    </div>

                                @endif

                            </div>

                        @endforeach

                    </div>
                </section>

            @endif


            {{-- ============================================================
                 FEEDBACK DETAILS
            ============================================================ --}}
        @elseif($type === 'feedback')

            <section class="overflow-hidden rounded-3xl
                            border border-amber-500/20
                            bg-slate-950">

                <div class="border-b border-slate-800
                            bg-gradient-to-r from-amber-950/20
                            to-slate-950 p-6">

                    <span class="rounded-full border
                                 border-amber-500/20
                                 bg-amber-500/[0.06]
                                 px-2.5 py-1
                                 text-[10px] font-semibold
                                 uppercase tracking-wider
                                 text-amber-300">
                        {{ ucfirst($item->feedback_type) }} Feedback
                    </span>

                    <h2 class="mt-3 text-2xl font-semibold text-slate-100">
                        {{ $item->dungeon_name ?: 'Unnamed Dungeon' }}
                    </h2>

                    <p class="mt-2 text-sm text-slate-400">
                        {{ $item->theme ?: 'Unknown Theme' }}

                        @if($item->tone)
                            • {{ $item->tone }}
                        @endif
                    </p>

                </div>


                <div class="grid gap-4 p-6 md:grid-cols-3">

                    <div class="rounded-xl border
                                border-indigo-500/20
                                bg-indigo-500/[0.05]
                                p-4 text-center">

                        <div class="text-[10px] uppercase
                                    tracking-wider text-indigo-400">
                            Map
                        </div>

                        <div class="mt-1 text-2xl font-bold
                                    text-indigo-200">
                            {{ $item->map_rating ?? '—' }}/5
                        </div>

                    </div>

                    <div class="rounded-xl border
                                border-violet-500/20
                                bg-violet-500/[0.05]
                                p-4 text-center">

                        <div class="text-[10px] uppercase
                                    tracking-wider text-violet-400">
                            Layout
                        </div>

                        <div class="mt-1 text-2xl font-bold
                                    text-violet-200">
                            {{ $item->layout_rating ?? '—' }}/5
                        </div>

                    </div>

                    <div class="rounded-xl border
                                border-amber-500/20
                                bg-amber-500/[0.05]
                                p-4 text-center">

                        <div class="text-[10px] uppercase
                                    tracking-wider text-amber-400">
                            Overall
                        </div>

                        <div class="mt-1 text-2xl font-bold
                                    text-amber-200">
                            {{ $item->overall_rating ?? '—' }}/5
                        </div>

                    </div>

                </div>


                @if($item->comments)

                    <div class="border-t border-slate-800 p-6">

                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.14em] text-slate-500">
                            Comments
                        </p>

                        <div class="mt-3 whitespace-pre-line
                                    text-sm leading-7 text-slate-300">
                            {{ $item->comments }}
                        </div>

                    </div>

                @endif


                @if($item->map_id)

                    <div class="border-t border-slate-800 p-6">

                        <a href="{{ route('saves.show', [
                                'type' => 'maps',
                                'id' => $item->map_id
                            ]) }}"
                           class="inline-flex rounded-xl
                                  border border-indigo-500/20
                                  bg-indigo-500/10
                                  px-4 py-2.5
                                  text-sm font-medium
                                  text-indigo-300 transition
                                  hover:bg-indigo-500/20">

                            View Related Map →

                        </a>

                    </div>

                @endif

            </section>

        @endif

    </div>

</x-layouts.app>
