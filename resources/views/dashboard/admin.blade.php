<x-layouts.app title="Admin Dashboard">

    <div class="mx-auto max-w-6xl space-y-8">

        {{-- ============================================================
             HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-red-500/20
                        bg-gradient-to-br from-slate-900
                        via-red-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-80 w-80 rounded-full
                        bg-red-500/[0.05] blur-3xl">
            </div>


            <div class="relative">

                <div class="mb-4 inline-flex items-center gap-2
                            rounded-full border border-red-500/20
                            bg-red-500/10 px-3 py-1
                            text-xs font-semibold uppercase
                            tracking-[0.14em] text-red-300">
                    Administrative Workspace
                </div>

                <h1 class="text-3xl font-bold tracking-tight
                           text-slate-50 md:text-4xl">
                    Admin Dashboard
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6
                          text-slate-400">
                    Review global application data, saved content,
                    generated assets, and user feedback.
                </p>

            </div>
        </section>


        {{-- ============================================================
             ADMIN TOOLS
        ============================================================ --}}
        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-red-400">
                    Administration
                </p>

                <h2 class="mt-1 text-2xl font-semibold
                           tracking-tight text-slate-100">
                    Data & content management
                </h2>

            </div>


            <div class="grid gap-4 md:grid-cols-2">

                {{-- CHARACTERS --}}
                <a href="{{ route('characters.index') }}"
                   class="group rounded-2xl border border-slate-800
                          bg-slate-950 p-6 transition
                          hover:border-blue-500/30
                          hover:bg-slate-900/40">

                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 items-center
                                    justify-center rounded-xl
                                    bg-blue-500/10 text-blue-300">
                            👤
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.12em] text-blue-400">
                                Character Data
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                Characters
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Access character records and character-building structures.
                            </p>
                        </div>

                    </div>
                </a>


                {{-- ENCOUNTERS --}}
                <a href="{{ route('encounters.saved') }}"
                   class="group rounded-2xl border border-slate-800
                          bg-slate-950 p-6 transition
                          hover:border-violet-500/30
                          hover:bg-slate-900/40">

                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 items-center
                                    justify-center rounded-xl
                                    bg-violet-500/10 text-violet-300">
                            ⚔
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.12em] text-violet-400">
                                Encounter Data
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                Encounters
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Review saved encounter tables and generated encounter content.
                            </p>
                        </div>

                    </div>
                </a>


                {{-- DUNGEONS --}}
                <a href="{{ route('saves.index', ['type' => 'maps']) }}"
                   class="group rounded-2xl border border-slate-800
                          bg-slate-950 p-6 transition
                          hover:border-indigo-500/30
                          hover:bg-slate-900/40">

                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 items-center
                                    justify-center rounded-xl
                                    bg-indigo-500/10 text-indigo-300">
                            🗺
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.12em] text-indigo-400">
                                Generated Assets
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                Dungeons
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Review saved dungeon maps and generated stories.
                            </p>
                        </div>

                    </div>
                </a>


                {{-- FEEDBACK --}}
                <a href="{{ route('saves.index', ['type' => 'feedback']) }}"
                   class="group rounded-2xl border border-slate-800
                          bg-slate-950 p-6 transition
                          hover:border-amber-500/30
                          hover:bg-slate-900/40">

                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 items-center
                                    justify-center rounded-xl
                                    bg-amber-500/10 text-amber-300">
                            💬
                        </div>

                        <div>
                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.12em] text-amber-400">
                                User Feedback
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                Feedback
                            </h3>

                            <p class="mt-2 text-sm leading-6 text-slate-400">
                                Review feedback, bug reports, balance concerns, and requests.
                            </p>
                        </div>

                    </div>
                </a>

            </div>
        </section>

    </div>

</x-layouts.app>
