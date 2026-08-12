<x-layouts.app title="Saved Encounters">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- HEADER --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-violet-500/20
                        bg-gradient-to-br from-slate-900
                        via-violet-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-violet-500/[0.06] blur-3xl">
            </div>


            <div class="relative flex flex-col gap-6
                        sm:flex-row sm:items-center
                        sm:justify-between">

                <div>

                    <div class="mb-3 inline-flex items-center
                                rounded-full border border-violet-500/20
                                bg-violet-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-violet-300">
                        Encounter Library
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50">
                        Saved Encounter Tables
                    </h1>

                    <p class="mt-2 text-sm text-slate-400">
                        Reopen previously generated encounter tables
                        and continue editing or using them.
                    </p>

                </div>


                <a href="{{ route('encounters.index') }}"
                   class="inline-flex items-center gap-2
                          rounded-xl bg-violet-500
                          px-5 py-2.5 text-sm
                          font-semibold text-white
                          transition hover:bg-violet-400">

                    ← Encounter Generator

                </a>

            </div>
        </section>


        @if(session('status'))

            <div class="flex items-center gap-3
                        rounded-2xl border
                        border-emerald-800/60
                        bg-emerald-950/30
                        px-5 py-4 text-sm
                        text-emerald-200">

                <span>✓</span>
                {{ session('status') }}

            </div>

        @endif


        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-violet-400">
                    Your Tables
                </p>

                <h2 class="mt-1 text-2xl font-semibold
                           tracking-tight text-slate-100">
                    Encounter library
                </h2>

            </div>


            <div class="grid gap-4 md:grid-cols-2">

                @forelse($tables as $t)

                    @php
                        $mode = strtolower($t->payload['params']['mode']
                            ?? $t->payload['params']['source']
                            ?? 'manual');

                        $dice = $t->payload['params']['dice'] ?? null;
                    @endphp


                    <div class="group rounded-2xl
                                border border-slate-800
                                bg-slate-950 p-5
                                transition
                                hover:border-violet-500/30
                                hover:bg-slate-900/40">

                        <div class="flex items-start justify-between gap-4">

                            <div class="min-w-0">

                                <div class="mb-3 flex flex-wrap gap-2">

                                    @if($mode === 'ai')

                                        <span class="rounded-full
                                                     border border-violet-500/20
                                                     bg-violet-500/10
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-violet-300">
                                            ✦ AI
                                        </span>

                                    @else

                                        <span class="rounded-full
                                                     border border-slate-700
                                                     bg-slate-900
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-slate-400">
                                            Manual
                                        </span>

                                    @endif


                                    @if($dice)

                                        <span class="rounded-full
                                                     border border-amber-500/20
                                                     bg-amber-500/[0.06]
                                                     px-2.5 py-1
                                                     text-[10px] font-semibold
                                                     uppercase tracking-wider
                                                     text-amber-300">
                                            {{ strtoupper($dice) }}
                                        </span>

                                    @endif

                                </div>


                                <h3 class="truncate text-lg font-semibold
                                           text-slate-100">
                                    {{ $t->name }}
                                </h3>


                                <div class="mt-2 text-xs text-slate-500">
                                    {{ count($t->payload['rows'] ?? []) }} encounters
                                    • Saved {{ $t->created_at->format('M j, Y') }}
                                </div>

                            </div>


                            <div class="flex shrink-0 flex-col gap-2">

                                <form method="POST"
                                      action="{{ route('encounters.saved.load', $t) }}">

                                    @csrf

                                    <button class="w-full rounded-lg
                                                   bg-violet-500
                                                   px-3.5 py-2
                                                   text-xs font-semibold
                                                   text-white transition
                                                   hover:bg-violet-400">
                                        Load →
                                    </button>

                                </form>


                                <form method="POST"
                                      action="{{ route('encounters.saved.delete', $t) }}"
                                      onsubmit="return confirm('Delete this saved encounter table?');">

                                    @csrf
                                    @method('DELETE')

                                    <button class="w-full rounded-lg
                                                   border border-slate-700
                                                   px-3.5 py-2
                                                   text-xs text-slate-400
                                                   transition
                                                   hover:border-red-500/30
                                                   hover:bg-red-950/20
                                                   hover:text-red-300">
                                        Delete
                                    </button>

                                </form>

                            </div>

                        </div>
                    </div>


                @empty

                    <div class="rounded-3xl border border-dashed
                                border-slate-700
                                bg-slate-950/50 px-6 py-14
                                text-center md:col-span-2">

                        <div class="mx-auto flex h-14 w-14
                                    items-center justify-center
                                    rounded-2xl
                                    border border-violet-500/20
                                    bg-violet-500/10
                                    text-violet-300">
                            ⚔
                        </div>

                        <h3 class="mt-5 text-lg font-semibold
                                   text-slate-100">
                            No saved encounter tables
                        </h3>

                        <p class="mx-auto mt-2 max-w-md
                                  text-sm leading-6 text-slate-400">
                            Generate an encounter table and save it
                            to build your reusable encounter library.
                        </p>

                        <a href="{{ route('encounters.index') }}"
                           class="mt-6 inline-flex
                                  rounded-xl bg-violet-500
                                  px-5 py-2.5
                                  text-sm font-semibold text-white
                                  transition hover:bg-violet-400">
                            Generate Encounters →
                        </a>

                    </div>

                @endforelse

            </div>
        </section>

    </div>

</x-layouts.app>
