<x-layouts.app title="Two-Factor Challenge">
    <div class="mx-auto max-w-md rounded-2xl border border-slate-800 bg-slate-950 p-6">
        <h1 class="text-2xl font-semibold tracking-tight">Two-Factor Authentication</h1>
        <p class="mt-1 text-sm text-slate-400">
            Enter your authentication code or one of your recovery codes.
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

        <div x-data="{ recovery: false }" class="mt-6">
            <form method="POST" action="/two-factor-challenge" class="grid gap-4">
                @csrf

                <div x-show="!recovery">
                    <label class="text-xs text-slate-400">Authentication Code</label>
                    <input type="text" name="code" inputmode="numeric" autocomplete="one-time-code"
                           class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                </div>

                <div x-show="recovery">
                    <label class="text-xs text-slate-400">Recovery Code</label>
                    <input type="text" name="recovery_code"
                           class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                </div>

                <button type="submit"
                        class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                    Continue
                </button>
            </form>

            <button type="button"
                    @click="recovery = !recovery"
                    class="mt-4 text-sm text-slate-400 hover:text-white">
                <span x-show="!recovery">Use a recovery code</span>
                <span x-show="recovery">Use an authentication code</span>
            </button>
        </div>
    </div>
</x-layouts.app>
