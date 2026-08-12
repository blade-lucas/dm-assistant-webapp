<x-layouts.app title="Edit Campaign">

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
                            <path d="M12 20h9"/>
                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                        </svg>

                        Campaign Settings
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Edit {{ $campaign->name }}
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-400">
                        Update this campaign's identity, progression,
                        world context, and current status.
                    </p>
                </div>


                <a href="{{ route('campaigns.show', $campaign) }}"
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

                    Campaign
                </a>

            </div>
        </section>


        {{-- ============================================================
             SUCCESS MESSAGE
        ============================================================ --}}
        @if(session('success'))
            <div class="flex items-center gap-3 rounded-2xl
                        border border-emerald-800/60
                        bg-emerald-950/30 px-5 py-4
                        text-sm text-emerald-200">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center
                            rounded-full bg-emerald-500/10 text-emerald-300">
                    ✓
                </div>

                {{ session('success') }}
            </div>
        @endif


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
              action="{{ route('campaigns.update', $campaign) }}"
              class="grid gap-5">

            @csrf
            @method('PUT')

            @include('campaigns.partials.form', ['campaign' => $campaign])


            <div class="flex flex-col gap-4 rounded-2xl
                        border border-slate-800 bg-slate-950
                        px-5 py-4 sm:flex-row
                        sm:items-center sm:justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-300">
                        Update campaign
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        Changes to campaign context will affect future
                        campaign-aware AI generation.
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

                    Save Changes

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
