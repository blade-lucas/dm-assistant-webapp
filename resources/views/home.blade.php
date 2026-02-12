<x-layouts.app :title="'DM Assistant'">
    <div class="grid gap-8">
        {{-- Hero --}}
        <section class="rounded-3xl border border-slate-800 bg-gradient-to-br from-slate-900 to-slate-950 p-8">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="max-w-2xl">
                    <h1 class="text-3xl font-semibold tracking-tight md:text-4xl">
                        D&D Made Easy!
                    </h1>
                    <p class="mt-3 text-slate-300">
                        Browse rules, create characters, generate maps and encounters — all in one place.
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="/characters/create"
                           class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                            Create a Character
                        </a>
                        <a href="/map"
                           class="rounded-xl border border-slate-700 px-4 py-2 text-sm font-medium hover:bg-slate-900">
                            Generate a Map
                        </a>
                    </div>
                </div>

                {{-- Quick Search (wired later) --}}
                <div class="w-full md:w-[360px]">
                    <div class="rounded-2xl border border-slate-800 bg-slate-950/60 p-4">
                        <p class="text-sm font-medium">Quick search</p>
                        <p class="mt-1 text-xs text-slate-400">Jump to a monster or rule by name.</p>
                        <form class="mt-3 flex gap-2" action="/search" method="GET">
                            <input
                                name="q"
                                placeholder="e.g. Goblin, Fireball, Grapple..."
                                class="w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm outline-none placeholder:text-slate-600 focus:border-slate-600"
                            />
                            <button
                                class="rounded-xl bg-slate-800 px-4 py-2 text-sm hover:bg-slate-700"
                                type="submit"
                            >
                                Go
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        {{-- Primary tiles --}}
        <section>
            <div class="mb-3 flex items-end justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Start here</h2>
                    <p class="text-sm text-slate-400">Get your Campaign going in a fraction of the time!</p>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                {{-- Rules --}}
                <a href="/rules"
                   class="group rounded-2xl border border-slate-800 bg-slate-950 p-6 hover:bg-slate-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-400">Rules Library</p>
                            <h3 class="mt-1 text-xl font-semibold">DMG • PHB • MM</h3>
                            <p class="mt-2 text-sm text-slate-300">
                                Browse the catalog and find answers fast.
                            </p>
                        </div>
                        <span class="rounded-xl bg-slate-800 px-3 py-2 text-sm group-hover:bg-slate-700">Open</span>
                    </div>
                </a>

                {{-- Monsters --}}
                <a href="/monsters"
                   class="group rounded-2xl border border-slate-800 bg-slate-950 p-6 hover:bg-slate-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-400">Monster Manual</p>
                            <h3 class="mt-1 text-xl font-semibold">Database Search</h3>
                            <p class="mt-2 text-sm text-slate-300">
                                Filter by type/CR and open full stat blocks.
                            </p>
                        </div>
                        <span class="rounded-xl bg-slate-800 px-3 py-2 text-sm group-hover:bg-slate-700">Browse</span>
                    </div>
                </a>

                {{-- Characters --}}
                <a href="/characters"
                   class="group rounded-2xl border border-slate-800 bg-slate-950 p-6 hover:bg-slate-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-400">Character Creation</p>
                            <h3 class="mt-1 text-xl font-semibold">Build & manage sheets</h3>
                            <p class="mt-2 text-sm text-slate-300">
                                Guided creation with exports/imports.
                            </p>
                        </div>
                        <span class="rounded-xl bg-slate-800 px-3 py-2 text-sm group-hover:bg-slate-700">Create</span>
                    </div>
                </a>

                {{-- Encounters --}}
                <a href="/encounters"
                   class="group rounded-2xl border border-slate-800 bg-slate-950 p-6 hover:bg-slate-900">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="text-sm text-slate-400">Encounters</p>
                            <h3 class="mt-1 text-xl font-semibold">Generate tables</h3>
                            <p class="mt-2 text-sm text-slate-300">
                                Generate encounter tables tailored to your needs.
                            </p>
                        </div>
                        <span class="rounded-xl bg-slate-800 px-3 py-2 text-sm group-hover:bg-slate-700">Generate</span>
                    </div>
                </a>
            </div>
        </section>

        {{-- “Coming soon” row --}}
        <section class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h2 class="text-lg font-semibold">Dynamic Map Generation</h2>
            <p class="mt-1 text-sm text-slate-400">
                Generate maps for your campaign with our AI Powered Procedural Generation
            </p>
            <div class="mt-4 flex flex-wrap gap-2 text-xs">
                <span class="rounded-full border border-slate-800 bg-slate-950 px-3 py-1 text-slate-300">Campaigns</span>
                <span class="rounded-full border border-slate-800 bg-slate-950 px-3 py-1 text-slate-300">AI Dungeon Generation</span>
                <span class="rounded-full border border-slate-800 bg-slate-950 px-3 py-1 text-slate-300">Lore</span>
                <span class="rounded-full border border-slate-800 bg-slate-950 px-3 py-1 text-slate-300">Export Maps</span>
            </div>
        </section>
    </div>
</x-layouts.app>
