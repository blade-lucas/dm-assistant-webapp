<x-layouts.app title="{{ $campaign->name }}">
    <div class="mx-auto max-w-5xl space-y-6">
        @if(session('success'))
            <div class="rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">{{ $campaign->name }}</h1>

                    <p class="mt-1 text-sm text-slate-400">
                        {{ $campaign->setting_theme ?? 'No theme set' }}
                        @if($campaign->tone)
                            • {{ $campaign->tone }}
                        @endif
                        • Level {{ $campaign->starting_level ?? '?' }}-{{ $campaign->max_level ?? '?' }}
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('campaigns.edit', $campaign) }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Edit
                    </a>

                    <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}"
                          onsubmit="return confirm('Archive this campaign?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                            Archive
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h2 class="text-lg font-semibold">Campaign Overview</h2>

            <div class="mt-4 grid gap-4 md:grid-cols-4">
                <div>
                    <div class="text-xs uppercase tracking-wide text-slate-500">Status</div>
                    <div class="mt-1 text-sm text-slate-200">{{ ucfirst($campaign->status) }}</div>
                </div>

                <div>
                    <div class="text-xs uppercase tracking-wide text-slate-500">Theme</div>
                    <div class="mt-1 text-sm text-slate-200">{{ $campaign->setting_theme ?? 'Not set' }}</div>
                </div>

                <div>
                    <div class="text-xs uppercase tracking-wide text-slate-500">Tone</div>
                    <div class="mt-1 text-sm text-slate-200">{{ $campaign->tone ?? 'Not set' }}</div>
                </div>

                <div>
                    <div class="text-xs uppercase tracking-wide text-slate-500">Level Range</div>
                    <div class="mt-1 text-sm text-slate-200">
                        {{ $campaign->starting_level ?? '?' }}-{{ $campaign->max_level ?? '?' }}
                    </div>
                </div>
            </div>

            <div class="mt-6 grid gap-6 md:grid-cols-2">
                <div>
                    <h3 class="text-sm font-semibold text-slate-300">World Description</h3>
                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-400">
                        {{ $campaign->world_description ?: 'No world description yet.' }}
                    </p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-slate-300">Campaign Summary</h3>
                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-slate-400">
                        {{ $campaign->campaign_summary ?: 'No campaign summary yet.' }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div>
                <h2 class="text-lg font-semibold">Campaign Tools</h2>
                <p class="mt-1 text-sm text-slate-400">
                    Connect this campaign to maps, encounters, characters, notes, and future AI context.
                </p>
            </div>

            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-800 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-semibold">Dungeons / Maps</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Import generated maps or create new campaign dungeons.
                            </p>
                        </div>
                        <a href="{{ route('campaigns.dungeons.index', $campaign) }}"
                           class="rounded-full border border-slate-700 px-3 py-1 text-xs text-slate-300 hover:bg-slate-900">
                            Open
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-semibold">Encounter Tables</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Attach or generate encounter tables for this campaign.
                            </p>
                        </div>
                        <a href="{{ route('campaigns.encounters.index', $campaign) }}"
                           class="rounded-full border border-slate-700 px-3 py-1 text-xs text-slate-300 hover:bg-slate-900">
                            Open
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-semibold">Characters / NPCs</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Manage player characters, NPCs, allies, and villains.
                            </p>
                        </div>
                        <a href="{{ route('campaigns.characters.index', $campaign) }}"
                           class="rounded-full border border-slate-700 px-3 py-1 text-xs text-slate-300 hover:bg-slate-900">
                            Open
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-semibold">Session Notes</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Track summaries, major events, and unresolved hooks.
                            </p>
                        </div>
                        <a href="{{ route('campaigns.session-notes.index', $campaign) }}"
                           class="rounded-full border border-slate-700 px-3 py-1 text-xs text-slate-300 hover:bg-slate-900">
                            Open
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-slate-800 p-5 md:col-span-2">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="font-semibold">Future AI Context</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Campaign details will eventually power smarter AI generation using notes, characters, maps, encounters, and unresolved hooks.
                            </p>
                        </div>
                        <span class="rounded-full border border-slate-700 px-3 py-1 text-xs text-slate-400">
                            Planned
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
