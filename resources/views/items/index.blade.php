<x-layouts.app title="Item Library">

    <div class="mx-auto max-w-6xl space-y-8">

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

            <div class="pointer-events-none absolute right-16 -top-20
                        h-48 w-48 rounded-full
                        border border-amber-500/[0.08]">
            </div>

            <div class="relative max-w-3xl">

                <div class="mb-4 inline-flex items-center gap-2
                            rounded-full border border-amber-500/20
                            bg-amber-500/10 px-3 py-1
                            text-xs font-semibold uppercase
                            tracking-[0.14em] text-amber-300">

                    <svg class="h-3.5 w-3.5"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path d="m14.5 4.5 5 5"/>
                        <path d="M4 20 20 4"/>
                        <path d="m4.5 9.5 5-5"/>
                    </svg>

                    Equipment Repository
                </div>

                <h1 class="text-3xl font-bold tracking-tight
                           text-slate-50 md:text-4xl">
                    Item Library
                </h1>

                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                    Browse weapons, armor, adventuring gear, and other useful
                    equipment for your characters and campaigns.
                </p>

                <div class="mt-6 flex flex-wrap gap-2">

                    <span class="rounded-full border border-amber-500/20
                                 bg-amber-500/[0.06]
                                 px-3 py-1.5 text-xs text-amber-300">
                        Weapons
                    </span>

                    <span class="rounded-full border border-blue-500/20
                                 bg-blue-500/[0.06]
                                 px-3 py-1.5 text-xs text-blue-300">
                        Armor
                    </span>

                    <span class="rounded-full border border-slate-700
                                 bg-slate-900/60
                                 px-3 py-1.5 text-xs text-slate-400">
                        Adventuring Gear
                    </span>

                </div>

            </div>
        </section>


        {{-- ============================================================
             SEARCH / FILTERS
        ============================================================ --}}
        <section class="overflow-hidden rounded-3xl
                        border border-slate-800 bg-slate-950">

            <div class="border-b border-slate-800 px-6 py-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-amber-400">
                    Browse Equipment
                </p>

                <h2 class="mt-1 text-lg font-semibold text-slate-100">
                    Find an item
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Search directly or narrow the library by category.
                </p>

            </div>


            <form method="GET"
                  action="{{ route('items.index') }}"
                  class="grid gap-4 p-6 md:grid-cols-12">

                <div class="md:col-span-8">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Search
                    </label>

                    <input name="q"
                           value="{{ $q }}"
                           placeholder="Longsword, plate armor, backpack..."
                           class="mt-2 w-full rounded-xl
                                  border border-slate-800
                                  bg-slate-950 px-4 py-3
                                  text-sm text-slate-100
                                  outline-none transition
                                  placeholder:text-slate-600
                                  focus:border-amber-500/40
                                  focus:ring-1 focus:ring-amber-500/20">

                </div>


                <div class="md:col-span-4">

                    <label class="text-xs font-medium uppercase
                                  tracking-wide text-slate-400">
                        Category
                    </label>

                    <select name="category"
                            class="mt-2 w-full rounded-xl
                                   border border-slate-800
                                   bg-slate-950 px-4 py-3
                                   text-sm text-slate-100
                                   outline-none transition
                                   focus:border-amber-500/40">

                        <option value="">All Categories</option>

                        @foreach($categories as $cat)
                            <option value="{{ $cat }}"
                                @selected($category === $cat)>
                                {{ ucfirst($cat) }}
                            </option>
                        @endforeach

                    </select>

                </div>


                <div class="md:col-span-12 flex flex-wrap
                            items-center gap-2
                            border-t border-slate-800 pt-5">

                    <button type="submit"
                            class="rounded-xl bg-amber-400
                                   px-5 py-2.5 text-sm
                                   font-semibold text-slate-950
                                   transition hover:bg-amber-300">
                        Search Items
                    </button>

                    <a href="{{ route('items.index') }}"
                       class="rounded-xl border border-slate-700
                              px-4 py-2.5 text-sm text-slate-400
                              transition hover:bg-slate-900
                              hover:text-white">
                        Reset
                    </a>

                    <div class="ml-auto text-xs text-slate-500">
                        {{ count($items) }} items shown
                    </div>

                </div>

            </form>
        </section>


        {{-- ============================================================
             ITEM LIST
        ============================================================ --}}
        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-amber-400">
                    Repository
                </p>

                <h2 class="mt-1 text-2xl font-semibold
                           tracking-tight text-slate-100">
                    Available equipment
                </h2>

            </div>


            <div class="grid gap-4 md:grid-cols-2">

                @forelse($items as $item)

                    @php
                        $categoryName = strtolower($item['category'] ?? '');

                        $categoryClasses = match($categoryName) {
                            'weapon', 'weapons'
                                => 'border-red-500/20 bg-red-500/[0.06] text-red-300',

                            'armor', 'armour'
                                => 'border-blue-500/20 bg-blue-500/[0.06] text-blue-300',

                            default
                                => 'border-amber-500/20 bg-amber-500/[0.06] text-amber-300',
                        };
                    @endphp


                    <a href="{{ route('items.show', $item['id']) }}"
                       class="group relative overflow-hidden
                              rounded-2xl border border-slate-800
                              bg-slate-950 p-5
                              transition duration-200
                              hover:-translate-y-0.5
                              hover:border-amber-500/30
                              hover:bg-slate-900/40">

                        <div class="absolute inset-y-0 left-0
                                    w-1 bg-amber-400
                                    opacity-0 transition
                                    group-hover:opacity-100">
                        </div>


                        <div class="flex items-start justify-between gap-5">

                            <div class="flex min-w-0 gap-4">

                                <div class="flex h-11 w-11 shrink-0
                                            items-center justify-center
                                            rounded-xl
                                            border border-amber-500/20
                                            bg-amber-500/10
                                            text-amber-300">

                                    <svg class="h-5 w-5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.7">
                                        <path d="m14.5 4.5 5 5"/>
                                        <path d="M4 20 20 4"/>
                                    </svg>

                                </div>


                                <div class="min-w-0">

                                    <h3 class="truncate text-lg font-semibold
                                               text-slate-100 transition
                                               group-hover:text-amber-200">
                                        {{ $item['name'] }}
                                    </h3>


                                    <div class="mt-2 flex flex-wrap gap-2">

                                        <span class="rounded-full border
                                                     px-2.5 py-1 text-[10px]
                                                     font-semibold uppercase
                                                     tracking-wider
                                                     {{ $categoryClasses }}">
                                            {{ ucfirst($item['category']) }}
                                        </span>

                                        @if(!empty($item['type']))
                                            <span class="rounded-full
                                                         border border-slate-700
                                                         bg-slate-900
                                                         px-2.5 py-1
                                                         text-[10px]
                                                         text-slate-400">
                                                {{ $item['type'] }}
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>


                            <span class="mt-1 text-slate-600 transition
                                         group-hover:translate-x-1
                                         group-hover:text-amber-300">
                                →
                            </span>

                        </div>


                        <div class="mt-5 flex flex-wrap items-center
                                    gap-x-5 gap-y-2
                                    border-t border-slate-800/70
                                    pt-4 text-xs text-slate-500">

                            <span class="flex items-center gap-1.5">
                                <span class="text-amber-400">◈</span>

                                {{ $item['cost_number'] }}
                                {{ strtoupper($item['cost_currency']) }}
                            </span>


                            @if(!is_null($item['weight']))
                                <span>
                                    Weight:
                                    <span class="text-slate-300">
                                        {{ $item['weight'] }}
                                    </span>
                                </span>
                            @endif

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
                                    border border-amber-500/20
                                    bg-amber-500/10
                                    text-amber-300">
                            ◈
                        </div>

                        <h3 class="mt-5 text-lg font-semibold
                                   text-slate-100">
                            No items found
                        </h3>

                        <p class="mx-auto mt-2 max-w-md
                                  text-sm leading-6 text-slate-400">
                            Try adjusting your search or selecting another
                            item category.
                        </p>

                    </div>

                @endforelse

            </div>
        </section>

    </div>

</x-layouts.app>
