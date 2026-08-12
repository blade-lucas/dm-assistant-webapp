<x-layouts.app title="Campaign Characters">
    <div class="mx-auto max-w-5xl space-y-6">
        @if(session('success'))
            <div class="rounded-2xl border border-slate-800 bg-slate-950 px-4 py-3 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between">
                <div>
                    <h1 class="text-2xl font-semibold tracking-tight">
                        Characters / NPCs
                    </h1>

                    <p class="mt-1 text-sm text-slate-400">
                        {{ $campaign->name }}
                    </p>
                </div>

                <div>
                    <a href="{{ route('characters.create', ['campaign' => $campaign->id]) }}"
                       class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white mr-2">
                        New Character
                    </a>
                    <a href="{{ route('campaigns.show', $campaign) }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Back
                    </a>
                </div>

            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h2 class="text-lg font-semibold">Attached Characters</h2>

            <div class="mt-4 space-y-3">
                @forelse($attachedCharacters as $character)
                    <div class="flex items-center justify-between rounded-2xl border border-slate-800 p-4">
                        <div>
                            <div class="font-semibold">{{ $character->name }}</div>
                            <div class="mt-1 text-sm text-slate-400">
                                {{ $character->race ?? 'Unknown race' }}
                                @if($character->class)
                                    • {{ $character->class }}
                                @endif
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('characters.basic.edit', [
                                    'character' => $character,
                                    'campaign' => $campaign->id,
                                ]) }}"
                               class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                Edit
                            </a>

                            <form method="POST"
                                  action="{{ route('campaigns.characters.detach', [$campaign, $character]) }}">
                                @csrf

                                <button type="submit"
                                        class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">
                        No characters attached to this campaign yet.
                    </p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h2 class="text-lg font-semibold">Import Existing Characters</h2>

            <div class="mt-4 space-y-3">
                @forelse($availableCharacters as $character)
                    <div class="flex items-center justify-between rounded-2xl border border-slate-800 p-4">
                        <div>
                            <div class="font-semibold">{{ $character->name }}</div>
                            <div class="mt-1 text-sm text-slate-400">
                                {{ $character->race ?? 'Unknown race' }}
                                @if($character->class)
                                    • {{ $character->class }}
                                @endif
                            </div>
                        </div>

                        <form method="POST"
                              action="{{ route('campaigns.characters.attach', [$campaign, $character]) }}">
                            @csrf

                            <button type="submit"
                                    class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                Attach
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">
                        No unattached characters available.
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.app>
