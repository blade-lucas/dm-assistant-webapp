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
                <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="{{ route('dashboard') }}">Dashboard</a>

                @if(auth()->user()->is_admin)
                    <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="{{ route('admin.index') }}">Admin</a>
                @endif

                <form method="POST" action="/logout" class="inline">
                    @csrf
                    <button type="submit" class="rounded-lg px-3 py-2 hover:bg-slate-900">
                        Logout
                    </button>
                </form>
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
