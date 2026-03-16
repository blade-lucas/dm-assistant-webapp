<x-layouts.app title="Saved Encounters">
    <div class="mx-auto max-w-5xl">

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">Saved Encounter Tables</h1>
                    <p class="mt-1 text-sm text-slate-400">Load a saved table back into the generator.</p>
                </div>

                <a href="{{ route('encounters.index') }}"
                   class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                    Back to Generator
                </a>
            </div>

            @if(session('status'))
                <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                    {{ session('status') }}
                </div>
            @endif
        </div>

        <div class="mt-6 grid gap-3">
            @forelse($tables as $t)
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="text-lg font-semibold">{{ $t->name }}</div>
                            <div class="mt-1 text-xs text-slate-500">
                                Saved {{ $t->created_at->format('Y-m-d H:i') }}
                                • Rows: {{ count($t->payload['rows'] ?? []) }}
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('encounters.saved.load', $t) }}">
                                @csrf
                                <button class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                                    Load
                                </button>
                            </form>

                            <form method="POST" action="{{ route('encounters.saved.delete', $t) }}"
                                  onsubmit="return confirm('Delete this saved encounter table?');">
                                @csrf
                                @method('DELETE')
                                <button class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 text-sm text-slate-400">
                    No saved tables yet. Generate an encounter and save it.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
