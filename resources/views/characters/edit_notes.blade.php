<x-layouts.app :title="$character->name . ' • DM Notes'">
    @php
        $role = $character->role;
        $isGenericNpc = $role === 'generic_npc';
        $isPlayer = $role === 'player';

        $notes = $dmNotes['notes'] ?? [];
        $activeId = $dmNotes['active_id'] ?? ($notes[0]['id'] ?? null);
        $active = collect($notes)->firstWhere('id', $activeId) ?? ($notes[0] ?? null);
    @endphp

    <div class="grid gap-6 md:grid-cols-[240px_1fr]">
        {{-- Sidebar --}}
        <aside class="rounded-2xl border border-slate-800 bg-slate-950 p-3">
            <div class="px-3 py-2 text-xs font-semibold text-slate-400">Character</div>

            <nav class="grid gap-1 text-sm">
                <a class="rounded-xl px-3 py-2 hover:bg-slate-900" href="{{ route('characters.basic.edit', $character) }}">Basic Info / Stats</a>

                @if($isGenericNpc)
                    <span class="cursor-not-allowed rounded-xl px-3 py-2 text-slate-600">Equipment</span>
                @else
                    <a class="rounded-xl px-3 py-2 hover:bg-slate-900" href="{{ route('characters.equipment.edit', $character) }}">Equipment</a>
                @endif

                @if($isGenericNpc)
                    <span class="cursor-not-allowed rounded-xl px-3 py-2 text-slate-600">Spells</span>
                @else
                    <a class="rounded-xl px-3 py-2 hover:bg-slate-900" href="{{ route('characters.spells.edit', $character) }}">Spells</a>
                @endif

                @if($isPlayer)
                    <span class="cursor-not-allowed rounded-xl px-3 py-2 text-slate-600">NPC Traits</span>
                @else
                    <a class="rounded-xl px-3 py-2 hover:bg-slate-900" href="{{ route('characters.npc_traits.edit', $character) }}">NPC Traits</a>
                @endif

                <a class="rounded-xl bg-slate-900 px-3 py-2" href="{{ route('characters.notes.edit', $character) }}">DM Notes</a>
            </nav>
        </aside>

        {{-- Main --}}
        <section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">DM Notes</h1>
                    <p class="mt-1 text-sm text-slate-400">Create multiple notes and switch between them quickly.</p>
                </div>

                <form method="POST" action="{{ route('characters.notes.update', $character) }}">
                    @csrf
                    <input type="hidden" name="action" value="new">
                    <button type="submit"
                            class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                        New Note
                    </button>
                </form>
            </div>

            @if (session('status'))
                <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                    ✅ {{ session('status') }}
                </div>
            @endif

            <div class="mt-6 grid gap-4 lg:grid-cols-[320px_1fr]">

                {{-- Notes list --}}
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                    <div class="text-sm font-semibold">Notes</div>

                    <div class="mt-3 grid gap-2">
                        @foreach($notes as $n)
                            <div class="flex items-stretch gap-2">
                                <form method="POST" action="{{ route('characters.notes.update', $character) }}" class="flex-1">
                                    @csrf
                                    <input type="hidden" name="action" value="select">
                                    <input type="hidden" name="select_id" value="{{ $n['id'] }}">
                                    <button type="submit"
                                            class="w-full rounded-xl border border-slate-800 px-3 py-2 text-left text-sm hover:bg-slate-900
                                                   {{ ($n['id'] ?? null) === $activeId ? 'bg-slate-900' : 'bg-slate-950' }}">
                                        <div class="truncate font-semibold">{{ $n['title'] ?? 'Untitled' }}</div>
                                        <div class="mt-1 text-xs text-slate-500">
                                            Updated: {{ isset($n['updated_at']) ? \Illuminate\Support\Carbon::parse($n['updated_at'])->diffForHumans() : '—' }}
                                        </div>
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('characters.notes.delete', $character) }}">
                                    @csrf
                                    <input type="hidden" name="note_id" value="{{ $n['id'] }}">
                                    <button type="submit"
                                            class="rounded-xl border border-slate-800 px-3 py-2 text-xs text-slate-300 hover:bg-slate-900">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Editor --}}
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                    <div class="text-sm font-semibold">Editor</div>

                    <form class="mt-3 grid gap-3" method="POST" action="{{ route('characters.notes.update', $character) }}">
                        @csrf
                        <input type="hidden" name="action" value="save">
                        <input type="hidden" name="active_id" value="{{ $activeId }}">

                        <div>
                            <label class="text-xs text-slate-400">Title</label>
                            <input name="title"
                                   value="{{ old('title', $active['title'] ?? '') }}"
                                   class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm outline-none focus:border-slate-600">
                        </div>

                        <div>
                            <label class="text-xs text-slate-400">Body</label>
                            <textarea name="body" rows="14"
                                      class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm outline-none focus:border-slate-600"
                                      placeholder="Write DM notes here...">{{ old('body', $active['body'] ?? '') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                Save Note
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
</x-layouts.app>
