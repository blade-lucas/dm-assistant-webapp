<x-layouts.app title="Campaigns">
    <div class="mx-auto max-w-5xl rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Campaigns</h1>
                <p class="mt-1 text-sm text-slate-400">Create, open, and manage your campaigns.</p>
            </div>

            <a href="{{ route('campaigns.create') }}"
               class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                New Campaign
            </a>
        </div>

        @if(session('success'))
            <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="mt-6 grid gap-3">
            @forelse($campaigns as $campaign)
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-4">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div class="min-w-0">
                            <div class="truncate text-lg font-semibold">{{ $campaign->name }}</div>

                            <div class="mt-1 text-sm text-slate-400">
                                {{ $campaign->setting_theme ?? 'No theme' }}
                                @if($campaign->tone)
                                    • {{ $campaign->tone }}
                                @endif
                                @if($campaign->starting_level || $campaign->max_level)
                                    • Level {{ $campaign->starting_level ?? '?' }}-{{ $campaign->max_level ?? '?' }}
                                @endif
                            </div>

                            <div class="mt-1 text-xs text-slate-500">
                                Status: {{ ucfirst($campaign->status) }} • Updated {{ $campaign->updated_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('campaigns.show', $campaign) }}"
                               class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                                Open
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
            @empty
                <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6 text-sm text-slate-400">
                    No campaigns yet. Click <span class="text-slate-200">New Campaign</span> to create one.
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
