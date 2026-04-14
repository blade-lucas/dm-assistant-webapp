<x-layouts.app title="Item Library">
    <div class="mx-auto max-w-6xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h1 class="text-2xl font-semibold tracking-tight">Item Library</h1>
            <p class="mt-1 text-sm text-slate-400">Browse armor, weapons, gear, and more.</p>

            <form method="GET" class="mt-6 grid gap-3 md:grid-cols-4">
                <div class="md:col-span-3">
                    <input name="q" value="{{ $q }}" placeholder="Search item name..."
                           class="w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                </div>

                <div>
                    <select name="category" class="w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" @selected($category === $cat)>{{ ucfirst($cat) }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="mt-6 grid gap-4">
            @forelse($items as $item)
                <a href="{{ route('items.show', $item['id']) }}"
                   class="block rounded-2xl border border-slate-800 bg-slate-950 p-5 hover:bg-slate-900">
                    <div class="text-lg font-semibold">{{ $item['name'] }}</div>
                    <div class="mt-1 text-sm text-slate-400">
                        {{ ucfirst($item['category']) }} • {{ $item['type'] }}
                    </div>
                    <div class="mt-2 text-xs text-slate-500">
                        Cost: {{ $item['cost_number'] }} {{ $item['cost_currency'] }}
                        @if(!is_null($item['weight']))
                            • Weight: {{ $item['weight'] }}
                        @endif
                    </div>
                </a>
            @empty
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 text-sm text-slate-400">
                    No items found.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
