<x-layouts.app title="Create Session Note">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- ============================================================
             HEADER
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900 via-slate-950 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-amber-500/[0.05] blur-3xl">
            </div>


            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div>
                    <div class="mb-3 inline-flex items-center gap-2
                                rounded-full border border-amber-500/20
                                bg-amber-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-amber-300">
                        New Journal Entry
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-50">
                        Create Session Note
                    </h1>

                    <p class="mt-2 text-sm text-slate-400">
                        Record a session from
                        <span class="font-medium text-slate-300">
                            {{ $campaign->name }}
                        </span>.
                    </p>
                </div>


                <a href="{{ route('campaigns.session-notes.index', $campaign) }}"
                   class="inline-flex items-center gap-2 rounded-xl
                          border border-slate-700 bg-slate-900/50
                          px-4 py-2 text-sm font-medium text-slate-300
                          transition hover:border-amber-500/30
                          hover:bg-slate-800">

                    <span>←</span>
                    Session Notes
                </a>

            </div>
        </section>


        {{-- ============================================================
             VALIDATION ERRORS
        ============================================================ --}}
        @if($errors->any())
            <div class="rounded-2xl border border-red-900
                        bg-red-950/30 p-5 text-sm text-red-200">

                <div class="font-semibold">
                    Please fix the following:
                </div>

                <ul class="mt-2 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- ============================================================
             FORM
        ============================================================ --}}
        <form method="POST"
              action="{{ route('campaigns.session-notes.store', $campaign) }}"
              class="grid gap-5">

            @csrf

            @include('campaigns.session-notes.partials.form', [
                'sessionNote' => null
            ])


            <div class="flex items-center justify-between
                        rounded-2xl border border-slate-800
                        bg-slate-950 px-5 py-4">

                <p class="text-xs text-slate-500">
                    Session notes contribute to campaign AI context.
                </p>

                <button type="submit"
                        class="inline-flex items-center gap-2
                               rounded-xl bg-amber-400
                               px-5 py-2.5 text-sm font-semibold
                               text-slate-950 transition
                               hover:bg-amber-300">

                    Create Note
                    <span>→</span>
                </button>

            </div>

        </form>

    </div>

</x-layouts.app>
