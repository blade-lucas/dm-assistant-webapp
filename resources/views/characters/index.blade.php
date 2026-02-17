<x-layouts.app title="Characters">
    <div class="mx-auto max-w-5xl rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Characters</h1>
                <p class="mt-1 text-sm text-slate-400">Create, open, and manage your characters.</p>
            </div>

            <a href="{{ route('characters.create') }}"
               class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                New Character
            </a>
        </div>

        @if(session('status'))
            <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                ✅ {{ session('status') }}
            </div>
        @endif

        <div class="mt-6 grid gap-3">
            @forelse($characters as $c)
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div class="min-w-0">
                            <div class="truncate text-lg font-semibold">{{ $c->name }}</div>
                            <div class="mt-1 text-sm text-slate-400">
                                {{ strtoupper($c->role) }}
                                @if($c->race) • {{ $c->race }} @endif
                                @if($c->class) • {{ $c->class }} @endif
                                • Level {{ $c->level ?? 1 }}
                            </div>
                            <div class="mt-1 text-xs text-slate-500">
                                Updated {{ $c->updated_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('characters.basic.edit', $c) }}"
                               class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                                Open
                            </a>

                            <form method="POST" action="{{ route('characters.destroy', $c) }}"
                                  onsubmit="return confirm('Delete this character?');">
                                @csrf
                                <button type="submit"
                                        class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 text-sm text-slate-400">
                    No characters yet. Click <span class="text-slate-200">New Character</span> to create one.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
