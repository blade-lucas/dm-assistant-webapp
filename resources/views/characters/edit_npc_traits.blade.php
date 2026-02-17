<x-layouts.app :title="$character->name . ' • NPC Traits'">
    @php
        $role = $character->role;
        $isGenericNpc = $role === 'generic_npc';
        $isPlayer = $role === 'player';
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
                    <a class="rounded-xl bg-slate-900 px-3 py-2" href="{{ route('characters.npc_traits.edit', $character) }}">NPC Traits</a>
                @endif

                <a class="rounded-xl px-3 py-2 hover:bg-slate-900" href="{{ route('characters.notes.edit', $character) }}">DM Notes</a>
            </nav>
        </aside>

        {{-- Main --}}
        <section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">NPC INFO</h1>
                    <p class="mt-1 text-sm text-slate-400">Profession, background, and personal details.</p>
                </div>

                <div class="hidden md:block">
                    <span class="rounded-xl border border-slate-700 px-4 py-2 text-sm text-slate-300">Finish</span>
                </div>
            </div>

            @if (session('status'))
                <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                    ✅ {{ session('status') }}
                </div>
            @endif

            <form class="mt-6 grid gap-6" method="POST" action="{{ route('characters.npc_traits.update', $character) }}">
                @csrf

                <div class="grid gap-6 lg:grid-cols-[1fr_1fr]">
                    {{-- Left column: small fields + family --}}
                    <div class="grid gap-4">
                        <div class="grid gap-4 md:grid-cols-[180px_1fr] md:items-center">
                            <label class="text-sm text-slate-300">Profession:</label>
                            <select name="npc_traits[profession]"
                                    class="w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm outline-none focus:border-slate-600">
                                @foreach($professionOptions as $opt)
                                    <option value="{{ $opt }}" @selected(($npc['profession'] ?? '') === $opt)>{{ $opt }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid gap-4 md:grid-cols-[180px_1fr] md:items-center">
                            <label class="text-sm text-slate-300">Work Place:</label>
                            <input name="npc_traits[work_place]"
                                   value="{{ old('npc_traits.work_place', $npc['work_place'] ?? '') }}"
                                   placeholder="Enter text..."
                                   class="w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm outline-none focus:border-slate-600" />
                        </div>

                        <div class="grid gap-4 md:grid-cols-[180px_1fr] md:items-start">
                            <label class="pt-2 text-sm text-slate-300">Family:</label>
                            <textarea name="npc_traits[family]" rows="8"
                                      placeholder="Enter text..."
                                      class="w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm outline-none focus:border-slate-600">{{ old('npc_traits.family', $npc['family'] ?? '') }}</textarea>
                        </div>

                        <div class="grid gap-4 md:grid-cols-[180px_1fr] md:items-center">
                            <label class="text-sm text-slate-300">Religion:</label>
                            <input name="npc_traits[religion]"
                                   value="{{ old('npc_traits.religion', $npc['religion'] ?? '') }}"
                                   placeholder="Enter text..."
                                   class="w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm outline-none focus:border-slate-600" />
                        </div>
                    </div>

                    {{-- Right column: backstory --}}
                    <div class="grid gap-2">
                        <label class="text-sm text-slate-300">Backstory:</label>
                        <textarea name="npc_traits[backstory]" rows="14"
                                  placeholder="Enter text..."
                                  class="w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm outline-none focus:border-slate-600">{{ old('npc_traits.backstory', $npc['backstory'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="flex justify-end border-t border-slate-800 pt-6">
                    <button type="submit"
                            class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                        Save
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-layouts.app>
