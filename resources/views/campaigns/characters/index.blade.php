<x-layouts.app title="Campaign Characters">

    <div class="mx-auto max-w-5xl space-y-8">

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
             PAGE HEADER
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-blue-500/20
                        bg-gradient-to-br from-slate-900 via-slate-950 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-72 w-72 rounded-full
                        bg-blue-500/[0.05] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-14 -top-16
                        h-44 w-44 rounded-full
                        border border-blue-500/[0.07]">
            </div>


            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div>
                    <div class="mb-3 inline-flex items-center gap-2
                                rounded-full border border-blue-500/20
                                bg-blue-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-blue-300">

                        <svg class="h-3.5 w-3.5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <circle cx="12" cy="8" r="3"/>
                            <path d="M5 21a7 7 0 0 1 14 0"/>
                        </svg>

                        Party & Cast
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight text-slate-50">
                        Characters & NPCs
                    </h1>

                    <p class="mt-2 max-w-xl text-sm leading-6 text-slate-400">
                        Manage the heroes, allies, rivals, and villains of
                        <span class="font-medium text-slate-300">
                            {{ $campaign->name }}
                        </span>.
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
             CREATE CHARACTER
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-blue-400">
                    Create
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Add someone new
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Create a new character directly inside this campaign.
                </p>
            </div>


            <div class="relative overflow-hidden rounded-2xl
                        border border-blue-500/20
                        bg-gradient-to-r from-blue-950/25
                        via-slate-950 to-slate-950 p-6">

                <div class="pointer-events-none absolute -right-16 -top-16
                            h-48 w-48 rounded-full
                            bg-blue-500/[0.06] blur-3xl">
                </div>


                <div class="relative flex flex-col gap-6
                            md:flex-row md:items-center
                            md:justify-between">

                    <div class="flex items-start gap-4">

                        <div class="flex h-12 w-12 shrink-0
                                    items-center justify-center
                                    rounded-xl border border-blue-500/20
                                    bg-blue-500/10 text-blue-300">

                            <svg class="h-6 w-6"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <circle cx="12" cy="8" r="3"/>
                                <path d="M5 21a7 7 0 0 1 14 0"/>
                                <path d="M19 5v6"/>
                                <path d="M16 8h6"/>
                            </svg>

                        </div>


                        <div>
                            <p class="text-xs font-semibold uppercase
                                      tracking-[0.14em] text-blue-400">
                                Character Creation
                            </p>

                            <h3 class="mt-1 text-lg font-semibold text-slate-100">
                                Create a Character or NPC
                            </h3>

                            <p class="mt-2 max-w-xl text-sm leading-6
                                      text-slate-400">
                                Start with basic character information, then
                                continue into equipment, spells, traits, and
                                notes while keeping the character attached
                                to this campaign.
                            </p>

                            <div class="mt-4 flex flex-wrap gap-2">

                                <span class="rounded-full border border-blue-500/20
                                             bg-blue-500/[0.06]
                                             px-2.5 py-1 text-[10px]
                                             font-medium uppercase tracking-wider
                                             text-blue-300">
                                    PCs
                                </span>

                                <span class="rounded-full border border-slate-700
                                             bg-slate-900
                                             px-2.5 py-1 text-[10px]
                                             font-medium uppercase tracking-wider
                                             text-slate-400">
                                    NPCs
                                </span>

                                <span class="rounded-full border border-slate-700
                                             bg-slate-900
                                             px-2.5 py-1 text-[10px]
                                             font-medium uppercase tracking-wider
                                             text-slate-400">
                                    Full Character Sheet
                                </span>

                            </div>
                        </div>

                    </div>


                    <a href="{{ route('characters.create', ['campaign' => $campaign->id]) }}"
                       class="inline-flex shrink-0 items-center
                              justify-center gap-2 rounded-xl
                              bg-blue-500 px-5 py-2.5
                              text-sm font-semibold text-white
                              transition hover:bg-blue-400">

                        New Character

                        <svg class="h-4 w-4"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="2">
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                        </svg>

                    </a>

                </div>
            </div>
        </section>


        {{-- ============================================================
             ATTACHED CHARACTERS
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-amber-400">
                    Campaign Cast
                </p>

                <h2 class="mt-1 text-2xl font-semibold tracking-tight
                           text-slate-100">
                    Attached characters
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Characters currently connected to {{ $campaign->name }}.
                </p>
            </div>


            <div class="grid gap-4 md:grid-cols-2">

                @forelse($attachedCharacters as $character)

                    <div class="group relative overflow-hidden rounded-2xl
                                border border-slate-800 bg-slate-950 p-5
                                transition duration-200
                                hover:border-blue-500/30
                                hover:bg-slate-900/40">

                        <div class="absolute inset-y-0 left-0 w-1
                                    bg-blue-500 opacity-0
                                    transition group-hover:opacity-100">
                        </div>


                        <div class="flex items-start justify-between gap-4">

                            <div class="flex min-w-0 gap-4">

                                <div class="flex h-11 w-11 shrink-0
                                            items-center justify-center
                                            rounded-xl border border-blue-500/20
                                            bg-blue-500/10 text-blue-300">

                                    <svg class="h-5 w-5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.7">
                                        <circle cx="12" cy="8" r="3"/>
                                        <path d="M5 21a7 7 0 0 1 14 0"/>
                                    </svg>

                                </div>


                                <div class="min-w-0">

                                    <h3 class="truncate text-lg font-semibold
                                               text-slate-100">
                                        {{ $character->name }}
                                    </h3>


                                    <div class="mt-1 flex flex-wrap items-center
                                                gap-x-2 gap-y-1
                                                text-sm text-slate-400">

                                        <span>
                                            {{ $character->race ?? 'Unknown race' }}
                                        </span>

                                        @if($character->class)
                                            <span class="text-blue-500">•</span>

                                            <span>
                                                {{ $character->class }}
                                            </span>
                                        @endif

                                    </div>


                                    <div class="mt-3 flex flex-wrap gap-2">

                                        @if($character->class)
                                            <span class="rounded-full
                                                         border border-blue-500/20
                                                         bg-blue-500/[0.06]
                                                         px-2.5 py-1
                                                         text-[10px] font-medium
                                                         uppercase tracking-wider
                                                         text-blue-300">
                                                {{ $character->class }}
                                            </span>
                                        @endif

                                        @if($character->race)
                                            <span class="rounded-full
                                                         border border-slate-700
                                                         bg-slate-900
                                                         px-2.5 py-1
                                                         text-[10px] font-medium
                                                         uppercase tracking-wider
                                                         text-slate-400">
                                                {{ $character->race }}
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>


                            <div class="flex shrink-0 flex-col gap-2">

                                <a href="{{ route('characters.basic.edit', [
                                        'character' => $character,
                                        'campaign' => $campaign->id,
                                    ]) }}"
                                   class="inline-flex items-center justify-center
                                          gap-1.5 rounded-lg bg-blue-500
                                          px-3 py-2 text-xs font-semibold
                                          text-white transition hover:bg-blue-400">
                                    Edit
                                    <span>→</span>
                                </a>


                                <form method="POST"
                                      action="{{ route('campaigns.characters.detach', [$campaign, $character]) }}">
                                    @csrf

                                    <button type="submit"
                                            class="w-full rounded-lg border
                                                   border-slate-700 px-3 py-2
                                                   text-xs text-slate-400
                                                   transition
                                                   hover:border-red-500/30
                                                   hover:bg-red-950/20
                                                   hover:text-red-300">
                                        Remove
                                    </button>
                                </form>

                            </div>

                        </div>


                        <div class="mt-5 flex items-center gap-2
                                    border-t border-slate-800/70
                                    pt-4 text-xs text-slate-600">

                            <svg class="h-3.5 w-3.5"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8">
                                <circle cx="12" cy="8" r="3"/>
                                <path d="M5 21a7 7 0 0 1 14 0"/>
                            </svg>

                            Campaign Character

                        </div>

                    </div>

                @empty

                    <div class="rounded-2xl border border-dashed
                                border-slate-700 bg-slate-950/50
                                px-6 py-12 text-center md:col-span-2">

                        <div class="mx-auto flex h-12 w-12
                                    items-center justify-center
                                    rounded-xl border border-blue-500/20
                                    bg-blue-500/10 text-blue-300">

                            <svg class="h-6 w-6"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <circle cx="12" cy="8" r="3"/>
                                <path d="M5 21a7 7 0 0 1 14 0"/>
                            </svg>

                        </div>

                        <h3 class="mt-4 font-semibold text-slate-200">
                            No characters attached yet
                        </h3>

                        <p class="mx-auto mt-2 max-w-md
                                  text-sm leading-6 text-slate-500">
                            Create someone new or attach a character you
                            already have.
                        </p>

                        <a href="{{ route('characters.create', ['campaign' => $campaign->id]) }}"
                           class="mt-5 inline-flex items-center gap-2
                                  rounded-xl bg-blue-500 px-4 py-2
                                  text-sm font-semibold text-white
                                  transition hover:bg-blue-400">
                            Create Character →
                        </a>

                    </div>

                @endforelse

            </div>
        </section>


        {{-- ============================================================
             IMPORT EXISTING CHARACTERS
        ============================================================ --}}
        <section>

            <div class="mb-5">
                <p class="text-xs font-semibold uppercase
                          tracking-[0.18em] text-slate-500">
                    Existing Content
                </p>

                <h2 class="mt-1 text-xl font-semibold tracking-tight
                           text-slate-100">
                    Import into this campaign
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Attach characters you've already created elsewhere.
                </p>
            </div>


            <div class="rounded-2xl border border-slate-800
                        bg-slate-950 p-5">

                <div class="grid gap-3 md:grid-cols-2">

                    @forelse($availableCharacters as $character)

                        <div class="flex items-center justify-between gap-4
                                    rounded-xl border border-slate-800
                                    bg-slate-950/50 p-4
                                    transition hover:border-blue-500/20">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="flex h-9 w-9 shrink-0
                                            items-center justify-center
                                            rounded-lg bg-blue-500/10
                                            text-blue-300">

                                    <svg class="h-4 w-4"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <circle cx="12" cy="8" r="3"/>
                                        <path d="M5 21a7 7 0 0 1 14 0"/>
                                    </svg>

                                </div>


                                <div class="min-w-0">

                                    <div class="truncate text-sm font-semibold
                                                text-slate-200">
                                        {{ $character->name }}
                                    </div>

                                    <div class="mt-1 text-xs text-slate-500">
                                        {{ $character->race ?? 'Unknown race' }}

                                        @if($character->class)
                                            • {{ $character->class }}
                                        @endif
                                    </div>

                                </div>

                            </div>


                            <form method="POST"
                                  action="{{ route('campaigns.characters.attach', [$campaign, $character]) }}">
                                @csrf

                                <button type="submit"
                                        class="shrink-0 rounded-lg
                                               border border-blue-500/30
                                               bg-blue-500/10
                                               px-3 py-2 text-xs
                                               font-semibold text-blue-300
                                               transition
                                               hover:bg-blue-500/20">
                                    Attach
                                </button>
                            </form>

                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed
                                    border-slate-800 px-5 py-8
                                    text-center md:col-span-2">

                            <p class="text-sm text-slate-500">
                                No unattached characters available.
                            </p>

                            <p class="mt-1 text-xs text-slate-600">
                                Standalone characters will appear here if
                                they aren't connected to a campaign yet.
                            </p>

                        </div>

                    @endforelse

                </div>
            </div>
        </section>

    </div>

</x-layouts.app>
