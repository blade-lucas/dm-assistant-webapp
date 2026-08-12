<x-layouts.app title="{{ $sessionNote->title }}">
    <div class="mx-auto max-w-4xl space-y-6">
        @if(session('success'))
            <div class="rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        {{ $sessionNote->title }}
                    </h1>

                    <p class="mt-1 text-sm text-slate-400">
                        {{ $campaign->name }}

                        @if($sessionNote->session_number)
                            • Session {{ $sessionNote->session_number }}
                        @endif

                        @if($sessionNote->session_date)
                            • {{ $sessionNote->session_date->format('M j, Y') }}
                        @endif
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('campaigns.session-notes.index', $campaign) }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Back
                    </a>

                    <a href="{{ route('campaigns.session-notes.edit', [$campaign, $sessionNote]) }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('campaigns.session-notes.destroy', [$campaign, $sessionNote]) }}"
                          onsubmit="return confirm('Delete this session note?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h2 class="text-lg font-semibold">Summary</h2>
            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-400">
                {{ $sessionNote->summary ?: 'No summary added.' }}
            </p>
        </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                    <h2 class="text-lg font-semibold">Important Events</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-400">
                        {{ $sessionNote->important_events ?: 'No important events added.' }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                    <h2 class="text-lg font-semibold">NPCs & Locations</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-400">
                        {{ $sessionNote->npcs_locations ?: 'No NPCs or locations added.' }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                    <h2 class="text-lg font-semibold">Player Decisions</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-400">
                        {{ $sessionNote->player_decisions ?: 'No player decisions recorded.' }}
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                    <h2 class="text-lg font-semibold">Unresolved Hooks</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-400">
                        {{ $sessionNote->unresolved_hooks ?: 'No unresolved hooks added.' }}
                    </p>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                <h2 class="text-lg font-semibold">DM Notes / Next Session</h2>
                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-400">
                    {{ $sessionNote->dm_notes ?: 'No DM notes added.' }}
                </p>
            </div>
    </div>
</x-layouts.app>
