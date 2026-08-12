<x-layouts.app title="Create Campaign">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- ============================================================
             PAGE HEADER
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900 via-slate-950 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-amber-500/[0.05] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-14 -top-16
                        h-44 w-44 rounded-full
                        border border-amber-500/[0.07]">
            </div>


            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div>
                    <div class="mb-3 inline-flex items-center gap-2
                                rounded-full border border-amber-500/20
                                bg-amber-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-amber-300">

                        <svg class="h-3.5 w-3.5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <path d="M4 19.5V6.5A2.5 2.5 0 0 1 6.5 4H20v15H6.5A2.5 2.5 0 0 0 4 21.5"/>
                            <path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20"/>
                            <path d="M8 8h8"/>
                            <path d="M8 12h5"/>
                        </svg>

                        New Adventure
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Create Campaign
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-400">
                        Set up the world, tone, progression, and story context
                        for your next campaign.
                    </p>
                </div>


                <a href="{{ route('campaigns.index') }}"
                   class="inline-flex shrink-0 items-center gap-2
                          rounded-xl border border-slate-700
                          bg-slate-900/50 px-4 py-2
                          text-sm font-medium text-slate-300
                          transition hover:border-amber-500/30
                          hover:bg-slate-800 hover:text-slate-100">

                    <svg class="h-4 w-4"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path d="m15 18-6-6 6-6"/>
                    </svg>

                    Campaigns
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
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- ============================================================
             FORM
        ============================================================ --}}
        <form method="POST"
              action="{{ route('campaigns.store') }}"
              class="grid gap-5">

            @csrf

            @include('campaigns.partials.form', ['campaign' => null])


            <div class="flex flex-col gap-4 rounded-2xl
                        border border-slate-800 bg-slate-950
                        px-5 py-4 sm:flex-row
                        sm:items-center sm:justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-300">
                        Ready to begin?
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        You can update campaign details at any time after creation.
                    </p>
                </div>


                <button type="submit"
                        class="inline-flex items-center justify-center gap-2
                               rounded-xl bg-amber-400
                               px-5 py-2.5 text-sm font-semibold
                               text-slate-950 transition
                               hover:bg-amber-300
                               hover:shadow-lg
                               hover:shadow-amber-500/10">

                    Create Campaign

                    <svg class="h-4 w-4"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M5 12h14"/>
                        <path d="m13 6 6 6-6 6"/>
                    </svg>

                </button>

            </div>

        </form>

    </div>

</x-layouts.app>
