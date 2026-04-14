<x-layouts.app title="Login">
    <div class="mx-auto max-w-md rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <h1 class="text-2xl font-semibold tracking-tight">Login</h1>
        <p class="mt-1 text-sm text-slate-400">Access your DM Assistant account.</p>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-900 bg-red-950/30 p-3 text-sm text-red-200">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="mt-4 rounded-xl border border-slate-800 bg-slate-900 p-3 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="/login" class="mt-6 grid gap-4">
            @csrf

            <div>
                <label class="text-xs text-slate-400">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
            </div>

            <div>
                <label class="text-xs text-slate-400">Password</label>
                <input type="password" name="password" required
                       class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember">
                Remember me
            </label>

            <button type="submit"
                    class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                Login
            </button>

            <div class="flex justify-between text-sm text-slate-400">
                <a href="/register" class="hover:text-white">Create account</a>
                <a href="/forgot-password" class="hover:text-white">Forgot password?</a>
            </div>
        </form>
    </div>
</x-layouts.app>
