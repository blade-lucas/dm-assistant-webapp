<x-layouts.app title="Account">
    <div class="mx-auto max-w-4xl">
        <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <h1 class="text-2xl font-semibold tracking-tight">Account</h1>
            <p class="mt-1 text-sm text-slate-400">
                View your account information and manage your password.
            </p>
        </div>

        @if(session('status'))
            <div class="mt-4 rounded-2xl border border-emerald-900 bg-emerald-950/30 p-4 text-sm text-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mt-4 rounded-2xl border border-red-900 bg-red-950/30 p-4 text-sm text-red-200">
                <div class="font-semibold">Please fix the following:</div>
                <ul class="mt-2 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                <h2 class="text-lg font-semibold">Account Info</h2>

                <div class="mt-4 grid gap-3 text-sm text-slate-300">
                    <div>
                        <div class="text-xs uppercase tracking-wide text-slate-500">Name</div>
                        <div class="mt-1">{{ $user->name }}</div>
                    </div>

                    <div>
                        <div class="text-xs uppercase tracking-wide text-slate-500">Email</div>
                        <div class="mt-1">{{ $user->email }}</div>
                    </div>

                    <div>
                        <div class="text-xs uppercase tracking-wide text-slate-500">Role</div>
                        <div class="mt-1">{{ $user->is_admin ? 'Admin' : 'User' }}</div>
                    </div>

                    <div>
                        <div class="text-xs uppercase tracking-wide text-slate-500">Member Since</div>
                        <div class="mt-1">{{ $user->created_at?->format('Y-m-d H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-slate-800 bg-slate-950 p-6">
                <h2 class="text-lg font-semibold">Change Password</h2>

                <form method="POST" action="{{ route('account.password.update') }}" class="mt-4 grid gap-4">
                    @csrf

                    <div>
                        <label class="text-xs text-slate-400">Current Password</label>
                        <input type="password" name="current_password"
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">New Password</label>
                        <input type="password" name="password"
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    </div>

                    <div>
                        <label class="text-xs text-slate-400">Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                                class="rounded-xl bg-slate-100 px-4 py-2 text-sm font-medium text-slate-900 hover:bg-white">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
