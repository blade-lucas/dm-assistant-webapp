<x-layouts.app :title="$character->name . ' • Equipment'">
    @php
        $role = $character->role;
        $isGenericNpc = $role === 'generic_npc';
        $isPlayer = $role === 'player';

        $wallet = $equipment['wallet'] ?? ['cp'=>0,'sp'=>0,'ep'=>0,'gp'=>0,'pp'=>0];
        $inventory = $equipment['inventory'] ?? [];
    @endphp

    <div class="grid gap-6 md:grid-cols-[240px_1fr]">

        {{-- Sidebar --}}
        <aside class="flex flex-col rounded-2xl border border-slate-800 bg-slate-950 p-3">
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
            <div class="mt-4 rounded-xl border border-slate-800 bg-slate-950 p-3 text-xs text-slate-400">
                <div class="font-semibold text-slate-300">{{ $character->name }}</div>
                <div class="mt-1">AC: <span class="text-slate-200">{{ $character->ac ?? '—' }}</span></div>
                <div>Init: <span class="text-slate-200">{{ $character->initiative ?? '—' }}</span></div>
                <div>Speed: <span class="text-slate-200">{{ $character->speed ?? '—' }}</span></div>
            </div>

            @if($character->campaign_id)
                <div class="mt-auto pt-4">
                    <a href="{{ route('campaigns.characters.index', $character->campaign_id) }}"
                       class="block w-full rounded-xl border border-slate-700 px-4 py-2 text-center text-sm hover:bg-slate-900">
                        Return to Campaign
                    </a>
                </div>
            @endif
        </aside>

        {{-- Main --}}
        <section
            x-data="equipmentStore(@js($catalog), @js($inventory), @js($wallet))"
            class="grid gap-4"
        >
            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-xl font-semibold">Equipment</h1>
                        <p class="mt-1 text-sm text-slate-400">Store, inventory, item info, and wallet.</p>
                    </div>

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

                <div class="mt-4 grid gap-4 lg:grid-cols-[1.15fr_0.85fr]">

                    {{-- Store Area --}}
                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-3 h-[538px] flex flex-col">
                        <div class="flex items-center justify-between">
                            <h2 class="text-sm font-semibold">Store</h2>
                            <p class="text-xs text-slate-500">Click View to inspect an item.</p>
                        </div>

                        <div class="mt-1 text-[11px] text-slate-500">
                            Category: <span x-text="category"></span> |
                            Count: <span x-text="storeItems().length"></span>
                        </div>

                        <div class="mt-3 grid flex-1 gap-2 overflow-y-auto pr-2">
                            <template x-for="item in storeItems()" :key="item.id">
                                <div class="rounded-xl border border-slate-800 bg-slate-950 p-3">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-800 bg-slate-900 text-[10px] text-slate-400">
                                            IMG
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <div class="truncate text-sm font-semibold leading-tight" x-text="item.name"></div>
                                            <div class="mt-0.5 text-[11px] text-slate-400">
                                                Cost: <span class="text-slate-200" x-text="formatItemCost(item)"></span>
                                            </div>
                                            <div class="text-[11px] text-slate-500 truncate" x-text="item.type"></div>
                                        </div>

                                        <button type="button"
                                                class="shrink-0 rounded-lg border border-slate-700 px-2.5 py-1.5 text-[11px] hover:bg-slate-900"
                                                @click="viewStore(item)">
                                            View
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <template x-if="storeItems().length === 0">
                                <div class="rounded-xl border border-slate-800 bg-slate-950 p-3 text-sm text-slate-400">
                                    No items found in this category.
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Right column --}}
                    <div class="grid gap-4">

                        {{-- Inventory --}}
                        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-3 h-[130px] flex flex-col">
                            <div class="flex items-center justify-between">
                                <h2 class="text-sm font-semibold">Inventory</h2>
                                <p class="text-xs text-slate-500">Saved with character equipment.</p>
                            </div>

                            <form class="mt-3 grid gap-3" method="POST" action="{{ route('characters.equipment.update', $character) }}">
                                @csrf

                                <template x-for="(v,k) in wallet" :key="'w-'+k">
                                    <input type="hidden" :name="`equipment[wallet][${k}]`" :value="v">
                                </template>

                                <div class="grid flex-1 gap-2 overflow-y-auto pr-2">
                                    <template x-for="(row, i) in inventory" :key="row.id ?? i">
                                        <div class="rounded-xl border border-slate-800 bg-slate-950 p-3">
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-slate-800 bg-slate-900 text-[10px] text-slate-400">
                                                    IMG
                                                </div>

                                                <div class="min-w-0 flex-1">
                                                    <div class="flex items-start justify-between gap-2">
                                                        <div class="min-w-0">
                                                            <div class="truncate text-sm font-semibold leading-tight" x-text="row.name"></div>
                                                            <div class="mt-0.5 text-[11px] text-slate-400">
                                                                <span x-text="row.type ?? 'Item'"></span>
                                                                •
                                                                <span x-text="row.category ?? 'gear'"></span>
                                                            </div>
                                                        </div>

                                                        <button type="button"
                                                                class="shrink-0 rounded-lg border border-slate-700 px-2.5 py-1.5 text-[11px] hover:bg-slate-900"
                                                                @click="viewInventory(row)">
                                                            View
                                                        </button>
                                                    </div>

                                                    <div class="mt-2 grid grid-cols-[80px_1fr] gap-3">
                                                        <div>
                                                            <label class="text-[11px] text-slate-400">Qty</label>
                                                            <input type="number"
                                                                   min="1"
                                                                   class="mt-1 w-full rounded-lg border border-slate-800 bg-slate-950 px-2 py-1.5 text-sm"
                                                                   x-model.number="row.qty">
                                                        </div>

                                                        <label class="flex items-center gap-2 pt-5 text-sm">
                                                            <input type="checkbox" x-model="row.equipped">
                                                            Equipped
                                                        </label>
                                                    </div>

                                                    <input type="hidden" :name="`equipment[inventory][${i}][id]`" :value="row.id">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][name]`" :value="row.name">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][type]`" :value="row.type">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][category]`" :value="row.category">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][qty]`" :value="row.qty">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][equipped]`" :value="row.equipped ? 1 : 0">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][cost_number]`" :value="row.cost_number ?? 0">
                                                    <input type="hidden" :name="`equipment[inventory][${i}][cost_currency]`" :value="row.cost_currency ?? 'gp'">
                                                </div>
                                            </div>
                                        </div>
                                    </template>

                                    <template x-if="inventory.length === 0">
                                        <div class="rounded-xl border border-slate-800 bg-slate-950 p-3 text-sm text-slate-400">
                                            No items in inventory yet.
                                        </div>
                                    </template>
                                </div>

                                <div class="flex justify-end">
                                    <button class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white" type="submit">
                                        Save Inventory
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Info Panel --}}
                        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-3 h-[392px] flex flex-col">
                            <div class="flex items-center justify-between">
                                <h2 class="text-sm font-semibold">Info Panel</h2>
                                <p class="text-xs text-slate-500" x-text="infoModeLabel()"></p>
                            </div>

                            <div class="mt-3 flex-1" x-show="!hasSelected()">
                                <p class="text-sm text-slate-400">Click <span class="text-slate-200">View</span> on a store or inventory item.</p>
                            </div>

                            <div class="mt-3 grid flex-1 gap-2 overflow-y-auto pr-2" x-show="hasSelected()">
                                <div class="text-base font-semibold" x-text="selectedName()"></div>

                                <div class="text-sm text-slate-400">
                                    Type: <span class="text-slate-200" x-text="selectedType()"></span>
                                </div>

                                <div class="text-sm text-slate-400">
                                    Category: <span class="text-slate-200" x-text="selectedCategory()"></span>
                                </div>

                                <div class="text-sm text-slate-400">
                                    Cost: <span class="text-slate-200" x-text="formatItemCost(selected)"></span>
                                </div>

                                <template x-if="selectedWeight() !== null">
                                    <div class="text-sm text-slate-400">
                                        Weight: <span class="text-slate-200" x-text="selectedWeight()"></span>
                                    </div>
                                </template>

                                <template x-if="hasArmor()">
                                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-2.5 text-sm text-slate-400">
                                        <div>Base AC: <span class="text-slate-200" x-text="armorAc()"></span></div>
                                        <div>Uses Dex Mod: <span class="text-slate-200" x-text="armorDexMod()"></span></div>
                                        <div>Max Dex Mod: <span class="text-slate-200" x-text="armorMaxDex()"></span></div>
                                        <div>Strength Requirement: <span class="text-slate-200" x-text="armorStrengthRequirement()"></span></div>
                                        <div>Stealth Disadvantage: <span class="text-slate-200" x-text="armorStealthDisadvantage()"></span></div>
                                    </div>
                                </template>

                                <template x-if="hasWeapon()">
                                    <div class="rounded-xl border border-slate-800 bg-slate-950 p-2.5 text-sm text-slate-400">
                                        <div>Damage: <span class="text-slate-200" x-text="weaponDamage()"></span></div>
                                        <div>Properties: <span class="text-slate-200" x-text="weaponProperties()"></span></div>
                                    </div>
                                </template>

                                <div class="rounded-xl border border-slate-800 bg-slate-950 p-2.5 text-sm text-slate-300 whitespace-pre-line"
                                     x-text="selectedDescription()">
                                </div>

                                <div x-show="mode === 'store'" class="flex items-center gap-2 pt-1">
                                    <form method="POST" action="{{ route('characters.equipment.purchase', $character) }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="category" :value="category">
                                        <input type="hidden" name="item_id" :value="selected ? selected.id : ''">
                                        <input type="number" name="qty" min="1" value="1"
                                               class="w-16 rounded-lg border border-slate-800 bg-slate-950 px-2 py-1.5 text-sm">
                                        <button type="submit"
                                                class="rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-900 hover:bg-white">
                                            Purchase
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Wallet --}}
                <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 p-3">
                    <div class="flex items-center justify-between">
                        <h2 class="text-sm font-semibold">Wallet</h2>
                        <p class="text-xs text-slate-500">Saved with Inventory.</p>
                    </div>

                    <div class="mt-3 grid gap-2 sm:grid-cols-5">
                        <template x-for="(label,key) in {cp:'Copper', sp:'Silver', ep:'Electrum', gp:'Gold', pp:'Platinum'}" :key="key">
                            <div>
                                <label class="text-[11px] text-slate-400" x-text="label"></label>
                                <input type="number" min="0"
                                       class="mt-1 w-full rounded-lg border border-slate-800 bg-slate-950 px-2 py-1.5 text-sm"
                                       x-model.number="wallet[key]">
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <script>
        window.equipmentStore = function (catalog, inventory, wallet) {
            return {
                category: 'weapons',
                mode: null,
                selected: null,
                catalog: catalog || {},
                inventory: inventory || [],
                wallet: wallet || { cp: 0, sp: 0, ep: 0, gp: 0, pp: 0 },

                setCategory(c) {
                    this.category = c;
                },

                storeItems() {
                    return this.catalog[this.category] || [];
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

                formatItemCost(item) {
                    if (!item) return '—';
                    const num = item.cost_number || 0;
                    const cur = item.cost_currency || 'gp';
                    return `${num} ${cur}`;
                },

                selectedName() {
                    return this.selected ? this.selected.name : '';
                },

                selectedType() {
                    return this.selected ? (this.selected.type || 'Item') : 'Item';
                },

                selectedCategory() {
                    return this.selected ? (this.selected.category || '—') : '—';
                },

                selectedDescription() {
                    return this.selected ? (this.selected.description || 'No description available.') : '';
                },

                selectedWeight() {
                    if (!this.selected) return null;
                    return this.selected.weight ?? null;
                },

                hasArmor() {
                    return !!(this.selected && this.selected.armor);
                },

                hasWeapon() {
                    return !!(this.selected && this.selected.weapon);
                },

                armorAc() {
                    return this.hasArmor() ? (this.selected.armor.ac ?? '—') : '—';
                },

                armorDexMod() {
                    return this.hasArmor() ? (this.selected.armor.dex_mod ? 'Yes' : 'No') : 'No';
                },

                armorMaxDex() {
                    if (!this.hasArmor()) return '—';
                    return this.selected.armor.max_dex_mod >= 0 ? this.selected.armor.max_dex_mod : 'Unlimited';
                },

                armorStrengthRequirement() {
                    return this.hasArmor() ? (this.selected.armor.strength_requirement ?? 0) : 0;
                },

                armorStealthDisadvantage() {
                    return this.hasArmor() ? (this.selected.armor.stealth_disadvantage ? 'Yes' : 'No') : 'No';
                },

                weaponDamage() {
                    if (!this.hasWeapon()) return '—';
                    const dice = this.selected.weapon.damage_dice || '—';
                    const type = this.selected.weapon.damage_type || '';
                    return `${dice} ${type}`.trim();
                },

                weaponProperties() {
                    if (!this.hasWeapon()) return '—';
                    return this.selected.weapon.properties || '—';
                },

                hasSelected() {
                    return !!this.selected;
                }
            };
        };
    </script>
</x-layouts.app>
