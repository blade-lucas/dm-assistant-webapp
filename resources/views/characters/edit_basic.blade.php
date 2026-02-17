<x-layouts.app :title="$character->name . ' • Character'">
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

                <a class="rounded-xl bg-slate-900 px-3 py-2"
                   href="{{ route('characters.basic.edit', $character) }}">
                    Basic Info / Stats
                </a>

                {{-- Equipment --}}
                @if($isGenericNpc)
                    <span class="cursor-not-allowed rounded-xl px-3 py-2 text-slate-600">
                        Equipment
                    </span>
                @else
                    <a class="rounded-xl px-3 py-2 hover:bg-slate-900"
                       href="{{ route('characters.equipment.edit', $character) }}">
                        Equipment
                    </a>
                @endif

                {{-- Spells --}}
                @if($isGenericNpc)
                    <span class="cursor-not-allowed rounded-xl px-3 py-2 text-slate-600">
                        Spells
                    </span>
                @else
                    <a class="rounded-xl px-3 py-2 hover:bg-slate-900"
                       href="{{ route('characters.spells.edit', $character) }}">
                        Spells
                    </a>
                @endif

                {{-- NPC Traits --}}
                @if($isPlayer)
                    <span class="cursor-not-allowed rounded-xl px-3 py-2 text-slate-600">
                        NPC Traits
                    </span>
                @else
                    <a class="rounded-xl px-3 py-2 hover:bg-slate-900"
                       href="{{ route('characters.npc_traits.edit', $character) }}">
                        NPC Traits
                    </a>
                @endif

                <a class="rounded-xl px-3 py-2 hover:bg-slate-900"
                   href="{{ route('characters.notes.edit', $character) }}">
                    DM Notes
                </a>
            </nav>

            <div class="mt-4 rounded-xl border border-slate-800 bg-slate-950 p-3 text-xs text-slate-400">
                <div class="font-semibold text-slate-300">{{ $character->name }}</div>
                <div class="mt-1">AC: <span class="text-slate-200">{{ $character->ac ?? '—' }}</span></div>
                <div>Init: <span class="text-slate-200">{{ $character->initiative ?? '—' }}</span></div>
                <div>Speed: <span class="text-slate-200">{{ $character->speed ?? '—' }}</span></div>
            </div>
        </aside>

        {{-- Main Panel --}}
        <section>
            <div x-data="characterBasic()" class="rounded-2xl border border-slate-800 bg-slate-950 p-6">

                <h1 class="text-xl font-semibold">Basic Info / Stats</h1>

                {{-- Sub Tabs --}}
                <div class="mt-6 flex gap-2 text-sm">
                    <button type="button"
                            :class="tab==='stats' ? 'bg-slate-900' : 'hover:bg-slate-900'"
                            class="rounded-xl px-3 py-2"
                            @click="tab='stats'">Stats</button>

                    <button type="button"
                            :class="tab==='skills' ? 'bg-slate-900' : 'hover:bg-slate-900'"
                            class="rounded-xl px-3 py-2"
                            @click="tab='skills'">Skills</button>

                    <button type="button"
                            :class="tab==='features' ? 'bg-slate-900' : 'hover:bg-slate-900'"
                            class="rounded-xl px-3 py-2"
                            @click="tab='features'">Features</button>
                </div>

                <form method="POST"
                      action="{{ route('characters.basic.update', $character) }}"
                      class="mt-6 grid gap-6">
                    @csrf

                    {{-- Identity --}}
                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label class="text-sm text-slate-300">Character Name</label>
                            <input name="name"
                                   value="{{ old('name', $character->name) }}"
                                   class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-sm text-slate-300">Level</label>
                            <input name="level"
                                   type="number"
                                   min="1"
                                   max="20"
                                   value="{{ old('level', $character->level) }}"
                                   class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                        </div>
                    </div>

                    {{-- Role Radio Buttons --}}
                    <div>
                        <label class="text-sm text-slate-300">Role</label>

                        <div class="mt-2 grid gap-2 text-sm">
                            <label class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2">
                                <input type="radio" name="role" value="party_npc"
                                    @checked($character->role==='party_npc')>
                                Party NPC
                            </label>

                            <label class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2">
                                <input type="radio" name="role" value="generic_npc"
                                    @checked($character->role==='generic_npc')>
                                Generic NPC
                            </label>

                            <label class="flex items-center gap-2 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2">
                                <input type="radio" name="role" value="player"
                                    @checked($character->role==='player')>
                                Player Character
                            </label>
                        </div>
                    </div>

                    {{-- STATS TAB --}}
                    <div x-show="tab==='stats'">
                        <div class="grid gap-4 md:grid-cols-3">
                            @foreach(['str'=>'Strength','dex'=>'Dexterity','con'=>'Constitution','int'=>'Intelligence','wis'=>'Wisdom','cha'=>'Charisma'] as $key => $label)
                                <div class="rounded-2xl border border-slate-800 p-4">
                                    <label class="text-sm">{{ $label }}</label>
                                    <input type="number"
                                           name="abilities[{{ $key }}]"
                                           value="{{ $abilities[$key] ?? 10 }}"
                                           class="mt-2 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- SKILLS TAB --}}
                    <div x-show="tab==='skills'" class="grid gap-2">
                        @foreach($skillMap as $skill => $ability)
                            <label class="flex items-center justify-between rounded-xl border border-slate-800 px-4 py-2 text-sm">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox"
                                           name="skills[proficient][{{ $skill }}]"
                                           value="1"
                                        @checked(($skills['proficient'][$skill] ?? false))>
                                    {{ ucfirst(str_replace('_',' ',$skill)) }}
                                </div>
                                <span class="text-slate-400">{{ strtoupper($ability) }}</span>
                            </label>
                        @endforeach
                    </div>

                    {{-- FEATURES TAB --}}
                    <div x-show="tab==='features'" class="grid gap-4 md:grid-cols-2">
                        @foreach(['appearance','talents','mannerisms','interaction','ideals','bonds','flaws','sex'] as $field)
                            <div>
                                <label class="text-sm text-slate-300">
                                    {{ ucfirst(str_replace('_',' ',$field)) }}
                                </label>
                                <select name="features[{{ $field }}]"
                                        class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                                    <option value="">—</option>
                                    @foreach($options[$field === 'flaws' ? 'flaws' : $field] as $opt)
                                        <option value="{{ $opt }}"
                                            @selected(($features[$field] ?? null) === $opt)>
                                            {{ $opt }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach

                        <div>
                            <label class="text-sm text-slate-300">Age</label>
                            <input name="features[age]"
                                   value="{{ $features['age'] ?? '' }}"
                                   class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-sm text-slate-300">Height</label>
                            <input name="features[height]"
                                   value="{{ $features['height'] ?? '' }}"
                                   class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                        </div>

                        <div>
                            <label class="text-sm text-slate-300">Weight</label>
                            <input name="features[weight]"
                                   value="{{ $features['weight'] ?? '' }}"
                                   class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                        </div>
                    </div>

                    <div class="flex justify-end pt-6">
                        <button type="submit"
                                class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </section>
    </div>

    <script>
        function characterBasic() {
            return {
                tab: 'stats'
            }
        }
    </script>
</x-layouts.app>
