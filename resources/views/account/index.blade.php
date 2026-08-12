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
        <div class="mt-6 rounded-2xl border border-slate-800 bg-slate-950 p-6">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <h2 class="text-lg font-semibold">
                        Two-Factor Authentication
                    </h2>

                    <p class="mt-1 text-sm text-slate-400">
                        Add an authenticator app as an additional layer of security
                        when signing in to your account.
                    </p>
                </div>

                @if($twoFactorConfirmed)
                    <span class="rounded-full border border-emerald-800 bg-emerald-950/30 px-3 py-1 text-xs font-medium text-emerald-300">
                Enabled
            </span>
                @else
                    <span class="rounded-full border border-slate-700 px-3 py-1 text-xs font-medium text-slate-400">
                Disabled
            </span>
                @endif
            </div>

            @if(!$twoFactorEnabled)

                <div class="mt-5">
                    <form method="POST" action="/user/two-factor-authentication">
                        @csrf

                        <button type="submit"
                                class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                            Enable Two-Factor Authentication
                        </button>
                    </form>
                </div>

            @elseif(!$twoFactorConfirmed)

                <div class="mt-6">
                    <h3 class="font-medium text-slate-200">
                        Finish Setup
                    </h3>

                    <p class="mt-1 text-sm text-slate-400">
                        Scan this QR code with an authenticator app, then enter the
                        six-digit code below.
                    </p>

                    @if($twoFactorQrCode)
                        <div class="mt-4 inline-block rounded-xl bg-white p-4">
                            {!! $twoFactorQrCode !!}
                        </div>
                    @endif

                    <form method="POST"
                          action="/user/confirmed-two-factor-authentication"
                          class="mt-5 max-w-sm">
                        @csrf

                        <label class="text-xs text-slate-400">
                            Authentication Code
                        </label>

                        <input type="text"
                               name="code"
                               inputmode="numeric"
                               autocomplete="one-time-code"
                               required
                               class="mt-1 w-full rounded-xl border border-slate-800 bg-slate-950 px-3 py-2 text-sm">

                        <button type="submit"
                                class="mt-4 rounded-xl bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                            Confirm Two-Factor Authentication
                        </button>
                    </form>

                    <form method="POST"
                          action="/user/two-factor-authentication"
                          class="mt-3">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="text-sm text-red-400 hover:text-red-300">
                            Cancel Setup
                        </button>
                    </form>
                </div>

            @else

                <div class="mt-6">
                    <p class="text-sm text-slate-300">
                        Two-factor authentication is protecting your account.
                        You'll be asked for an authenticator code when signing in.
                    </p>

                    @if(count($recoveryCodes))
                        <div class="mt-5">
                            <h3 class="font-medium text-slate-200">
                                Recovery Codes
                            </h3>

                            <p class="mt-1 text-sm text-slate-400">
                                Store these somewhere safe. Each code can be used
                                if you lose access to your authenticator.
                            </p>

                            <div class="mt-3 grid gap-1 rounded-xl border border-slate-800 bg-slate-900 p-4 font-mono text-sm text-slate-300 sm:grid-cols-2">
                                @foreach($recoveryCodes as $code)
                                    <div>{{ $code }}</div>
                                @endforeach
                            </div>

                            <form method="POST"
                                  action="/user/two-factor-recovery-codes"
                                  class="mt-3">
                                @csrf

                                <button type="submit"
                                        class="rounded-xl border border-slate-700 px-4 py-2 text-sm hover:bg-slate-900">
                                    Generate New Recovery Codes
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="mt-6 border-t border-slate-800 pt-5">
                        <form method="POST"
                              action="/user/two-factor-authentication">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="rounded-xl border border-red-900 px-4 py-2 text-sm text-red-300 hover:bg-red-950/30">
                                Disable Two-Factor Authentication
                            </button>
                        </form>
                    </div>
                </div>

            @endif
        </div>
    </div>
</x-layouts.app>
