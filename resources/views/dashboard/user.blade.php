<x-layouts.app title="Dashboard">
    <div class="mx-auto max-w-5xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h1 class="text-2xl font-semibold tracking-tight">Account Dashboard</h1>
            <p class="mt-1 text-sm text-slate-400">
                Manage your account saves and stored content.
            </p>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            <a href="{{ route('saves.index') }}"
               class="rounded-2xl border border-slate-800 bg-slate-950 p-5 hover:bg-slate-900">
                <div class="text-lg font-semibold">Saves</div>
                <div class="mt-1 text-sm text-slate-400">
                    View and manage your saved characters, encounters, and maps.
                </div>
            </a>
        </div>
    </div>
</x-layouts.app>
