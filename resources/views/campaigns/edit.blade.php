<x-layouts.app title="Edit Campaign">
    <div class="mx-auto max-w-3xl rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Edit Campaign</h1>
                <p class="mt-1 text-sm text-slate-400">Update this campaign’s core details.</p>
            </div>

            <a href="{{ route('campaigns.show', $campaign) }}"
               class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                Back
            </a>
        </div>

        <form method="POST" action="{{ route('campaigns.update', $campaign) }}" class="mt-6 grid gap-5">
            @csrf
            @method('PUT')

            @include('campaigns.partials.form', ['campaign' => $campaign])

            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
