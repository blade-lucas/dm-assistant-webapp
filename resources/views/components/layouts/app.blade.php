<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'DM Assistant' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>


<body class="min-h-screen bg-slate-950 text-slate-100">

{{-- ============================================================
     SITE HEADER
============================================================ --}}
<header class="relative z-50 border-b border-slate-800/80
                   bg-slate-950/90 shadow-lg shadow-black/10
                   backdrop-blur-xl">

    {{-- subtle top accent --}}
    <div class="absolute inset-x-0 top-0 h-px
                    bg-gradient-to-r from-transparent
                    via-amber-400/40 to-transparent">
    </div>


    <div class="mx-auto flex max-w-6xl items-center
                    justify-between px-4 py-3.5">

        {{-- ========================================================
             BRAND
        ======================================================== --}}
        <a href="{{ route('home') }}"
           class="group flex items-center gap-3">

            <div class="relative flex h-10 w-10 items-center
                            justify-center rounded-xl
                            border border-amber-500/20
                            bg-gradient-to-br from-amber-500/15
                            to-slate-900 text-amber-300
                            shadow-lg shadow-black/20
                            transition
                            group-hover:border-amber-500/40
                            group-hover:bg-amber-500/20">

                <svg class="h-5 w-5"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.7">

                    <path d="M12 3 4 7v10l8 4 8-4V7l-8-4Z"/>
                    <path d="m4 7 8 4 8-4"/>
                    <path d="M12 11v10"/>

                </svg>

            </div>


            <div class="hidden sm:block">

                <div class="text-sm font-semibold tracking-tight
                                text-slate-100 transition
                                group-hover:text-amber-200">
                    DM Assistant
                </div>

                <div class="text-[10px] font-medium uppercase
                                tracking-[0.14em] text-slate-500">
                    Dungeon Master Workspace
                </div>

            </div>

        </a>


        {{-- ========================================================
             NAVIGATION
        ======================================================== --}}
        <nav class="flex items-center gap-1 text-sm">

            {{-- HOME --}}
            <a href="{{ route('home') }}"
               class="rounded-lg px-3 py-2
                          transition
                          {{ request()->routeIs('home')
                              ? 'bg-amber-500/10 text-amber-300'
                              : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                Home
            </a>


            {{-- CAMPAIGNS --}}
            <a href="{{ route('campaigns.index') }}"
               class="rounded-lg px-3 py-2
                          transition
                          {{ request()->routeIs('campaigns.*')
                              ? 'bg-amber-500/10 text-amber-300'
                              : 'text-slate-300 hover:bg-slate-900 hover:text-white' }}">
                Campaigns
            </a>


            {{-- ====================================================
                 CREATE DROPDOWN
            ==================================================== --}}
            <div x-data="{ open: false }" class="relative">

                <button @click="open = !open"
                        :class="open
                                ? 'bg-slate-900 text-white'
                                : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                        class="flex items-center gap-2
                                   rounded-lg px-3 py-2
                                   transition">

                    <span>Create</span>

                    <svg class="h-4 w-4 transition-transform duration-200"
                         :class="open ? 'rotate-180' : ''"
                         viewBox="0 0 20 20"
                         fill="currentColor">

                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>

                    </svg>

                </button>


                <div x-show="open"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     @click.outside="open = false"
                     class="absolute left-0 z-50 mt-2 w-64
                                overflow-hidden rounded-2xl
                                border border-slate-700/80
                                bg-slate-900/95
                                p-2 shadow-2xl shadow-black/30
                                backdrop-blur-xl">


                    {{-- Characters --}}
                    <a href="{{ route('characters.index') }}"
                       class="group flex items-center gap-3
                                  rounded-xl px-3 py-3
                                  transition hover:bg-slate-800">

                        <div class="flex h-9 w-9 shrink-0 items-center
                                        justify-center rounded-lg
                                        bg-blue-500/10 text-blue-300">

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <circle cx="12" cy="8" r="3"/>
                                <path d="M5 21a7 7 0 0 1 14 0"/>
                            </svg>

                        </div>

                        <div>
                            <div class="text-sm font-medium text-slate-200">
                                Characters / NPCs
                            </div>

                            <div class="text-xs text-slate-500">
                                Build and manage characters
                            </div>
                        </div>

                    </a>


                    {{-- Encounters --}}
                    <a href="{{ route('encounters.index') }}"
                       class="group flex items-center gap-3
                                  rounded-xl px-3 py-3
                                  transition hover:bg-slate-800">

                        <div class="flex h-9 w-9 shrink-0 items-center
                                        justify-center rounded-lg
                                        bg-violet-500/10 text-violet-300">

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <path d="M7 4 17 20"/>
                                <path d="M17 4 7 20"/>
                            </svg>

                        </div>

                        <div>
                            <div class="text-sm font-medium text-slate-200">
                                Encounter Tables
                            </div>

                            <div class="text-xs text-slate-500">
                                Manual and AI encounters
                            </div>
                        </div>

                    </a>


                    {{-- Procedural Dungeon --}}
                    <a href="{{ route('dungeon-new.create') }}"
                       class="group flex items-center gap-3
                                  rounded-xl px-3 py-3
                                  transition hover:bg-slate-800">

                        <div class="flex h-9 w-9 shrink-0 items-center
                                        justify-center rounded-lg
                                        bg-emerald-500/10 text-emerald-300">

                            <svg class="h-4 w-4"
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

                        <div>
                            <div class="text-sm font-medium text-slate-200">
                                Dungeon Generator
                            </div>

                            <div class="text-xs text-slate-500">
                                Editable procedural layouts
                            </div>
                        </div>

                    </a>


                    {{-- AI Map --}}
                    <a href="{{ route('dungeons.generate') }}"
                       class="group flex items-center gap-3
                                  rounded-xl px-3 py-3
                                  transition hover:bg-slate-800">

                        <div class="flex h-9 w-9 shrink-0 items-center
                                        justify-center rounded-lg
                                        bg-indigo-500/10 text-indigo-300">

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <path d="M3 6h18v12H3z"/>
                                <path d="m7 14 3-3 2 2 2-2 3 3"/>
                            </svg>

                        </div>

                        <div>
                            <div class="text-sm font-medium text-slate-200">
                                Map Generator
                            </div>

                            <div class="text-xs text-slate-500">
                                AI map generation
                            </div>
                        </div>

                    </a>

                </div>
            </div>


            {{-- ====================================================
                 REPOSITORY DROPDOWN
            ==================================================== --}}
            <div x-data="{ open: false }" class="relative">

                <button @click="open = !open"
                        :class="open
                                ? 'bg-slate-900 text-white'
                                : 'text-slate-300 hover:bg-slate-900 hover:text-white'"
                        class="flex items-center gap-2
                                   rounded-lg px-3 py-2
                                   transition">

                    <span>Repository</span>

                    <svg class="h-4 w-4 transition-transform duration-200"
                         :class="open ? 'rotate-180' : ''"
                         viewBox="0 0 20 20"
                         fill="currentColor">

                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd"/>

                    </svg>

                </button>


                <div x-show="open"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     @click.outside="open = false"
                     class="absolute left-0 z-50 mt-2 w-64
                                overflow-hidden rounded-2xl
                                border border-slate-700/80
                                bg-slate-900/95
                                p-2 shadow-2xl shadow-black/30
                                backdrop-blur-xl">


                    {{-- Monster Manual --}}
                    <a href="{{ route('monsters.index') }}"
                       class="flex items-center gap-3
                                  rounded-xl px-3 py-3
                                  transition hover:bg-slate-800">

                        <div class="flex h-9 w-9 shrink-0 items-center
                                        justify-center rounded-lg
                                        bg-red-500/10 text-red-300">

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <circle cx="12" cy="12" r="8"/>
                                <path d="M9 10h.01"/>
                                <path d="M15 10h.01"/>
                            </svg>

                        </div>

                        <div>
                            <div class="text-sm font-medium text-slate-200">
                                Monster Manual
                            </div>

                            <div class="text-xs text-slate-500">
                                Creature database
                            </div>
                        </div>

                    </a>


                    {{-- Item Catalogue --}}
                    <a href="{{ route('items.index') }}"
                       class="flex items-center gap-3
                                  rounded-xl px-3 py-3
                                  transition hover:bg-slate-800">

                        <div class="flex h-9 w-9 shrink-0 items-center
                                        justify-center rounded-lg
                                        bg-amber-500/10 text-amber-300">

                            <svg class="h-4 w-4"
                                 viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.7">
                                <path d="m14.5 4.5 5 5"/>
                                <path d="M4 20 20 4"/>
                            </svg>

                        </div>

                        <div>
                            <div class="text-sm font-medium text-slate-200">
                                Item Catalogue
                            </div>

                            <div class="text-xs text-slate-500">
                                Weapons, equipment, and loot
                            </div>
                        </div>

                    </a>

                </div>
            </div>


            {{-- ====================================================
                 ACCOUNT DROPDOWN
            ==================================================== --}}
            @auth

                <div x-data="{ open: false }"
                     class="relative ml-2">

                    <button @click="open = !open"
                            class="flex items-center gap-2
                                       rounded-xl border
                                       border-amber-500/20
                                       bg-amber-500/[0.06]
                                       px-3 py-2
                                       text-slate-200
                                       transition
                                       hover:border-amber-500/30
                                       hover:bg-amber-500/10">

                        <div class="flex h-6 w-6 items-center
                                        justify-center rounded-full
                                        bg-amber-500/15
                                        text-[10px] font-bold
                                        uppercase text-amber-300">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <span class="hidden lg:inline">
                                {{ auth()->user()->name }}
                            </span>

                        <svg class="h-4 w-4 transition-transform duration-200"
                             :class="open ? 'rotate-180' : ''"
                             viewBox="0 0 20 20"
                             fill="currentColor">

                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>

                        </svg>

                    </button>


                    <div x-show="open"
                         x-transition
                         @click.outside="open = false"
                         class="absolute right-0 z-50 mt-2
                                    w-56 overflow-hidden
                                    rounded-2xl border
                                    border-slate-700/80
                                    bg-slate-900/95
                                    p-2 shadow-2xl
                                    shadow-black/30
                                    backdrop-blur-xl">


                        @if(auth()->user()->is_admin)

                            <a href="{{ route('admin.index') }}"
                               class="block rounded-xl px-3 py-2.5
                                          text-sm text-slate-300
                                          transition hover:bg-slate-800
                                          hover:text-white">
                                Admin Dashboard
                            </a>

                        @else

                            <a href="{{ route('dashboard') }}"
                               class="block rounded-xl px-3 py-2.5
                                          text-sm text-slate-300
                                          transition hover:bg-slate-800
                                          hover:text-white">
                                Dashboard
                            </a>

                        @endif


                        <a href="{{ route('account.index') }}"
                           class="block rounded-xl px-3 py-2.5
                                      text-sm text-slate-300
                                      transition hover:bg-slate-800
                                      hover:text-white">
                            Account & Security
                        </a>


                        <div class="my-2 border-t border-slate-800"></div>


                        <form method="POST" action="/logout">
                            @csrf

                            <button type="submit"
                                    class="w-full rounded-xl
                                               px-3 py-2.5 text-left
                                               text-sm text-slate-400
                                               transition
                                               hover:bg-red-950/20
                                               hover:text-red-300">
                                Logout
                            </button>
                        </form>

                    </div>

                </div>


            @else

                <a href="/login"
                   class="rounded-lg px-3 py-2
                              text-slate-300 transition
                              hover:bg-slate-900
                              hover:text-white">
                    Login
                </a>

                <a href="/register"
                   class="rounded-xl bg-amber-400
                              px-4 py-2 text-sm
                              font-semibold text-slate-950
                              transition hover:bg-amber-300">
                    Register
                </a>

            @endauth

        </nav>
    </div>
</header>


{{-- ============================================================
     PAGE CONTENT
============================================================ --}}
<main class="relative z-0 mx-auto
                 max-w-6xl px-4 py-10">
    {{ $slot }}
</main>


{{-- ============================================================
     FOOTER
============================================================ --}}
<footer class="mt-8 border-t border-slate-800/80
                   bg-slate-950">

    <div class="mx-auto flex max-w-6xl
                    flex-col gap-3 px-4 py-7
                    sm:flex-row sm:items-center
                    sm:justify-between">

        <div class="flex items-center gap-2">

            <div class="flex h-7 w-7 items-center
                            justify-center rounded-lg
                            border border-amber-500/20
                            bg-amber-500/10 text-amber-300">

                <svg class="h-3.5 w-3.5"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.7">
                    <path d="M12 3 4 7v10l8 4 8-4V7l-8-4Z"/>
                </svg>

            </div>

            <div>
                <div class="text-xs font-medium text-slate-300">
                    DM Assistant
                </div>

                <div class="text-[10px] text-slate-600">
                    Dungeon Master Campaign Workspace
                </div>
            </div>

        </div>


        <div class="text-xs text-slate-600">
            Capstone Project
        </div>

    </div>
</footer>

</body>
</html>
