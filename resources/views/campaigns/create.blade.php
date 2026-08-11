<x-layouts.app title="Create Campaign">
    <div class="mx-auto max-w-3xl rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <div class="flex items-start justify-between">
            <div>
                <h1 class="text-2xl font-semibold tracking-tight">Create Campaign</h1>
                <p class="mt-1 text-sm text-slate-400">Start a new campaign hub.</p>
            </div>

            <a href="{{ route('campaigns.index') }}"
               class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                Back
            </a>
        </div>

        @if($errors->any())
            <div class="mt-4 rounded-2xl border border-slate-800 bg-slate-950 p-4 text-sm">
                <div class="font-semibold">Fix the following:</div>
                <ul class="mt-2 list-disc pl-5 text-slate-300">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('campaigns.store') }}" class="mt-6 grid gap-5">
            @csrf

            @include('campaigns.partials.form', ['campaign' => null])

            <div class="flex justify-end pt-2">
                <button type="submit"
                        class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                    Create
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
