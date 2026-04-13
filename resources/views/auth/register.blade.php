<x-layouts.app title="Register">
    <div class="mx-auto max-w-md rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <h1 class="text-2xl font-semibold tracking-tight">Create Account</h1>
        <p class="mt-1 text-sm text-slate-400">Register for DM Assistant.</p>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-900 bg-red-950/30 p-3 text-sm text-red-200">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/register" class="mt-6 grid gap-4">
            @csrf

            <div>
                <label class="text-xs text-slate-400">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
            </div>

            <div>
                <label class="text-xs text-slate-400">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
            </div>

            <div>
                <label class="text-xs text-slate-400">Password</label>
                <input type="password" name="password" required
                       class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
            </div>

            <div>
                <label class="text-xs text-slate-400">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                       class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
            </div>

            <button type="submit"
                    class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                Register
            </button>

            <div class="text-sm text-slate-400">
                Already have an account?
                <a href="/login" class="hover:text-white">Login</a>
            </div>
        </form>
    </div>
</x-layouts.app>
