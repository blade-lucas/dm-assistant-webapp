<x-layouts.app :title="$item['name']">
    <div class="mx-auto max-w-4xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">{{ $item['name'] }}</h1>
                    <p class="mt-1 text-sm text-slate-400">
                        {{ ucfirst($item['category']) }} • {{ $item['type'] }}
                    </p>
                </div>

                <a href="{{ route('items.index') }}"
                   class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                    Back
                </a>
            </div>

            <div class="mt-6 grid gap-3 text-sm text-slate-300">
                <div>Cost: {{ $item['cost_number'] }} {{ $item['cost_currency'] }}</div>
                <div>Weight: {{ $item['weight'] ?? '—' }}</div>

                @if(!empty($item['armor']))
                    <div>Base AC: {{ $item['armor']['ac'] ?? '—' }}</div>
                    <div>Uses Dex Modifier: {{ !empty($item['armor']['dex_mod']) ? 'Yes' : 'No' }}</div>
                    <div>Max Dex Modifier: {{ ($item['armor']['max_dex_mod'] ?? -1) >= 0 ? $item['armor']['max_dex_mod'] : 'Unlimited' }}</div>
                    <div>Strength Requirement: {{ $item['armor']['strength_requirement'] ?? 0 }}</div>
                    <div>Stealth Disadvantage: {{ !empty($item['armor']['stealth_disadvantage']) ? 'Yes' : 'No' }}</div>
                @endif

                @if(!empty($item['weapon']))
                    <div>Damage: {{ $item['weapon']['damage_dice'] ?? '—' }} {{ $item['weapon']['damage_type'] ?? '' }}</div>
                    <div>Properties: {{ $item['weapon']['properties'] ?: '—' }}</div>
                @endif

                <div class="pt-2 whitespace-pre-line text-slate-200">
                    {{ $item['description'] ?: 'No description available.' }}
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
