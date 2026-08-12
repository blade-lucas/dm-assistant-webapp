<x-layouts.app :title="$item['name']">

    <div class="mx-auto max-w-5xl space-y-8">

        @php
            $categoryName = strtolower($item['category'] ?? '');

            $isWeapon = !empty($item['weapon']);
            $isArmor = !empty($item['armor']);
        @endphp


        {{-- ============================================================
             HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900
                        via-amber-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-80 w-80 rounded-full
                        bg-amber-500/[0.06] blur-3xl">
            </div>


            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div>

                    <div class="mb-3 flex flex-wrap gap-2">

                        <span class="rounded-full
                                     border border-amber-500/20
                                     bg-amber-500/10
                                     px-3 py-1 text-xs
                                     font-semibold uppercase
                                     tracking-[0.14em]
                                     text-amber-300">
                            {{ ucfirst($item['category']) }}
                        </span>

                        @if(!empty($item['type']))
                            <span class="rounded-full
                                         border border-slate-700
                                         bg-slate-900
                                         px-3 py-1 text-xs
                                         text-slate-400">
                                {{ $item['type'] }}
                            </span>
                        @endif

                    </div>


                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        {{ $item['name'] }}
                    </h1>


                    <p class="mt-2 text-sm text-slate-400">
                        Equipment reference
                    </p>

                </div>


                <a href="{{ route('items.index') }}"
                   class="inline-flex items-center gap-2
                          rounded-xl border border-slate-700
                          bg-slate-900/60 px-4 py-2
                          text-sm font-medium text-slate-300
                          transition hover:border-amber-500/30
                          hover:bg-slate-800">
                    ← Item Library
                </a>

            </div>
        </section>


        {{-- ============================================================
             BASIC ITEM INFO
        ============================================================ --}}
        <section class="grid gap-4 sm:grid-cols-2">

            <div class="rounded-2xl border border-amber-500/20
                        bg-amber-500/[0.035] p-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.14em] text-amber-400">
                    Cost
                </p>

                <div class="mt-2 text-2xl font-bold text-amber-200">
                    {{ $item['cost_number'] }}
                    {{ strtoupper($item['cost_currency']) }}
                </div>

            </div>


            <div class="rounded-2xl border border-slate-800
                        bg-slate-950 p-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.14em] text-slate-500">
                    Weight
                </p>

                <div class="mt-2 text-2xl font-bold text-slate-200">
                    {{ $item['weight'] ?? '—' }}
                </div>

            </div>

        </section>


        {{-- ============================================================
             ARMOR DETAILS
        ============================================================ --}}
        @if($isArmor)

            <section class="overflow-hidden rounded-3xl
                            border border-blue-500/20
                            bg-slate-950">

                <div class="border-b border-slate-800
                            bg-gradient-to-r from-blue-950/20
                            to-slate-950 px-6 py-5">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] text-blue-400">
                        Armor Statistics
                    </p>

                    <h2 class="mt-1 text-lg font-semibold text-slate-100">
                        Defensive Properties
                    </h2>

                </div>


                <div class="grid gap-3 p-6
                            sm:grid-cols-2 lg:grid-cols-5">

                    <div class="rounded-xl border border-blue-500/20
                                bg-blue-500/[0.05]
                                p-4 text-center">

                        <div class="text-[10px] font-semibold uppercase
                                    tracking-wider text-blue-400">
                            Base AC
                        </div>

                        <div class="mt-1 text-2xl font-bold text-blue-200">
                            {{ $item['armor']['ac'] ?? '—' }}
                        </div>

                    </div>


                    <div class="rounded-xl border border-slate-800
                                bg-slate-900/30 p-4 text-center">

                        <div class="text-[10px] font-semibold uppercase
                                    tracking-wider text-slate-500">
                            Dex Modifier
                        </div>

                        <div class="mt-1 font-semibold text-slate-200">
                            {{ !empty($item['armor']['dex_mod']) ? 'Yes' : 'No' }}
                        </div>

                    </div>


                    <div class="rounded-xl border border-slate-800
                                bg-slate-900/30 p-4 text-center">

                        <div class="text-[10px] font-semibold uppercase
                                    tracking-wider text-slate-500">
                            Max Dex
                        </div>

                        <div class="mt-1 font-semibold text-slate-200">
                            {{ ($item['armor']['max_dex_mod'] ?? -1) >= 0
                                ? $item['armor']['max_dex_mod']
                                : 'Unlimited' }}
                        </div>

                    </div>


                    <div class="rounded-xl border border-slate-800
                                bg-slate-900/30 p-4 text-center">

                        <div class="text-[10px] font-semibold uppercase
                                    tracking-wider text-slate-500">
                            Strength Req.
                        </div>

                        <div class="mt-1 font-semibold text-slate-200">
                            {{ $item['armor']['strength_requirement'] ?? 0 }}
                        </div>

                    </div>


                    <div class="rounded-xl border
                                {{ !empty($item['armor']['stealth_disadvantage'])
                                    ? 'border-red-500/20 bg-red-500/[0.05]'
                                    : 'border-emerald-500/20 bg-emerald-500/[0.05]' }}
                                p-4 text-center">

                        <div class="text-[10px] font-semibold uppercase
                                    tracking-wider
                                    {{ !empty($item['armor']['stealth_disadvantage'])
                                        ? 'text-red-400'
                                        : 'text-emerald-400' }}">
                            Stealth
                        </div>

                        <div class="mt-1 font-semibold
                                    {{ !empty($item['armor']['stealth_disadvantage'])
                                        ? 'text-red-200'
                                        : 'text-emerald-200' }}">
                            {{ !empty($item['armor']['stealth_disadvantage'])
                                ? 'Disadvantage'
                                : 'Normal' }}
                        </div>

                    </div>

                </div>
            </section>

        @endif


        {{-- ============================================================
             WEAPON DETAILS
        ============================================================ --}}
        @if($isWeapon)

            <section class="overflow-hidden rounded-3xl
                            border border-red-500/20
                            bg-slate-950">

                <div class="border-b border-slate-800
                            bg-gradient-to-r from-red-950/20
                            to-slate-950 px-6 py-5">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] text-red-400">
                        Weapon Statistics
                    </p>

                    <h2 class="mt-1 text-lg font-semibold text-slate-100">
                        Combat Properties
                    </h2>

                </div>


                <div class="grid gap-4 p-6 md:grid-cols-2">

                    <div class="rounded-2xl border border-red-500/20
                                bg-red-500/[0.04] p-5">

                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.14em] text-red-400">
                            Damage
                        </p>

                        <div class="mt-2 text-2xl font-bold text-red-200">
                            {{ $item['weapon']['damage_dice'] ?? '—' }}
                        </div>

                        <div class="mt-1 text-sm text-slate-400">
                            {{ $item['weapon']['damage_type'] ?? '' }}
                        </div>

                    </div>


                    <div class="rounded-2xl border border-slate-800
                                bg-slate-900/20 p-5">

                        <p class="text-xs font-semibold uppercase
                                  tracking-[0.14em] text-slate-500">
                            Properties
                        </p>

                        <div class="mt-2 text-sm leading-6 text-slate-300">
                            {{ $item['weapon']['properties'] ?: '—' }}
                        </div>

                    </div>

                </div>
            </section>

        @endif


        {{-- ============================================================
             DESCRIPTION
        ============================================================ --}}
        <section class="rounded-3xl border border-amber-500/15
                        bg-gradient-to-br from-amber-950/10
                        to-slate-950 p-6">

            <p class="text-xs font-semibold uppercase
                      tracking-[0.16em] text-amber-400">
                Item Reference
            </p>

            <h2 class="mt-1 text-lg font-semibold text-slate-100">
                Description
            </h2>

            <div class="mt-4 whitespace-pre-line
                        text-sm leading-7 text-slate-300">
                {{ $item['description'] ?: 'No description available.' }}
            </div>

        </section>

    </div>

</x-layouts.app>
