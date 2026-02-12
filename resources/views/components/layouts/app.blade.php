<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'DM Assistant' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="/rules">Rules</a>
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="/characters">Characters</a>
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="/monsters">Monsters</a>
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="/encounters">Encounters</a>
            <a class="rounded-lg px-3 py-2 hover:bg-slate-900" href="/maps">Maps</a>
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
