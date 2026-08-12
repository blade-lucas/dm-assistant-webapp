<x-layouts.app title="Session Notes">
    <div class="mx-auto max-w-5xl space-y-6">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        Session Notes
                    </h1>

                    <p class="mt-1 text-sm text-slate-400">
                        {{ $campaign->name }}
                    </p>
                </div>

                <div class="flex gap-2">
                    <a href="{{ route('campaigns.show', $campaign) }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Back
                    </a>

                    <a href="{{ route('campaigns.session-notes.create', $campaign) }}"
                       class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                        New Note
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="space-y-4">
            @forelse($sessionNotes as $note)
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-5">
                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                        <div>
                            <h2 class="text-lg font-semibold">
                                {{ $note->title }}
                            </h2>

                            <div class="mt-1 text-sm text-slate-400">
                                @if($note->session_number)
                                    Session {{ $note->session_number }}
                                @endif

                                @if($note->session_date)
                                    • {{ $note->session_date->format('M j, Y') }}
                                @endif
                            </div>

                            <p class="mt-3 text-sm leading-6 text-slate-400">
                                {{ Str::limit($note->summary, 220) ?: 'No summary.' }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('campaigns.session-notes.show', [$campaign, $note]) }}"
                               class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                                Open
                            </a>

                            <a href="{{ route('campaigns.session-notes.edit', [$campaign, $note]) }}"
                               class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 text-sm text-slate-400">
                    No session notes yet.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
