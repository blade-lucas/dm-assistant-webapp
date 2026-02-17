<x-layouts.app :title="$character->name . ' • Equipment'">
    <x-layouts.app :title="$character->name . ' • Equipment'">
        @php
            $role = $character->role;
            $isGenericNpc = $role === 'generic_npc';
            $isPlayer = $role === 'player';

            $wallet = $equipment['wallet'] ?? ['cp'=>0,'sp'=>0,'ep'=>0,'gp'=>0,'pp'=>0];
            $inventory = $equipment['inventory'] ?? [];
        @endphp

        <div class="grid gap-6 md:grid-cols-[240px_1fr]">

            {{-- Sidebar (same gating rules as Basic tab) --}}
            <aside class="rounded-2xl border border-slate-800 bg-slate-950 p-3">
                <div class="px-3 py-2 text-xs font-semibold text-slate-400">Character</div>
                <nav class="grid gap-1 text-sm">
                    <a class="rounded-xl px-3 py-2 hover:bg-slate-900" href="{{ route('characters.basic.edit', $character) }}">Basic Info / Stats</a>

                    @if($isGenericNpc)
                        <span class="cursor-not-allowed rounded-xl bg-slate-900 px-3 py-2 text-slate-600">Equipment</span>
                    @else
                        <a class="rounded-xl bg-slate-900 px-3 py-2" href="{{ route('characters.equipment.edit', $character) }}">Equipment</a>
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

                    <a class="rounded-xl px-3 py-2 hover:bg-slate-900" href="{{ route('characters.notes.edit', $character) }}">DM Notes</a>
                </nav>
            </aside>

            {{-- Main --}}
            <section
                x-data="equipmentStore({
                catalog: @js($catalog),
                inventory: @js($inventory),
                wallet: @js($wallet),
            })"
                class="grid gap-4"
            >
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h1 class="text-xl font-semibold">Equipment</h1>
                            <p class="mt-1 text-sm text-slate-400">Store, inventory, item info, and wallet.</p>
                        </div>

                        {{-- Category tabs --}}
                        <div class="flex gap-2 text-sm">
                            <button type="button" class="rounded-xl px-3 py-2"
                                    :class="category==='weapons' ? 'bg-slate-900' : 'hover:bg-slate-900'"
                                    @click="setCategory('weapons')">Weapons</button>
                            <button type="button" class="rounded-xl px-3 py-2"
                                    :class="category==='armor' ? 'bg-slate-900' : 'hover:bg-slate-900'"
                                    @click="setCategory('armor')">Armor</button>
                            <button type="button" class="rounded-xl px-3 py-2"
                                    :class="category==='gear' ? 'bg-slate-900' : 'hover:bg-slate-900'"
                                    @click="setCategory('gear')">Gear</button>
                            <button type="button" class="rounded-xl px-3 py-2"
                                    :class="category==='other' ? 'bg-slate-900' : 'hover:bg-slate-900'"
                                    @click="setCategory('other')">Other</button>
                        </div>
                    </div>

                    @if (session('status'))
                        <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                            ✅ {{ session('status') }}
                        </div>
                    @endif

                    {{-- Store + Inventory + Info Panel --}}
                    <div class="mt-6 grid gap-4 lg:grid-cols-[1.3fr_1fr]">

                        {{-- Store Area --}}
                        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                            <div class="flex items-center justify-between">
                                <h2 class="text-sm font-semibold">Store</h2>
                                <p class="text-xs text-slate-500">Click View to load the info panel.</p>
                            </div>

                            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                                <template x-for="item in storeItems()" :key="item.id">
                                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                        <div class="flex gap-3">
                                            <div class="h-12 w-12 shrink-0 rounded-xl border border-slate-800 bg-slate-900 flex items-center justify-center text-xs text-slate-400">
                                                IMG
                                            </div>
                                            <div class="min-w-0">
                                                <div class="truncate text-sm font-semibold" x-text="item.name"></div>
                                                <div class="mt-1 text-xs text-slate-400">
                                                    Cost: <span class="text-slate-200" x-text="formatCost(item.cost)"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-3 flex justify-end">
                                            <button type="button"
                                                    class="rounded-xl border border-slate-700 px-3 py-2 text-xs hover:bg-slate-900"
                                                    @click="viewStore(item)">
                                                View
                                            </button>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Right column: Inventory + Info --}}
                        <div class="grid gap-4">

                            {{-- Inventory --}}
                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-sm font-semibold">Inventory</h2>
                                    <p class="text-xs text-slate-500">View shows details below.</p>
                                </div>

                                <form class="mt-4 grid gap-3" method="POST" action="{{ route('characters.equipment.update', $character) }}">
                                    @csrf

                                    {{-- Wallet hidden fields (so Save inventory also persists wallet) --}}
                                    <template x-for="(v,k) in wallet" :key="'w-'+k">
                                        <input type="hidden" :name="`equipment[wallet][${k}]`" :value="v">
                                    </template>

                                    <template x-for="(row, i) in inventory" :key="row.id ?? i">
                                        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                            <div class="flex gap-3">
                                                <div class="h-12 w-12 shrink-0 rounded-xl border border-slate-800 bg-slate-900 flex items-center justify-center text-xs text-slate-400">
                                                    IMG
                                                </div>

                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-start justify-between gap-2">
                                                        <div class="min-w-0">
                                                            <div class="truncate text-sm font-semibold" x-text="row.name"></div>
                                                            <div class="mt-1 text-xs text-slate-400">
                                                                Type: <span class="text-slate-200" x-text="row.type ?? 'Item'"></span>
                                                            </div>
                                                        </div>

                                                        <button type="button"
                                                                class="shrink-0 rounded-xl border border-slate-700 px-3 py-2 text-xs hover:bg-slate-900"
                                                                @click="viewInventory(row)">
                                                            View
                                                        </button>
                                                    </div>

                                                    <div class="mt-3 grid grid-cols-2 gap-3">
                                                        <div>
                                                            <label class="text-xs text-slate-400">Qty</label>
                                                            <input type="number" min="1" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm"
                                                                   x-model.number="row.qty">
                                                        </div>

                                                        <label class="flex items-center gap-2 pt-5 text-sm">
                                                            <input type="checkbox" x-model="row.equipped">
                                                            Equipped
                                                        </label>
                                                    </div>

                                                    {{-- Hidden fields for persistence --}}
                                                    <input type="hidden" :name="`equipment[inventory][${i}][id]`" :value="row.id">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][name]`" :value="row.name">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][type]`" :value="row.type">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][qty]`" :value="row.qty">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][equipped]`" :value="row.equipped ? 1 : 0">
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <div class="flex justify-end">
                                        <button class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white" type="submit">
                                            Save Inventory
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Info Panel --}}
                            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                <div class="flex items-center justify-between">
                                    <h2 class="text-sm font-semibold">Info Panel</h2>
                                    <p class="text-xs text-slate-500" x-text="infoModeLabel()"></p>
                                </div>

                                <div class="mt-4" x-show="!selected">
                                    <p class="text-sm text-slate-400">Click <span class="text-slate-200">View</span> on a store or inventory item.</p>
                                </div>

                                <div class="mt-4 grid gap-3" x-show="selected">
                                    <div class="text-lg font-semibold" x-text="selected?.name"></div>
                                    <div class="text-sm text-slate-400">
                                        Type: <span class="text-slate-200" x-text="selected?.type ?? 'Item'"></span>
                                    </div>
                                    <template x-if="selected?.cost">
                                        <div class="text-sm text-slate-400">
                                            Cost: <span class="text-slate-200" x-text="formatCost(selected.cost)"></span>
                                        </div>
                                    </template>

                                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-3 text-sm text-slate-400">
                                        Item details will be populated once your item database/JSON is ported.
                                    </div>

                                    {{-- Purchase button only when viewing store --}}
                                    <div x-show="mode==='store'" class="flex items-center gap-2">
                                        <form method="POST" action="{{ route('characters.equipment.purchase', $character) }}" class="flex items-center gap-2">
                                            @csrf
                                            <input type="hidden" name="category" :value="category">
                                            <input type="hidden" name="item_id" :value="selected?.id">
                                            <input type="number" name="qty" min="1" value="1"
                                                   class="w-20 rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                                            <button type="submit"
                                                    class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                                Purchase
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Wallet (bottom) --}}
                    <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950 p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-semibold">Wallet</h2>
                            <p class="text-xs text-slate-500">Saved with Inventory.</p>
                        </div>

                        <div class="mt-4 grid gap-3 sm:grid-cols-5">
                            <template x-for="(label,key) in {cp:'Copper', sp:'Silver', ep:'Electrum', gp:'Gold', pp:'Platinum'}" :key="key">
                                <div>
                                    <label class="text-xs text-slate-400" x-text="label"></label>
                                    <input type="number" min="0"
                                           class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm"
                                           x-model.number="wallet[key]">
                                </div>
                            </template>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        <script>
            function equipmentStore(payload) {
                return {
                    category: 'weapons',
                    mode: null, // 'store' | 'inventory'
                    selected: null,

                    catalog: payload.catalog ?? {},
                    inventory: payload.inventory ?? [],
                    wallet: payload.wallet ?? {cp:0,sp:0,ep:0,gp:0,pp:0},

                    setCategory(c) {
                        this.category = c;
                        // Optional: clear selection when switching categories
                        // this.selected = null; this.mode = null;
                    },

                    storeItems() {
                        return this.catalog?.[this.category] ?? [];
                    },

                    viewStore(item) {
                        this.mode = 'store';
                        this.selected = item;
                    },

                    viewInventory(row) {
                        this.mode = 'inventory';
                        this.selected = row;
                    },

                    infoModeLabel() {
                        if (!this.selected) return '—';
                        return this.mode === 'store' ? 'Viewing (Store)' : 'Viewing (Inventory)';
                    },

                    formatCost(costObj) {
                        if (!costObj) return '—';
                        const key = Object.keys(costObj)[0];
                        const val = costObj[key];
                        const map = {cp:'cp', sp:'sp', ep:'ep', gp:'gp', pp:'pp'};
                        return `${val} ${map[key] ?? key}`;
                    },
                }
            }
        </script>
    </x-layouts.app>
</x-layouts.app>
