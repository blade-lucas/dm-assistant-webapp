<x-layouts.app title="Pick Monster">
    <div class="mx-auto max-w-6xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">Pick Monster #{{ $slot }}</h1>
                    <p class="mt-1 text-sm text-slate-400">
                        This will replace <span class="text-slate-200 font-semibold">[MONSTER]</span> for encounter row #{{ $row + 1 }}.
                    </p>
                    @if($encounter)
                        <p class="mt-2 text-sm text-slate-500">
                            Encounter template: {{ $encounter['encounterDetails'] ?? '' }}
                        </p>
                    @endif
                </div>

                <a href="{{ route('encounters.index', ['show' => 1]) }}"
                   class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                    Back to Encounter
                </a>
            </div>

            <form method="GET" action="{{ route('encounters.pickMonster', ['row'=>$row, 'slot'=>$slot, 'show'=>1]) }}">
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-400">Search</label>
                    <input name="q" value="{{ $q }}"
                           placeholder="goblin, dragon, undead..."
                           class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                </div>

                <div>
                    <label class="text-xs text-slate-400">Type</label>
                    <select name="type" class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                        <option value="">All</option>
                        @foreach($types as $t)
                            <option value="{{ $t }}" @selected($type === $t)>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="text-xs text-slate-400">Max CR</label>
                    <input name="max_cr" value="{{ $maxCr }}"
                           placeholder="e.g. 1, 5, 10"
                           class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                </div>

                <div class="md:col-span-4 flex gap-2">
                    <button type="submit"
                            class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                        Apply
                    </button>

                    <a href="{{ route('encounters.pickMonster', ['row'=>$row, 'slot'=>$slot]) }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Reset
                    </a>

                    <div class="ml-auto text-sm text-slate-500 self-center">
                        Results: <span class="text-slate-200 font-semibold">{{ count($results) }}</span>
                    </div>
                </div>
            </form>
        </div>

        <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950 p-4">
            <div class="grid gap-3">
                @forelse($results as $m)
                    @php
                        $slug = \Illuminate\Support\Str::slug($m['m_name'] ?? '');
                    @endphp

                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                            <div class="min-w-0">
                                <div class="truncate text-lg font-semibold">{{ $m['m_name'] ?? 'Unnamed' }}</div>
                                <div class="mt-1 text-sm text-slate-400">
                                    {{ $m['m_type'] ?? '—' }} • CR {{ $m['m_cr'] ?? '—' }} • AC {{ $m['m_ac'] ?? '—' }}
                                </div>
                            </div>

                            <form method="POST" action="{{ route('encounters.setMonster', ['row'=>$row, 'slot'=>$slot, 'show'=>1]) }}">
                                @csrf
                                <input type="hidden" name="monster_slug" value="{{ $slug }}">
                                <button type="submit"
                                        class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                                    Select
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-slate-500">No monsters match those filters.</div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
