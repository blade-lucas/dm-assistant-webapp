<x-layouts.app title="Admin Dashboard">
    <div class="mx-auto max-w-6xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h1 class="text-2xl font-semibold tracking-tight">Admin Dashboard</h1>
            <p class="mt-1 text-sm text-slate-400">
                Administrative tools and global data management.
            </p>
        </div>

        <div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <a href="{{ route('characters.index') }}" class="rounded-2xl border border-slate-800 bg-slate-950 p-5 hover:bg-slate-900">
                <div class="text-lg font-semibold">Characters</div>
                <div class="mt-1 text-sm text-slate-400">Access character data and structures.</div>
            </a>

            <a href="{{ route('encounters.saved') }}" class="rounded-2xl border border-slate-800 bg-slate-950 p-5 hover:bg-slate-900">
                <div class="text-lg font-semibold">Encounters</div>
                <div class="mt-1 text-sm text-slate-400">Review saved encounter tables.</div>
            </a>

            <a href="{{ route('dungeons.generate') }}" class="rounded-2xl border border-slate-800 bg-slate-950 p-5 hover:bg-slate-900">
                <div class="text-lg font-semibold">Dungeons</div>
                <div class="mt-1 text-sm text-slate-400">Review dungeon generation tools and outputs.</div>
            </a>

            <a href="{{ route('saves.index', ['type' => 'feedback']) }}" class="rounded-2xl border border-slate-800 bg-slate-950 p-5 hover:bg-slate-900">
                <div class="text-lg font-semibold">Feedback</div>
                <div class="mt-1 text-sm text-slate-400">View user feedback and future admin tools.</div>
            </a>
        </div>
    </div>
</x-layouts.app>
