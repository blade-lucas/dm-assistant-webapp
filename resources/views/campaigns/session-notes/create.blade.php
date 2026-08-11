<x-layouts.app title="Create Session Note">
    <div class="mx-auto max-w-4xl rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">
                    New Session Note
                </h1>

                <p class="mt-1 text-sm text-slate-400">
                    {{ $campaign->name }}
                </p>
            </div>

            <a href="{{ route('campaigns.session-notes.index', $campaign) }}"
               class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                Back
            </a>
        </div>

        <form method="POST"
              action="{{ route('campaigns.session-notes.store', $campaign) }}"
              class="mt-6 grid gap-5">
            @csrf

            @include('campaigns.session-notes.partials.form', [
                'sessionNote' => null
            ])

            <div class="flex justify-end">
                <button type="submit"
                        class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                    Create Note
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
