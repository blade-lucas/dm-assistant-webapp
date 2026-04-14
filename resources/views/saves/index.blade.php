<x-layouts.app title="Saves">
    <div class="mx-auto max-w-6xl grid gap-6 md:grid-cols-[240px_1fr]">

        {{-- Sidebar --}}
        <aside class="rounded-2xl border border-slate-800 bg-slate-950 p-3">
            <div class="px-3 py-2 text-xs font-semibold text-slate-400">Save Types</div>

            <nav class="grid gap-1 text-sm">
                <a class="rounded-xl px-3 py-2 {{ $type === 'characters' ? 'bg-slate-900' : 'hover:bg-slate-900' }}"
                   href="{{ route('saves.index', ['type' => 'characters']) }}">
                    Characters
                </a>

                <a class="rounded-xl px-3 py-2 {{ $type === 'encounters' ? 'bg-slate-900' : 'hover:bg-slate-900' }}"
                   href="{{ route('saves.index', ['type' => 'encounters']) }}">
                    Encounters
                </a>

                <a class="rounded-xl px-3 py-2 {{ $type === 'maps' ? 'bg-slate-900' : 'hover:bg-slate-900' }}"
                   href="{{ route('saves.index', ['type' => 'maps']) }}">
                    Maps
                </a>
            </nav>
        </aside>

        {{-- Main --}}
        <section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight capitalize">{{ $type }}</h1>
                    <p class="mt-1 text-sm text-slate-400">
                        Browse your saved {{ $type }}.
                    </p>
                </div>
            </div>

            <div class="mt-6 grid gap-4">
                @forelse($items as $item)
                    <a href="{{ route('saves.show', ['type' => $type, 'id' => $item->id]) }}"
                       class="block rounded-2xl border border-slate-800 bg-slate-950 p-5 hover:bg-slate-900">
                        @if($type === 'characters')
                            <div class="text-lg font-semibold">{{ $item->name }}</div>
                            <div class="mt-1 text-sm text-slate-400">
                                {{ strtoupper($item->role) }}
                                @if($item->race) • {{ $item->race }} @endif
                                @if($item->class) • {{ $item->class }} @endif
                                • Level {{ $item->level ?? 1 }}
                            </div>
                            <div class="mt-2 text-xs text-slate-500">
                                Updated {{ $item->updated_at->diffForHumans() }}
                            </div>
                        @elseif($type === 'encounters')
                            <div class="text-lg font-semibold">{{ $item->name }}</div>
                            <div class="mt-1 text-sm text-slate-400">
                                Saved encounter table
                            </div>
                            <div class="mt-2 text-xs text-slate-500">
                                Rows: {{ count($item->payload['rows'] ?? []) }} • Saved {{ $item->created_at->diffForHumans() }}
                            </div>
                        @else
                            <div class="text-lg font-semibold">Map Save #{{ $item->id ?? '—' }}</div>
                            <div class="mt-1 text-sm text-slate-400">Map saves coming soon.</div>
                        @endif
                    </a>
                @empty
                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 text-sm text-slate-400">
                        No saved {{ $type }} found.
                    </div>
                @endforelse
            </div>
        </section>
    </div>
</x-layouts.app>
