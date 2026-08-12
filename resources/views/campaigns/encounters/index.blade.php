<x-layouts.app title="Campaign Encounter Tables">
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
                        Encounter Tables
                    </h1>

                    <p class="mt-1 text-sm text-slate-400">
                        {{ $campaign->name }}
                    </p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('encounters.index', ['campaign' => $campaign->id]) }}"
                       class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                        Create Encounter Table
                    </a>

                    <a href="{{ route('campaigns.show', $campaign) }}"
                       class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                        Back
                    </a>
                </div>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h2 class="text-lg font-semibold">Attached Encounter Tables</h2>

            <div class="mt-4 grid gap-4 md:grid-cols-2">
                @forelse($attachedTables as $table)
                    <div class="rounded-2xl border border-slate-800 p-4">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <div class="font-semibold">
                                    {{ $table->name }}
                                </div>

                                <div class="mt-1 text-sm text-slate-400">
                                    {{ ucfirst($table->payload['params']['mode'] ?? 'manual') }}
                                    @if(!empty($table->payload['params']['dice']))
                                        • {{ strtoupper($table->payload['params']['dice']) }}
                                    @endif
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <form method="POST"
                                      action="{{ route('encounters.saved.load', $table) }}">
                                    @csrf

                                    <button type="submit"
                                            class="rounded-xl bg-slate-100 px-3 py-2 text-xs font-medium text-slate-900 hover:bg-white">
                                        Open
                                    </button>
                                </form>

                                <form method="POST"
                                      action="{{ route('campaigns.encounters.detach', [$campaign, $table]) }}">
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
                        No encounter tables attached to this campaign yet.
                    </p>
                @endforelse
            </div>
        </div>

        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h2 class="text-lg font-semibold">Import Existing Encounter Tables</h2>

            <div class="mt-4 grid gap-4 md:grid-cols-2">
                @forelse($availableTables as $table)
                    <div class="flex items-center justify-between gap-4 rounded-2xl border border-slate-800 p-4">
                        <div>
                            <div class="font-semibold">
                                {{ $table->name }}
                            </div>

                            <div class="mt-1 text-sm text-slate-400">
                                {{ ucfirst($table->payload['params']['mode'] ?? 'manual') }}
                            </div>
                        </div>

                        <form method="POST"
                              action="{{ route('campaigns.encounters.attach', [$campaign, $table]) }}">
                            @csrf

                            <button type="submit"
                                    class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                                Attach
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-sm text-slate-400">
                        No unattached encounter tables available.
                    </p>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts.app>
