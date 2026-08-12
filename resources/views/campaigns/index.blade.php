<x-layouts.app title="Campaigns">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- ============================================================
             PAGE HEADER
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900 via-slate-950 to-slate-950
                        px-7 py-8 md:px-8">

            {{-- Ambient decoration --}}
            <div class="pointer-events-none absolute -right-20 -top-24
                        h-64 w-64 rounded-full
                        bg-amber-500/[0.04] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-16 -top-20
                        h-48 w-48 rounded-full
                        border border-amber-500/[0.06]">
            </div>

            <div class="relative flex flex-col gap-6
                        sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <div class="mb-3 inline-flex items-center gap-2
                                rounded-full border border-amber-500/20
                                bg-amber-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-amber-300">
                        <span class="h-1.5 w-1.5 rounded-full bg-amber-400"></span>
                        Campaign Library
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Your Adventures
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-400">
                        Create, manage, and continue your campaigns from one
                        connected Dungeon Master workspace.
                    </p>
                </div>

                <a href="{{ route('campaigns.create') }}"
                   class="inline-flex shrink-0 items-center justify-center gap-2
                          rounded-xl bg-amber-400 px-5 py-2.5
                          text-sm font-semibold text-slate-950
                          transition hover:bg-amber-300
                          hover:shadow-lg hover:shadow-amber-500/10">

                    <svg class="h-4 w-4"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2">
                        <path d="M12 5v14"/>
                        <path d="M5 12h14"/>
                    </svg>

                    New Campaign
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
             CAMPAIGN LIST
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-amber-400">
                    Campaigns
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Continue your adventure
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Open an existing campaign or begin a new one.
                </p>
            </div>


            <div class="grid gap-4">

                @forelse($campaigns as $campaign)

                    <div class="group relative overflow-hidden rounded-2xl
                                border border-slate-800 bg-slate-950
                                transition duration-200
                                hover:border-amber-500/30
                                hover:bg-slate-900/50
                                hover:shadow-lg hover:shadow-black/20">

                        {{-- Very subtle hover accent --}}
                        <div class="pointer-events-none absolute inset-y-0 left-0
                                    w-1 bg-amber-400 opacity-0
                                    transition group-hover:opacity-100">
                        </div>


                        <div class="relative flex flex-col
                                    md:flex-row md:items-stretch">

                            {{-- Main clickable campaign area --}}
                            <a href="{{ route('campaigns.show', $campaign) }}"
                               class="min-w-0 flex-1 p-6 md:p-7">

                                <div class="flex flex-col gap-5
                                            sm:flex-row sm:items-start
                                            sm:justify-between">

                                    <div class="min-w-0">

                                        {{-- Status + type --}}
                                        <div class="mb-3 flex flex-wrap items-center gap-2">

                                            @if(strtolower($campaign->status) === 'active')
                                                <span class="inline-flex items-center gap-1.5
                                                             rounded-full
                                                             border border-emerald-800
                                                             bg-emerald-950/30
                                                             px-2.5 py-1
                                                             text-[10px] font-semibold
                                                             uppercase tracking-wider
                                                             text-emerald-300">

                                                    <span class="h-1.5 w-1.5
                                                                 rounded-full
                                                                 bg-emerald-400">
                                                    </span>

                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center
                                                             rounded-full
                                                             border border-slate-700
                                                             bg-slate-900
                                                             px-2.5 py-1
                                                             text-[10px] font-semibold
                                                             uppercase tracking-wider
                                                             text-slate-400">

                                                    {{ ucfirst($campaign->status) }}
                                                </span>
                                            @endif


                                            @if($campaign->setting_theme)
                                                <span class="inline-flex items-center
                                                             rounded-full
                                                             border border-amber-500/20
                                                             bg-amber-500/[0.06]
                                                             px-2.5 py-1
                                                             text-[10px] font-semibold
                                                             uppercase tracking-wider
                                                             text-amber-300">

                                                    {{ $campaign->setting_theme }}
                                                </span>
                                            @endif

                                        </div>


                                        {{-- Name --}}
                                        <h3 class="truncate text-xl font-semibold
                                                   tracking-tight text-slate-100
                                                   transition
                                                   group-hover:text-amber-200">
                                            {{ $campaign->name }}
                                        </h3>


                                        {{-- Metadata --}}
                                        <div class="mt-2 flex flex-wrap items-center
                                                    gap-x-2 gap-y-1
                                                    text-sm text-slate-400">

                                            @if($campaign->tone)
                                                <span>{{ $campaign->tone }}</span>
                                            @else
                                                <span>No tone set</span>
                                            @endif

                                            @if($campaign->starting_level || $campaign->max_level)
                                                <span class="text-amber-500/60">•</span>

                                                <span>
                                                    Levels
                                                    {{ $campaign->starting_level ?? '?' }}–{{ $campaign->max_level ?? '?' }}
                                                </span>
                                            @endif

                                        </div>


                                        {{-- Summary preview --}}
                                        @if($campaign->campaign_summary)
                                            <p class="mt-4 max-w-2xl
                                                      line-clamp-2 text-sm
                                                      leading-6 text-slate-500">
                                                {{ $campaign->campaign_summary }}
                                            </p>
                                        @endif

                                    </div>


                                    {{-- Open indicator --}}
                                    <div class="hidden shrink-0
                                                items-center gap-2
                                                text-sm font-medium
                                                text-slate-500
                                                transition
                                                group-hover:text-amber-300
                                                sm:flex">

                                        Open Campaign

                                        <svg class="h-4 w-4 transition
                                                    group-hover:translate-x-1"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path d="M5 12h14"/>
                                            <path d="m13 6 6 6-6 6"/>
                                        </svg>

                                    </div>

                                </div>


                                {{-- Footer metadata --}}
                                <div class="mt-5 flex items-center gap-2
                                            border-t border-slate-800/70
                                            pt-4 text-xs text-slate-600">

                                    <svg class="h-3.5 w-3.5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M12 7v5l3 2"/>
                                    </svg>

                                    Updated {{ $campaign->updated_at->diffForHumans() }}

                                </div>

                            </a>


                            {{-- Archive action --}}
                            <div class="flex items-center border-t
                                        border-slate-800
                                        px-6 py-4
                                        md:border-l md:border-t-0
                                        md:px-5">

                                <form method="POST"
                                      action="{{ route('campaigns.destroy', $campaign) }}"
                                      onsubmit="return confirm('Archive this campaign?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="inline-flex items-center gap-2
                                                   rounded-xl border border-slate-700
                                                   bg-slate-950 px-3.5 py-2
                                                   text-xs font-medium text-slate-400
                                                   transition
                                                   hover:border-red-500/30
                                                   hover:bg-red-950/20
                                                   hover:text-red-300">

                                        <svg class="h-3.5 w-3.5"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="1.8">
                                            <path d="M3 6h18"/>
                                            <path d="M8 6V4h8v2"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v5"/>
                                            <path d="M14 11v5"/>
                                        </svg>

                                        Archive
                                    </button>
                                </form>

                            </div>

                        </div>
                    </div>


                @empty

                    {{-- ====================================================
                         EMPTY STATE
                    ==================================================== --}}
                    <div class="rounded-3xl border border-dashed
                                border-slate-700 bg-slate-950/50
                                px-6 py-14 text-center">

                        <div class="mx-auto flex h-14 w-14
                                    items-center justify-center
                                    rounded-2xl border border-amber-500/20
                                    bg-amber-500/10 text-amber-300">

                            <svg class="h-7 w-7"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.6">
                                <path d="M4 19.5V6.5A2.5 2.5 0 0 1 6.5 4H20v15H6.5A2.5 2.5 0 0 0 4 21.5"/>
                                <path d="M4 19.5A2.5 2.5 0 0 0 6.5 22H20"/>
                                <path d="M8 8h8"/>
                                <path d="M8 12h5"/>
                            </svg>

                        </div>

                        <h3 class="mt-5 text-lg font-semibold text-slate-100">
                            Your first adventure awaits
                        </h3>

                        <p class="mx-auto mt-2 max-w-md
                                  text-sm leading-6 text-slate-400">
                            Create a campaign to start connecting characters,
                            session notes, encounters, dungeons, and AI-generated
                            content.
                        </p>

                        <a href="{{ route('campaigns.create') }}"
                           class="mt-6 inline-flex items-center gap-2
                                  rounded-xl bg-amber-400 px-5 py-2.5
                                  text-sm font-semibold text-slate-950
                                  transition hover:bg-amber-300">

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2">
                                <path d="M12 5v14"/>
                                <path d="M5 12h14"/>
                            </svg>

                            Create Your First Campaign
                        </a>

                    </div>

                @endforelse

            </div>
        </section>

    </div>

</x-layouts.app>
