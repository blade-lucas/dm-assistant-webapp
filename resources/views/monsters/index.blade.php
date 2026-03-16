<x-layouts.app title="Monster Manual">
    <div class="mx-auto max-w-6xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">Monster Manual</h1>
                    <p class="mt-1 text-sm text-slate-400">Search and browse monsters. Click one to view details.</p>
                </div>

                <a href="{{ route('characters.index') }}"
                   class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                    Back to Characters
                </a>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route('monsters.index') }}" class="mt-6 grid gap-3 md:grid-cols-4">
                <div class="md:col-span-2">
                    <label class="text-xs text-slate-400">Search</label>
                    <input name="q" value="{{ $q }}"
                           placeholder="Aarakocra, goblin, dragon..."
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

                    <a href="{{ route('monsters.index') }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Reset
                    </a>

                    <div class="md:col-span-4 mt-3 flex flex-wrap gap-2">
                        <span class="text-xs text-slate-400 self-center">Quick CR:</span>

                        @foreach([
                            '0–1' => 1,
                            '1–5' => 5,
                            '5–10' => 10,
                            '10+' => 999
                        ] as $label => $value)
                            <a href="{{ route('monsters.index', ['q'=>$q, 'type'=>$type, 'max_cr'=>$value])}}"
                               class="rounded-xl border border-slate-700 px-3 py-1 text-xs hover:bg-slate-900">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>

                    <div class="ml-auto text-sm text-slate-500 self-center">
                        Results: <span class="text-slate-200 font-semibold">{{ count($results) }}</span>
                    </div>
                </div>
            </form>
        </div>

        {{-- Main split --}}
        <div class="mt-6 grid gap-6 lg:grid-cols-[360px_1fr]">

            {{-- List --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                <div class="flex items-center justify-between">
                    <div class="text-sm font-semibold">Monsters</div>
                    <div class="text-xs text-slate-500">Click to view</div>
                </div>

                <div class="mt-3 h-[70vh] overflow-auto rounded-2xl border border-slate-800 bg-slate-950 p-2">
                    @forelse($results as $m)
                        @php
                            $slug = \Illuminate\Support\Str::slug($m['m_name'] ?? '');
                            $isActive = $slug === $selectedSlug;
                        @endphp

                        <a class="block rounded-xl border border-slate-800 px-3 py-2 hover:bg-slate-900 {{ $isActive ? 'bg-slate-900' : '' }}"
                           href="{{ route('monsters.index', ['q'=>$q, 'type'=>$type, 'max_cr'=>$maxCr, 'monster'=>$slug]) }}">
                            <div class="flex items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <div class="truncate text-sm font-semibold">{{ $m['m_name'] ?? 'Unnamed' }}</div>
                                    <div class="mt-1 text-xs text-slate-400">
                                        {{ $m['m_type'] ?? '—' }} •
                                        @php
                                            $cr = $m['m_cr'] ?? null;
                                            $crVal = is_numeric($cr) ? (float)$cr : null;

                                            $crClass = 'bg-slate-800 text-slate-300';

                                            if ($crVal !== null) {
                                                if ($crVal <= 1) $crClass = 'bg-green-900 text-green-300';
                                                elseif ($crVal <= 5) $crClass = 'bg-yellow-900 text-yellow-300';
                                                else $crClass = 'bg-red-900 text-red-300';
                                            }
                                        @endphp

                                        <span class="rounded px-2 py-0.5 text-xs {{ $crClass }}">
                                            CR {{ $cr ?? '—' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-xs text-slate-500">
                                    AC {{ $m['m_ac'] ?? '—' }}
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-3 text-sm text-slate-500">No results.</div>
                    @endforelse
                </div>
            </div>

            {{-- Detail panel --}}
            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                @if(!$selected)
                    <div class="text-sm text-slate-500">Select a monster to view details.</div>
                @else
                    @php
                        $name = $selected['m_name'] ?? 'Unnamed';
                    @endphp

                    <div class="flex flex-col gap-2 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h2 class="text-2xl font-semibold">{{ $name }}</h2>
                            <div class="mt-1 text-sm text-slate-400">
                                {{ $selected['m_size'] ?? '—' }}
                                {{ $selected['m_type'] ?? '—' }}
                                • {{ $selected['m_alignment'] ?? '—' }}
                                • CR {{ $selected['m_cr'] ?? '—' }} ({{ $selected['m_exp'] ?? '—' }} XP)
                            </div>
                        </div>

                        <div class="text-sm text-slate-300">
                            <div>AC: <span class="font-semibold">{{ $selected['m_ac'] ?? '—' }}</span></div>
                            <div>HP: <span class="font-semibold">{{ $selected['m_defaultHP'] ?? '—' }}</span>
                                <span class="text-slate-500">({{ $selected['m_customHP'] ?? '' }})</span>
                            </div>
                            <div>Speed: <span class="font-semibold">
                                {{ $selected['m_speed'] ?? '—' }}{{ !empty($selected['m_specialSpeed']) ? ' / '.$selected['m_specialSpeed'] : '' }}
                            </span></div>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="mt-6 grid grid-cols-6 gap-2 text-center">
                        @foreach([
                            'STR' => 'm_str',
                            'DEX' => 'm_dex',
                            'CON' => 'm_con',
                            'INT' => 'm_int',
                            'WIS' => 'm_wis',
                            'CHA' => 'm_cha',
                        ] as $label => $key)
                            <div class="rounded-xl border border-slate-800 bg-slate-950 p-3">
                                <div class="text-xs text-slate-500">{{ $label }}</div>
                                <div class="mt-1 text-lg font-semibold">{{ $selected[$key] ?? '—' }}</div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Extra lines --}}
                    <div class="mt-6 grid gap-2 text-sm">
                        @if(!empty($selected['m_skills']))
                            <div><span class="text-slate-400">Skills:</span> {{ $selected['m_skills'] }}</div>
                        @endif
                        @if(!empty($selected['m_senses']))
                            <div><span class="text-slate-400">Senses:</span> {{ $selected['m_senses'] }}</div>
                        @endif
                        @if(!empty($selected['m_languages']))
                            <div><span class="text-slate-400">Languages:</span> {{ $selected['m_languages'] }}</div>
                        @endif
                        @if(!empty($selected['m_damageResistance']))
                            <div><span class="text-slate-400">Resistances:</span> {{ $selected['m_damageResistance'] }}</div>
                        @endif
                        @if(!empty($selected['m_conditionImmunity']))
                            <div><span class="text-slate-400">Condition Immunities:</span> {{ $selected['m_conditionImmunity'] }}</div>
                        @endif
                    </div>

                    {{-- Description / Lore --}}
                    @php $desc = $selected['m_desc'] ?? []; @endphp
                    @if(is_array($desc) && count($desc))
                        <div class="mt-8">
                            <h3 class="text-sm font-semibold text-slate-200">Description</h3>
                            <div class="mt-3 grid gap-4">
                                @foreach($desc as $d)
                                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                        @if(!empty($d['title']))
                                            <div class="text-sm font-semibold">{{ $d['title'] }}</div>
                                        @endif
                                        <div class="mt-1 text-sm text-slate-300">{{ $d['description'] ?? '' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Abilities --}}
                    @php $abilities = $selected['m_abilities'] ?? []; @endphp
                    @if(is_array($abilities) && count($abilities))
                        <div class="mt-8">
                            <h3 class="text-sm font-semibold text-slate-200">Abilities</h3>
                            <div class="mt-3 grid gap-3">
                                @foreach($abilities as $a)
                                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                        <div class="text-sm font-semibold">{{ $a['name'] ?? 'Ability' }}</div>
                                        <div class="mt-1 text-sm text-slate-300">{{ $a['description'] ?? '' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Actions --}}
                    @php $actions = $selected['m_actions'] ?? []; @endphp
                    @if(is_array($actions) && count($actions))
                        <div class="mt-8">
                            <h3 class="text-sm font-semibold text-slate-200">Actions</h3>
                            <div class="mt-3 grid gap-3">
                                @foreach($actions as $a)
                                    <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                                        <div class="text-sm font-semibold">{{ $a['name'] ?? 'Action' }}</div>
                                        <div class="mt-1 text-sm text-slate-300">{{ $a['description'] ?? '' }}</div>
                                        @if(!empty($a['roll']))
                                            <div class="mt-2 text-xs text-slate-500">Roll: {{ $a['roll'] }}</div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
