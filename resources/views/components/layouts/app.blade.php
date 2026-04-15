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

<header class="border-b border-slate-800 bg-slate-950/80 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold tracking-tight">
            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-slate-800">🎲</span>
            <span>DM Assistant</span>
        </a>

        <nav class="flex items-center gap-2 text-sm">
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="{{ route('home') }}">Home</a>
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="{{ route('items.index') }}">Items</a>
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="{{ route('characters.index') }}">Characters</a>
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="{{ route('monsters.index') }}">Monster Manual</a>
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="{{ route('encounters.index') }}">Encounters</a>
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="{{ route('dungeons.generate') }}">Dungeon Generator</a>

            @auth
                <div x-data="{ open: false }" class="relative ml-2">
                    <button @click="open = !open"
                            class="flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 hover:bg-slate-800">
                        <span>{{ auth()->user()->name }}</span>
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <div x-show="open"
                         @click.outside="open = false"
                         class="absolute right-0 mt-2 w-48 rounded-xl border border-slate-800 bg-slate-900 shadow-lg">

                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.index') }}"
                               class="block px-4 py-2 text-sm hover:bg-slate-800">
                                Admin Dashboard
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}"
                               class="block px-4 py-2 text-sm hover:bg-slate-800">
                                Dashboard
                            </a>
                        @endif

                        <a href="{{ route('account.index') }}"
                           class="block px-4 py-2 text-sm hover:bg-slate-800">
                            Account
                        </a>

                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm hover:bg-slate-800">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="/login">Login</a>
                <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="/register">Register</a>
            @endauth
        </nav>
    </div>
</header>
<main class="mx-auto max-w-6xl px-4 py-10">
    {{ $slot }}
</main>

<footer class="border-t border-slate-800">
    <div class="mx-auto max-w-6xl px-4 py-6 text-xs text-slate-400">
        DM Assistant • Capstone Project
    </div>
</footer>
</body>
</html>
