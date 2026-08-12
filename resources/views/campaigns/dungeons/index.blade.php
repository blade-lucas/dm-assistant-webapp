<x-layouts.app title="Campaign Dungeons / Maps">
    <div class="mx-auto max-w-6xl space-y-6">

        @if(session('success'))
            <div class="rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        Dungeons / Maps
                    </h1>

                    <p class="mt-1 text-sm text-slate-400">
                        {{ $campaign->name }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('dungeons.generate', ['campaign' => $campaign->id]) }}"
                       class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                        Generate AI Map
                    </a>

                    <a href="{{ route('dungeon-new.create', ['campaign' => $campaign->id]) }}"
                       class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                        Generate Procedural Dungeon
                    </a>

                    <a href="{{ route('campaigns.show', $campaign) }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Back
                    </a>
                </div>
            </div>
        </div>

        {{-- Attached AI Maps --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h2 class="text-lg font-semibold">AI Generated Maps</h2>

            <div class="mt-4 grid gap-4 md:grid-cols-2">
                @forelse($attachedMaps as $map)
                    <div class="rounded-2xl border border-slate-800 p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold">
                                    {{ $map->name ?: 'Untitled Map' }}
                                </div>

                                <div class="mt-1 text-sm text-slate-400">
                                    {{ $map->theme ?? 'Unknown theme' }}

                                    @if($map->room_count)
                                        • {{ $map->room_count }} rooms
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('saves.show', ['type' => 'maps', 'id' => $map->id]) }}"
                                   class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-medium text-slate-900 hover:bg-white">
                                    Open
                                </a>

                                <form method="POST"
                                      action="{{ route('campaigns.maps.detach', [$campaign, $map]) }}">
                                    @csrf

                                    <button type="submit"
                                            class="rounded-xl border border-slate-700 px-3 py-2 text-xs hover:bg-slate-900">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 md:col-span-2">
                        No AI maps attached to this campaign yet.
                    </p>
                @endforelse
            </div>
        </div>

        {{-- Attached Procedural Dungeons --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h2 class="text-lg font-semibold">Procedural Dungeons</h2>

            <div class="mt-4 grid gap-4 md:grid-cols-2">
                @forelse($attachedDungeons as $dungeon)
                    <div class="rounded-2xl border border-slate-800 p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold">
                                    {{ $dungeon->name }}
                                </div>

                                <div class="mt-1 text-sm text-slate-400">
                                    {{ ucfirst($dungeon->type) }}

                                    @if($dungeon->seed)
                                        • Seed {{ $dungeon->seed }}
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <a href="{{ route('dungeon-new.show', $dungeon) }}"
                                   class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-medium text-slate-900 hover:bg-white">
                                    Open
                                </a>

                                <form method="POST"
                                      action="{{ route('campaigns.dungeons.detach', [$campaign, $dungeon]) }}">
                                    @csrf

                                    <button type="submit"
                                            class="rounded-xl border border-slate-700 px-3 py-2 text-xs hover:bg-slate-900">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400 md:col-span-2">
                        No procedural dungeons attached to this campaign yet.
                    </p>
                @endforelse
            </div>
        </div>

        {{-- Import existing --}}
        <div class="grid gap-6 lg:grid-cols-2">

            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                <h2 class="text-lg font-semibold">Import Existing AI Maps</h2>

                <div class="mt-4 space-y-3">
                    @forelse($availableMaps as $map)
                        <div class="flex items-center justify-between gap-4 rounded-2xl border border-slate-800 p-4">
                            <div>
                                <div class="font-semibold">
                                    {{ $map->name ?: 'Untitled Map' }}
                                </div>

                                <div class="mt-1 text-sm text-slate-400">
                                    {{ $map->theme ?? 'Unknown theme' }}
                                </div>
                            </div>

                            <form method="POST"
                                  action="{{ route('campaigns.maps.attach', [$campaign, $map]) }}">
                                @csrf

                                <button type="submit"
                                        class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                    Attach
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">
                            No unattached AI maps available.
                        </p>
                    @endforelse
                </div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                <h2 class="text-lg font-semibold">Import Existing Procedural Dungeons</h2>

                <div class="mt-4 space-y-3">
                    @forelse($availableDungeons as $dungeon)
                        <div class="flex items-center justify-between gap-4 rounded-2xl border border-slate-800 p-4">
                            <div>
                                <div class="font-semibold">
                                    {{ $dungeon->name }}
                                </div>

                                <div class="mt-1 text-sm text-slate-400">
                                    {{ ucfirst($dungeon->type) }}
                                </div>
                            </div>

                            <form method="POST"
                                  action="{{ route('campaigns.dungeons.attach', [$campaign, $dungeon]) }}">
                                @csrf

                                <button type="submit"
                                        class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                    Attach
                                </button>
                            </form>
                        </div>
                    @empty
                        <p class="text-sm text-slate-400">
                            No unattached procedural dungeons available.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</x-layouts.app>
