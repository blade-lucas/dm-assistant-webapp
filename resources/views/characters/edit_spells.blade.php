<x-layouts.app :title="$character->name . ' • Spells'">
    @php
        $role = $character->role;
        $isGenericNpc = $role === 'generic_npc';
        $isPlayer = $role === 'player';

        $known = $spellsState['known'] ?? [];
        $prepared = $spellsState['prepared'] ?? [];

        $className = $magicSummary['class'] ?? '—';
        $level = $magicSummary['level'] ?? 1;
        $slots = $magicSummary['slots'] ?? ['cantrips'=>0,'1'=>0,'2'=>0,'3'=>0,'4'=>0,'5'=>0,'6'=>0,'7'=>0,'8'=>0,'9'=>0];
        $maxKnown = $magicSummary['max_known'] ?? 0;
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
                    <span class="cursor-not-allowed rounded-xl bg-slate-900 px-3 py-2 text-slate-600">Spells</span>
                @else
                    <a class="rounded-xl bg-slate-900 px-3 py-2" href="{{ route('characters.spells.edit', $character) }}">Spells</a>
                @endif

                @if($isPlayer)
                    <span class="cursor-not-allowed rounded-xl px-3 py-2 text-slate-600">NPC Traits</span>
                @else
                    <a class="rounded-xl px-3 py-2 hover:bg-slate-900" href="{{ route('characters.npc_traits.edit', $character) }}">NPC Traits</a>
                @endif

                <a class="rounded-xl px-3 py-2 hover:bg-slate-900" href="{{ route('characters.notes.edit', $character) }}">DM Notes</a>
            </nav>
        </aside>

        {{-- Main --}}
        <section
            x-data="spellsUi({
                catalog: @js($catalog),
                known: @js($known),
                prepared: @js($prepared),
                className: @js($className),
                level: @js($level),
                slots: @js($slots),
                maxKnown: @js($maxKnown),
            })"
            class="rounded-2xl border border-slate-800 bg-slate-950 p-6"
        >
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-xl font-semibold">Spells</h1>
                    <p class="mt-1 text-sm text-slate-400">Magic Summary and spell library.</p>
                </div>

                <div class="flex gap-2 text-sm">
                    <button type="button" class="rounded-xl px-3 py-2"
                            :class="tab==='summary' ? 'bg-slate-900' : 'hover:bg-slate-900'"
                            @click="tab='summary'">Magic Summary</button>
                    <button type="button" class="rounded-xl px-3 py-2"
                            :class="tab==='library' ? 'bg-slate-900' : 'hover:bg-slate-900'"
                            @click="tab='library'">Spells</button>
                </div>
            </div>

            @if (session('status'))
                <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                    ✅ {{ session('status') }}
                </div>
            @endif

            {{-- MAGIC SUMMARY --}}
            <div class="mt-6 grid gap-4" x-show="tab==='summary'">
                <div class="grid gap-4 lg:grid-cols-[1fr_1fr]">
                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-5">
                        <div class="text-2xl font-semibold">Class: <span x-text="className"></span></div>
                        <div class="mt-2 text-2xl font-semibold">Level: <span x-text="level"></span></div>

                        <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950 p-4">
                            <div class="text-sm font-semibold">Spell Slots</div>
                            <div class="mt-3 grid gap-1 text-sm text-slate-300">
                                <div class="flex justify-between"><span>Cantrips:</span><span x-text="slots.cantrips ?? 0"></span></div>
                                <template x-for="n in [1,2,3,4,5,6,7,8,9]" :key="n">
                                    <div class="flex justify-between">
                                        <span x-text="`${n}${ordinal(n)} Level:`"></span>
                                        <span x-text="slots[String(n)] ?? 0"></span>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-3 text-xs text-slate-500">
                                Max learnable spells (based on slots): <span class="text-slate-200 font-semibold" x-text="maxKnown"></span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-5">
                        <div class="flex items-end justify-between">
                            <div>
                                <div class="text-xl font-semibold">Known Spells</div>
                                <div class="mt-2 text-sm text-slate-300">
                                    Max Known Spells: <span class="font-semibold" x-text="maxKnown"></span>
                                </div>
                            </div>
                            <div class="text-sm text-slate-300">
                                Known: <span class="font-semibold" x-text="known.length"></span>
                            </div>
                        </div>

                        <div class="mt-4 h-[320px] overflow-auto rounded-2xl border border-slate-800 bg-slate-950 p-3">
                            <template x-for="sid in known" :key="sid">
                                <div class="mb-2 rounded-2xl border border-slate-800 bg-slate-950 p-3">
                                    <div class="flex gap-3">
                                        <div class="h-10 w-10 shrink-0 rounded-xl border border-slate-800 bg-slate-900 flex items-center justify-center text-xs text-slate-400">
                                            IMG
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="truncate text-sm font-semibold" x-text="spellName(sid)"></div>
                                            <div class="mt-1 text-xs text-slate-400">
                                                <span x-text="spellLevelSchool(sid)"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <div x-show="known.length === 0" class="text-sm text-slate-500">
                                No known spells yet.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SPELL LIBRARY --}}
            <div class="mt-6 grid gap-4" x-show="tab==='library'">
                <div class="grid gap-4 lg:grid-cols-[1fr_1fr]">
                    {{-- Library --}}
                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                        <div class="flex items-center justify-between">
                            <div class="text-sm font-semibold">Spell Library</div>
                            <select x-model.number="levelFilter"
                                    class="rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                                <option :value="0">Cantrips</option>
                                <option :value="1">1st Level</option>
                                <option :value="2">2nd Level</option>
                                <option :value="3">3rd Level</option>
                                <option :value="4">4th Level</option>
                                <option :value="5">5th Level</option>
                                <option :value="6">6th Level</option>
                                <option :value="7">7th Level</option>
                                <option :value="8">8th Level</option>
                                <option :value="9">9th Level</option>
                            </select>
                        </div>

                        <div class="mt-4 h-[460px] overflow-auto rounded-2xl border border-slate-800 bg-slate-950 p-3">
                            <template x-for="s in filteredSpells()" :key="s.id">
                                <div class="mb-2 rounded-2xl border border-slate-800 bg-slate-950 p-3">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="flex gap-3 min-w-0">
                                            <div class="h-10 w-10 shrink-0 rounded-xl border border-slate-800 bg-slate-900 flex items-center justify-center text-xs text-slate-400">
                                                IMG
                                            </div>
                                            <div class="min-w-0">
                                                <div class="truncate text-sm font-semibold" x-text="s.name"></div>
                                                <div class="mt-1 text-xs text-slate-400" x-text="s.school"></div>
                                            </div>
                                        </div>
                                        <button type="button"
                                                class="rounded-xl border border-slate-700 px-3 py-2 text-xs hover:bg-slate-900"
                                                @click="viewSpell(s)">
                                            View
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                        <div x-show="!selected" class="text-sm text-slate-500">
                            Click View on a spell to see details.
                        </div>

                        <div x-show="selected" class="grid gap-3">
                            <div class="text-2xl font-semibold" x-text="selected?.name"></div>
                            <div class="text-sm text-slate-400">
                                <span x-text="levelLabel(selected?.level)"></span>, <span x-text="selected?.school"></span>
                            </div>

                            <div class="grid gap-2 text-sm">
                                <div class="flex justify-between"><span class="text-slate-400">Cast Time:</span><span x-text="selected?.cast_time"></span></div>
                                <div class="flex justify-between"><span class="text-slate-400">Range:</span><span x-text="selected?.range"></span></div>
                                <div class="flex justify-between"><span class="text-slate-400">Duration:</span><span x-text="selected?.duration"></span></div>
                                <div class="flex justify-between"><span class="text-slate-400">Components:</span><span x-text="selected?.components"></span></div>
                                <div class="flex justify-between"><span class="text-slate-400">Materials:</span><span x-text="selected?.materials || '—'"></span></div>
                            </div>

                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-3 text-sm text-slate-200" x-text="selected?.desc"></div>

                            <div class="flex items-center justify-between">
                                <div class="text-sm">
                                    <span class="text-slate-400">Status:</span>
                                    <span class="font-semibold" x-text="statusLabel(selected?.id)"></span>
                                </div>

                                <form method="POST" action="{{ route('characters.spells.toggle', $character) }}">
                                    @csrf
                                    <input type="hidden" name="spell_id" :value="selected?.id">
                                    <button type="submit"
                                            class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white"
                                            x-text="actionLabel(selected?.id)">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function spellsUi(payload) {
                    return {
                        tab: 'summary',
                        catalog: payload.catalog ?? [],
                        selected: null,
                        levelFilter: 0,

                        known: payload.known ?? [],
                        prepared: payload.prepared ?? [],

                        className: payload.className ?? '—',
                        level: payload.level ?? 1,
                        slots: payload.slots ?? {},
                        maxKnown: payload.maxKnown ?? 0,

                        filteredSpells() {
                            return (this.catalog || []).filter(s => (s.level ?? 0) === this.levelFilter);
                        },

                        viewSpell(s) { this.selected = s; },

                        spellById(id) {
                            return (this.catalog || []).find(x => x.id === id);
                        },

                        spellName(id) {
                            const s = this.spellById(id);
                            return s ? s.name : id;
                        },

                        spellLevelSchool(id) {
                            const s = this.spellById(id);
                            if (!s) return '—';
                            const lvl = (s.level ?? 0) === 0 ? 'Cantrip' : `${this.levelLabel(s.level)}`;
                            return `${lvl} • ${s.school ?? '—'}`;
                        },

                        statusLabel(id) {
                            if (!id) return 'Unknown';
                            return this.known.includes(id) ? 'Known' : 'Unknown';
                        },

                        actionLabel(id) {
                            if (!id) return 'Learn';
                            return this.known.includes(id) ? 'Forget' : 'Learn';
                        },

                        levelLabel(lvl) {
                            if (lvl === 0) return 'Cantrip';
                            if (lvl === 1) return '1st Level';
                            if (lvl === 2) return '2nd Level';
                            if (lvl === 3) return '3rd Level';
                            return `${lvl}th Level`;
                        },

                        ordinal(n) {
                            if (n === 1) return 'st';
                            if (n === 2) return 'nd';
                            if (n === 3) return 'rd';
                            return 'th';
                        }
                    }
                }
            </script>
        </section>
    </div>
</x-layouts.app>
