<x-layouts.app title="Saves">

    <div class="mx-auto max-w-6xl space-y-8">

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
                        bg-indigo-500/[0.06] blur-3xl">
            </div>

            <div class="relative">

                <div class="mb-4 inline-flex items-center gap-2
                            rounded-full border border-indigo-500/20
                            bg-indigo-500/10 px-3 py-1
                            text-xs font-semibold uppercase
                            tracking-[0.14em] text-indigo-300">

                    Saved Content
                </div>

                <h1 class="text-3xl font-bold tracking-tight
                           text-slate-50 md:text-4xl">
                    Saves Library
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                    Browse and reopen your saved characters, encounter tables,
                    maps, generated stories, and feedback.
                </p>

            </div>
        </section>


        {{-- ============================================================
             LIBRARY
        ============================================================ --}}
        <div class="grid gap-6 md:grid-cols-[240px_minmax(0,1fr)]">

            {{-- ========================================================
                 SIDEBAR
            ======================================================== --}}
            <aside class="h-fit overflow-hidden rounded-3xl
                          border border-slate-800 bg-slate-950
                          md:sticky md:top-24">

                <div class="border-b border-slate-800 px-4 py-4">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.14em] text-slate-500">
                        Save Types
                    </p>

                    <h2 class="mt-1 font-semibold text-slate-100">
                        Library Sections
                    </h2>

                </div>


                <nav class="grid gap-1 p-2 text-sm">

                    {{-- CHARACTERS --}}
                    <a href="{{ route('saves.index', ['type' => 'characters']) }}"
                       class="flex items-center gap-3 rounded-xl
                              px-3 py-3 transition
                              {{ $type === 'characters'
                                  ? 'border border-blue-500/20 bg-blue-500/10 text-blue-300'
                                  : 'border border-transparent text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">

                        <div class="flex h-8 w-8 items-center justify-center
                                    rounded-lg bg-blue-500/10 text-blue-300">
                            👤
                        </div>

                        <span class="font-medium">
                            Characters
                        </span>

                    </a>


                    {{-- ENCOUNTERS --}}
                    <a href="{{ route('saves.index', ['type' => 'encounters']) }}"
                       class="flex items-center gap-3 rounded-xl
                              px-3 py-3 transition
                              {{ $type === 'encounters'
                                  ? 'border border-violet-500/20 bg-violet-500/10 text-violet-300'
                                  : 'border border-transparent text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">

                        <div class="flex h-8 w-8 items-center justify-center
                                    rounded-lg bg-violet-500/10
                                    text-violet-300">
                            ⚔
                        </div>

                        <span class="font-medium">
                            Encounters
                        </span>

                    </a>


                    {{-- MAPS --}}
                    <a href="{{ route('saves.index', ['type' => 'maps']) }}"
                       class="flex items-center gap-3 rounded-xl
                              px-3 py-3 transition
                              {{ $type === 'maps'
                                  ? 'border border-indigo-500/20 bg-indigo-500/10 text-indigo-300'
                                  : 'border border-transparent text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">

                        <div class="flex h-8 w-8 items-center justify-center
                                    rounded-lg bg-indigo-500/10
                                    text-indigo-300">
                            🗺
                        </div>

                        <span class="font-medium">
                            Maps
                        </span>

                    </a>


                    {{-- FEEDBACK --}}
                    <a href="{{ route('saves.index', ['type' => 'feedback']) }}"
                       class="flex items-center gap-3 rounded-xl
                              px-3 py-3 transition
                              {{ $type === 'feedback'
                                  ? 'border border-amber-500/20 bg-amber-500/10 text-amber-300'
                                  : 'border border-transparent text-slate-400 hover:bg-slate-900 hover:text-slate-200' }}">

                        <div class="flex h-8 w-8 items-center justify-center
                                    rounded-lg bg-amber-500/10
                                    text-amber-300">
                            💬
                        </div>

                        <span class="font-medium">
                            Feedback
                        </span>

                    </a>

                </nav>
            </aside>


            {{-- ========================================================
                 CONTENT
            ======================================================== --}}
            <section class="overflow-hidden rounded-3xl
                            border border-slate-800 bg-slate-950">

                <div class="border-b border-slate-800 px-6 py-5">

                    @php
                        $sectionAccent = match($type) {
                            'characters' => 'text-blue-400',
                            'encounters' => 'text-violet-400',
                            'maps' => 'text-indigo-400',
                            'feedback' => 'text-amber-400',
                            default => 'text-slate-400',
                        };
                    @endphp

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] {{ $sectionAccent }}">
                        {{ ucfirst($type) }}
                    </p>

                    <h2 class="mt-1 text-2xl font-semibold
                               tracking-tight text-slate-100">
                        Saved {{ ucfirst($type) }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Browse your saved {{ $type }}.
                    </p>

                </div>


                <div class="grid gap-4 p-5">

                    @forelse($items as $item)

                        {{-- ====================================================
                             CHARACTERS
                        ==================================================== --}}
                        @if($type === 'characters')

                            <a href="{{ route('saves.show', [
                                    'type' => $type,
                                    'id' => $item->id
                                ]) }}"
                               class="group rounded-2xl border
                                      border-slate-800 bg-slate-950 p-5
                                      transition hover:border-blue-500/30
                                      hover:bg-slate-900/40">

                                <div class="flex items-start justify-between gap-4">

                                    <div class="flex min-w-0 gap-4">

                                        <div class="flex h-11 w-11 shrink-0
                                                    items-center justify-center
                                                    rounded-xl
                                                    border border-blue-500/20
                                                    bg-blue-500/10
                                                    text-blue-300">
                                            👤
                                        </div>

                                        <div class="min-w-0">

                                            <h3 class="truncate text-lg
                                                       font-semibold text-slate-100
                                                       group-hover:text-blue-200">
                                                {{ $item->name }}
                                            </h3>

                                            <div class="mt-2 flex flex-wrap gap-2">

                                                <span class="rounded-full
                                                             border border-blue-500/20
                                                             bg-blue-500/[0.06]
                                                             px-2.5 py-1
                                                             text-[10px] font-semibold
                                                             uppercase tracking-wider
                                                             text-blue-300">
                                                    {{ strtoupper($item->role) }}
                                                </span>

                                                @if($item->race)
                                                    <span class="rounded-full
                                                                 border border-slate-700
                                                                 bg-slate-900
                                                                 px-2.5 py-1
                                                                 text-[10px] text-slate-400">
                                                        {{ $item->race }}
                                                    </span>
                                                @endif

                                                @if($item->class)
                                                    <span class="rounded-full
                                                                 border border-slate-700
                                                                 bg-slate-900
                                                                 px-2.5 py-1
                                                                 text-[10px] text-slate-400">
                                                        {{ $item->class }}
                                                    </span>
                                                @endif

                                                <span class="rounded-full
                                                             border border-amber-500/20
                                                             bg-amber-500/[0.06]
                                                             px-2.5 py-1
                                                             text-[10px] text-amber-300">
                                                    Level {{ $item->level ?? 1 }}
                                                </span>

                                            </div>

                                        </div>

                                    </div>

                                    <span class="text-slate-600
                                                 transition
                                                 group-hover:translate-x-1
                                                 group-hover:text-blue-300">
                                        →
                                    </span>

                                </div>


                                <div class="mt-4 border-t
                                            border-slate-800/70 pt-3
                                            text-xs text-slate-600">
                                    Updated {{ $item->updated_at->diffForHumans() }}
                                </div>

                            </a>


                            {{-- ====================================================
                                 ENCOUNTERS
                            ==================================================== --}}
                        @elseif($type === 'encounters')

                            @php
                                $mode = strtolower(
                                    $item->payload['params']['mode']
                                    ?? $item->payload['params']['source']
                                    ?? 'manual'
                                );

                                $dice = $item->payload['params']['dice'] ?? null;
                            @endphp

                            <a href="{{ route('saves.show', [
                                    'type' => $type,
                                    'id' => $item->id
                                ]) }}"
                               class="group rounded-2xl border
                                      border-slate-800 bg-slate-950 p-5
                                      transition hover:border-violet-500/30
                                      hover:bg-slate-900/40">

                                <div class="flex items-start justify-between gap-4">

                                    <div>

                                        <div class="mb-2 flex flex-wrap gap-2">

                                            <span class="rounded-full
                                                         border px-2.5 py-1
                                                         text-[10px] font-semibold
                                                         uppercase tracking-wider
                                                         {{ $mode === 'ai'
                                                             ? 'border-violet-500/20 bg-violet-500/10 text-violet-300'
                                                             : 'border-slate-700 bg-slate-900 text-slate-400' }}">
                                                {{ $mode === 'ai' ? '✦ AI Generated' : 'Manual' }}
                                            </span>

                                            @if($dice)
                                                <span class="rounded-full
                                                             border border-amber-500/20
                                                             bg-amber-500/[0.06]
                                                             px-2.5 py-1
                                                             text-[10px] text-amber-300">
                                                    {{ strtoupper($dice) }}
                                                </span>
                                            @endif

                                        </div>

                                        <h3 class="text-lg font-semibold
                                                   text-slate-100
                                                   group-hover:text-violet-200">
                                            {{ $item->name }}
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            {{ count($item->payload['rows'] ?? []) }}
                                            encounter rows
                                        </p>

                                    </div>

                                    <span class="text-slate-600
                                                 transition
                                                 group-hover:translate-x-1
                                                 group-hover:text-violet-300">
                                        →
                                    </span>

                                </div>


                                <div class="mt-4 border-t
                                            border-slate-800/70 pt-3
                                            text-xs text-slate-600">
                                    Saved {{ $item->created_at->diffForHumans() }}
                                </div>

                            </a>


                            {{-- ====================================================
                                 MAPS
                            ==================================================== --}}
                        @elseif($type === 'maps')

                            <div class="group rounded-2xl border
                                        border-slate-800 bg-slate-950 p-5
                                        transition hover:border-indigo-500/30
                                        hover:bg-slate-900/40">

                                <div class="flex flex-col gap-5
                                            sm:flex-row sm:items-center
                                            sm:justify-between">

                                    <a href="{{ route('saves.show', [
                                            'type' => $type,
                                            'id' => $item->id
                                        ]) }}"
                                       class="flex min-w-0 flex-1 gap-4">

                                        <div class="h-24 w-24 shrink-0
                                                    overflow-hidden rounded-xl
                                                    border border-slate-800
                                                    bg-slate-900">

                                            @if($item->image_path)

                                                <img src="{{ asset('storage/' . $item->image_path) }}"
                                                     alt="{{ $item->name ?? 'Saved map' }}"
                                                     class="h-full w-full object-cover">

                                            @else

                                                <div class="flex h-full w-full
                                                            items-center justify-center
                                                            text-xs text-slate-600">
                                                    No Image
                                                </div>

                                            @endif

                                        </div>


                                        <div class="min-w-0">

                                            <div class="mb-2 flex flex-wrap gap-2">

                                                <span class="rounded-full
                                                             border border-indigo-500/20
                                                             bg-indigo-500/10
                                                             px-2.5 py-1
                                                             text-[10px] font-semibold
                                                             uppercase tracking-wider
                                                             text-indigo-300">
                                                    AI Map
                                                </span>

                                                @if($item->difficulty)
                                                    <span class="rounded-full
                                                                 border border-slate-700
                                                                 bg-slate-900
                                                                 px-2.5 py-1
                                                                 text-[10px] text-slate-400">
                                                        {{ ucfirst($item->difficulty) }}
                                                    </span>
                                                @endif

                                            </div>

                                            <h3 class="truncate text-lg
                                                       font-semibold text-slate-100
                                                       group-hover:text-indigo-200">
                                                {{ $item->name ?: 'Untitled Map' }}
                                            </h3>

                                            <p class="mt-1 text-sm text-slate-400">
                                                {{ $item->theme ?: 'Unknown Theme' }}

                                                @if($item->size)
                                                    • {{ ucfirst($item->size) }}
                                                @endif
                                            </p>

                                            <p class="mt-2 text-xs text-slate-600">
                                                @if($item->room_count)
                                                    {{ $item->room_count }} rooms •
                                                @endif

                                                Saved {{ $item->created_at->diffForHumans() }}
                                            </p>

                                        </div>

                                    </a>


                                    <form method="POST"
                                          action="{{ route('maps.destroy', $item) }}"
                                          onsubmit="return confirm('Delete this saved map?');"
                                          class="shrink-0">

                                        @csrf
                                        @method('DELETE')

                                        <button class="rounded-xl border
                                                       border-slate-700
                                                       px-4 py-2 text-sm
                                                       text-slate-400 transition
                                                       hover:border-red-500/30
                                                       hover:bg-red-950/20
                                                       hover:text-red-300">
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </div>


                            {{-- ====================================================
                                 FEEDBACK
                            ==================================================== --}}
                        @elseif($type === 'feedback')

                            <a href="{{ route('saves.show', [
                                    'type' => $type,
                                    'id' => $item->id
                                ]) }}"
                               class="group rounded-2xl border
                                      border-slate-800 bg-slate-950 p-5
                                      transition hover:border-amber-500/30
                                      hover:bg-slate-900/40">

                                <div class="flex items-start justify-between gap-4">

                                    <div>

                                        <span class="rounded-full
                                                     border border-amber-500/20
                                                     bg-amber-500/[0.06]
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-amber-300">
                                            {{ ucfirst($item->feedback_type) }}
                                        </span>

                                        <h3 class="mt-3 text-lg font-semibold
                                                   text-slate-100
                                                   group-hover:text-amber-200">
                                            {{ $item->dungeon_name ?: 'Unnamed Dungeon' }}
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-400">
                                            {{ $item->theme ?: 'Unknown Theme' }}

                                            @if($item->tone)
                                                • {{ $item->tone }}
                                            @endif
                                        </p>

                                        <div class="mt-3 text-xs text-slate-500">
                                            Map {{ $item->map_rating ?? '—' }}/5
                                            • Layout {{ $item->layout_rating ?? '—' }}/5
                                            • Overall {{ $item->overall_rating ?? '—' }}/5
                                        </div>

                                    </div>

                                    <span class="text-slate-600
                                                 transition
                                                 group-hover:translate-x-1
                                                 group-hover:text-amber-300">
                                        →
                                    </span>

                                </div>


                                <div class="mt-4 border-t
                                            border-slate-800/70 pt-3
                                            text-xs text-slate-600">
                                    Submitted {{ $item->created_at->diffForHumans() }}
                                </div>

                            </a>

                        @endif


                    @empty

                        <div class="rounded-3xl border border-dashed
                                    border-slate-700
                                    bg-slate-950/50 px-6 py-14
                                    text-center">

                            <div class="mx-auto flex h-14 w-14
                                        items-center justify-center
                                        rounded-2xl border
                                        border-slate-700 bg-slate-900
                                        text-slate-500">
                                ◇
                            </div>

                            <h3 class="mt-5 text-lg font-semibold
                                       text-slate-100">
                                No saved {{ $type }}
                            </h3>

                            <p class="mt-2 text-sm text-slate-500">
                                Saved {{ $type }} will appear here.
                            </p>

                        </div>

                    @endforelse

                </div>
            </section>

        </div>

    </div>

</x-layouts.app>
