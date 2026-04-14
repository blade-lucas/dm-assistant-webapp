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

                @else
                    <div class="text-sm text-slate-400">Map details coming soon.</div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
