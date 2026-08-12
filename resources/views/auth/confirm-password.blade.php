<x-layouts.app title="Confirm Password">
    <div class="mx-auto max-w-md rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <h1 class="text-2xl font-semibold tracking-tight">
            Confirm Password
        </h1>

        <p class="mt-1 text-sm text-slate-400">
            For security, please confirm your password before continuing.
        </p>

        @if ($errors->any())
            <div class="mt-4 rounded-xl border border-red-900 bg-red-950/30 p-3 text-sm text-red-200">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="/user/confirm-password"
              class="mt-6 grid gap-4">
            @csrf

            <div>
                <label class="text-xs text-slate-400">
                    Password
                </label>

                <input type="password"
                       name="password"
                       required
                       autofocus
                       autocomplete="current-password"
                       class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
            </div>

            <button type="submit"
                    class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                Confirm Password
            </button>
        </form>
    </div>
</x-layouts.app>
