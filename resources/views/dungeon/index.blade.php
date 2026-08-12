<x-layouts.app title="Saved Dungeons">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- ============================================================
             HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-emerald-500/20
                        bg-gradient-to-br from-slate-900
                        via-emerald-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-emerald-500/[0.06] blur-3xl">
            </div>


            <div class="relative flex flex-col gap-6
                        sm:flex-row sm:items-center
                        sm:justify-between">

                <div>

                    <div class="mb-3 inline-flex items-center gap-2
                                rounded-full border border-emerald-500/20
                                bg-emerald-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-emerald-300">

                        Procedural Library

                    </div>


                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50">
                        Saved Dungeons
                    </h1>

                    <p class="mt-2 text-sm text-slate-400">
                        Reopen and continue editing your procedural dungeon layouts.
                    </p>

                </div>


                <a href="{{ route('dungeon-new.create') }}"
                   class="inline-flex items-center justify-center gap-2
                          rounded-xl bg-emerald-500
                          px-5 py-2.5 text-sm font-semibold
                          text-slate-950 transition
                          hover:bg-emerald-400">

                    + New Dungeon

                </a>

            </div>
        </section>


        {{-- ============================================================
             DUNGEON LIST
        ============================================================ --}}
        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-emerald-400">
                    Your Creations
                </p>

                <h2 class="mt-1 text-2xl font-semibold
                           tracking-tight text-slate-100">
                    Procedural dungeons
                </h2>

            </div>


            <div class="grid gap-4 md:grid-cols-2">

                @forelse($dungeons as $dungeon)

                    <a href="{{ route('dungeon-new.show', $dungeon) }}"
                       class="group relative overflow-hidden
                              rounded-2xl border border-slate-800
                              bg-slate-950 p-5
                              transition duration-200
                              hover:-translate-y-0.5
                              hover:border-emerald-500/30
                              hover:bg-slate-900/40">

                        <div class="absolute inset-y-0 left-0
                                    w-1 bg-emerald-500
                                    opacity-0 transition
                                    group-hover:opacity-100">
                        </div>


                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 gap-4">

                                <div class="flex h-11 w-11 shrink-0
                                            items-center justify-center
                                            rounded-xl
                                            border border-emerald-500/20
                                            bg-emerald-500/10
                                            text-emerald-300">

                                    <svg class="h-5 w-5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.7">
                                        <path d="M4 4h6v6H4z"/>
                                        <path d="M14 4h6v6h-6z"/>
                                        <path d="M4 14h6v6H4z"/>
                                        <path d="M14 14h6v6h-6z"/>
                                    </svg>

                                </div>


                                <div class="min-w-0">

                                    <h3 class="truncate text-lg
                                               font-semibold text-slate-100
                                               transition
                                               group-hover:text-emerald-200">
                                        {{ $dungeon->name }}
                                    </h3>

                                    <div class="mt-2 flex flex-wrap
                                                items-center gap-2">

                                        <span class="rounded-full
                                                     border border-emerald-500/20
                                                     bg-emerald-500/[0.06]
                                                     px-2.5 py-1
                                                     text-[10px]
                                                     font-semibold uppercase
                                                     tracking-wider
                                                     text-emerald-300">
                                            {{ ucfirst($dungeon->type) }}
                                        </span>

                                        @if($dungeon->seed)
                                            <span class="rounded-full
                                                         border border-slate-700
                                                         bg-slate-900
                                                         px-2.5 py-1
                                                         text-[10px]
                                                         text-slate-400">
                                                Seed {{ $dungeon->seed }}
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>


                            <span class="mt-2 text-slate-600
                                         transition
                                         group-hover:translate-x-1
                                         group-hover:text-emerald-300">
                                →
                            </span>

                        </div>


                        <div class="mt-5 border-t
                                    border-slate-800/70 pt-4
                                    text-xs text-slate-600">
                            Open in interactive dungeon editor
                        </div>

                    </a>


                @empty

                    <div class="rounded-3xl border border-dashed
                                border-slate-700
                                bg-slate-950/50
                                px-6 py-14 text-center
                                md:col-span-2">

                        <div class="mx-auto flex h-14 w-14
                                    items-center justify-center
                                    rounded-2xl
                                    border border-emerald-500/20
                                    bg-emerald-500/10
                                    text-emerald-300">

                            <svg class="h-7 w-7"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <path d="M4 4h6v6H4z"/>
                                <path d="M14 4h6v6h-6z"/>
                                <path d="M4 14h6v6H4z"/>
                                <path d="M14 14h6v6h-6z"/>
                            </svg>

                        </div>

                        <h3 class="mt-5 text-lg font-semibold
                                   text-slate-100">
                            No procedural dungeons yet
                        </h3>

                        <p class="mx-auto mt-2 max-w-md
                                  text-sm leading-6 text-slate-400">
                            Generate your first structured dungeon and
                            customize it in the interactive editor.
                        </p>

                        <a href="{{ route('dungeon-new.create') }}"
                           class="mt-6 inline-flex items-center gap-2
                                  rounded-xl bg-emerald-500
                                  px-5 py-2.5
                                  text-sm font-semibold text-slate-950
                                  transition hover:bg-emerald-400">

                            Generate Dungeon →

                        </a>

                    </div>

                @endforelse

            </div>
        </section>

    </div>

</x-layouts.app>
