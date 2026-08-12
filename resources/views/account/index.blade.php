<x-layouts.app title="Account & Security">

    <div class="mx-auto max-w-5xl space-y-8">

        {{-- ============================================================
             HERO
        ============================================================ --}}
        <section class="relative overflow-hidden rounded-3xl
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900
                        via-amber-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-24 -top-24
                        h-80 w-80 rounded-full
                        bg-amber-500/[0.06] blur-3xl">
            </div>

            <div class="pointer-events-none absolute right-16 -top-20
                        h-48 w-48 rounded-full
                        border border-amber-500/[0.08]">
            </div>

            <div class="relative flex flex-col gap-6
                        md:flex-row md:items-start md:justify-between">

                <div class="max-w-3xl">

                    <div class="mb-4 inline-flex items-center gap-2
                                rounded-full border border-amber-500/20
                                bg-amber-500/10 px-3 py-1
                                text-xs font-semibold uppercase
                                tracking-[0.14em] text-amber-300">

                        <svg class="h-3.5 w-3.5"
                             viewBox="0 0 24 24"
                             fill="none"
                             stroke="currentColor"
                             stroke-width="1.8">
                            <circle cx="12" cy="8" r="3"/>
                            <path d="M5 21a7 7 0 0 1 14 0"/>
                        </svg>

                        Account Settings
                    </div>

                    <h1 class="text-3xl font-bold tracking-tight
                               text-slate-50 md:text-4xl">
                        Account & Security
                    </h1>

                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-400">
                        Review your account information, update your password,
                        and manage additional sign-in protection.
                    </p>

                </div>


                @if($twoFactorConfirmed)

                    <div class="inline-flex shrink-0 items-center gap-2
                                rounded-xl border border-emerald-500/20
                                bg-emerald-500/10 px-4 py-2.5
                                text-sm font-medium text-emerald-300">

                        <span class="h-2 w-2 rounded-full bg-emerald-400"></span>
                        2FA Protected
                    </div>

                @else

                    <div class="inline-flex shrink-0 items-center gap-2
                                rounded-xl border border-slate-700
                                bg-slate-900/60 px-4 py-2.5
                                text-sm text-slate-400">

                        <span class="h-2 w-2 rounded-full bg-slate-500"></span>
                        Standard Security
                    </div>

                @endif

            </div>
        </section>


        {{-- ============================================================
             STATUS
        ============================================================ --}}
        @if(session('status'))

            <div class="flex items-center gap-3 rounded-2xl
                        border border-emerald-800/60
                        bg-emerald-950/30 px-5 py-4
                        text-sm text-emerald-200">

                <div class="flex h-8 w-8 shrink-0
                            items-center justify-center
                            rounded-full bg-emerald-500/10
                            text-emerald-300">
                    ✓
                </div>

                {{ session('status') }}

            </div>

        @endif


        {{-- ============================================================
             ERRORS
        ============================================================ --}}
        @if($errors->any())

            <div class="rounded-2xl border border-red-900
                        bg-red-950/30 p-5 text-sm text-red-200">

                <div class="font-semibold">
                    Please fix the following:
                </div>

                <ul class="mt-2 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>

        @endif


        {{-- ============================================================
             ACCOUNT OVERVIEW
        ============================================================ --}}
        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-amber-400">
                    Account
                </p>

                <h2 class="mt-1 text-2xl font-semibold
                           tracking-tight text-slate-100">
                    Profile overview
                </h2>

            </div>


            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">

                {{-- NAME --}}
                <div class="rounded-2xl border border-slate-800
                            bg-slate-950 p-5">

                    <div class="text-[10px] font-semibold uppercase
                                tracking-[0.14em] text-slate-500">
                        Name
                    </div>

                    <div class="mt-2 truncate text-lg
                                font-semibold text-slate-100">
                        {{ $user->name }}
                    </div>

                </div>


                {{-- EMAIL --}}
                <div class="rounded-2xl border border-slate-800
                            bg-slate-950 p-5">

                    <div class="text-[10px] font-semibold uppercase
                                tracking-[0.14em] text-slate-500">
                        Email
                    </div>

                    <div class="mt-2 truncate text-sm
                                font-medium text-slate-200">
                        {{ $user->email }}
                    </div>

                </div>


                {{-- ROLE --}}
                <div class="rounded-2xl border
                            {{ $user->is_admin
                                ? 'border-red-500/20 bg-red-500/[0.03]'
                                : 'border-blue-500/20 bg-blue-500/[0.03]' }}
                            p-5">

                    <div class="text-[10px] font-semibold uppercase
                                tracking-[0.14em]
                                {{ $user->is_admin
                                    ? 'text-red-400'
                                    : 'text-blue-400' }}">
                        Role
                    </div>

                    <div class="mt-2">

                        <span class="rounded-full border px-2.5 py-1
                                     text-xs font-semibold
                                     {{ $user->is_admin
                                         ? 'border-red-500/20 bg-red-500/10 text-red-300'
                                         : 'border-blue-500/20 bg-blue-500/10 text-blue-300' }}">
                            {{ $user->is_admin ? 'Administrator' : 'User' }}
                        </span>

                    </div>

                </div>


                {{-- MEMBER SINCE --}}
                <div class="rounded-2xl border border-slate-800
                            bg-slate-950 p-5">

                    <div class="text-[10px] font-semibold uppercase
                                tracking-[0.14em] text-slate-500">
                        Member Since
                    </div>

                    <div class="mt-2 text-sm font-medium text-slate-200">
                        {{ $user->created_at?->format('M j, Y') }}
                    </div>

                </div>

            </div>
        </section>


        {{-- ============================================================
             SECURITY SETTINGS
        ============================================================ --}}
        <section>

            <div class="mb-5">

                <p class="text-xs font-semibold uppercase
                          tracking-[0.16em] text-blue-400">
                    Security
                </p>

                <h2 class="mt-1 text-2xl font-semibold
                           tracking-tight text-slate-100">
                    Sign-in protection
                </h2>

                <p class="mt-1 text-sm text-slate-400">
                    Protect access to your account with a strong password
                    and two-factor authentication.
                </p>

            </div>


            <div class="grid gap-6 lg:grid-cols-[1fr_1.2fr]">

                {{-- ====================================================
                     PASSWORD
                ==================================================== --}}
                <div class="overflow-hidden rounded-3xl
                            border border-blue-500/20
                            bg-slate-950">

                    <div class="border-b border-slate-800
                                bg-gradient-to-r from-blue-950/15
                                to-slate-950 px-6 py-5">

                        <div class="flex items-center gap-4">

                            <div class="flex h-10 w-10 items-center
                                        justify-center rounded-xl
                                        border border-blue-500/20
                                        bg-blue-500/10 text-blue-300">

                                <svg class="h-5 w-5"
                                     viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <rect x="5" y="10" width="14" height="10" rx="2"/>
                                    <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                                </svg>

                            </div>

                            <div>
                                <p class="text-xs font-semibold uppercase
                                          tracking-[0.14em] text-blue-400">
                                    Password
                                </p>

                                <h3 class="mt-1 font-semibold text-slate-100">
                                    Change Password
                                </h3>
                            </div>

                        </div>
                    </div>


                    <form method="POST"
                          action="{{ route('account.password.update') }}"
                          class="grid gap-4 p-6">

                        @csrf


                        <div>
                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Current Password
                            </label>

                            <input type="password"
                                   name="current_password"
                                   autocomplete="current-password"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          focus:border-blue-500/40
                                          focus:ring-1 focus:ring-blue-500/20">
                        </div>


                        <div>
                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                New Password
                            </label>

                            <input type="password"
                                   name="password"
                                   autocomplete="new-password"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          focus:border-blue-500/40
                                          focus:ring-1 focus:ring-blue-500/20">
                        </div>


                        <div>
                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Confirm New Password
                            </label>

                            <input type="password"
                                   name="password_confirmation"
                                   autocomplete="new-password"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-sm text-slate-100
                                          outline-none transition
                                          focus:border-blue-500/40
                                          focus:ring-1 focus:ring-blue-500/20">
                        </div>


                        <div class="border-t border-slate-800 pt-5">

                            <button type="submit"
                                    class="inline-flex items-center gap-2
                                           rounded-xl bg-blue-500
                                           px-5 py-2.5
                                           text-sm font-semibold text-white
                                           transition hover:bg-blue-400">

                                Update Password
                                <span>→</span>

                            </button>

                        </div>

                    </form>
                </div>


                {{-- ====================================================
                     TWO FACTOR
                ==================================================== --}}
                <div class="overflow-hidden rounded-3xl
                            border
                            {{ $twoFactorConfirmed
                                ? 'border-emerald-500/25'
                                : 'border-violet-500/20' }}
                            bg-slate-950">

                    <div class="border-b border-slate-800
                                bg-gradient-to-r
                                {{ $twoFactorConfirmed
                                    ? 'from-emerald-950/20'
                                    : 'from-violet-950/20' }}
                                to-slate-950 px-6 py-5">

                        <div class="flex items-start justify-between gap-4">

                            <div class="flex items-center gap-4">

                                <div class="flex h-10 w-10 items-center
                                            justify-center rounded-xl border
                                            {{ $twoFactorConfirmed
                                                ? 'border-emerald-500/20 bg-emerald-500/10 text-emerald-300'
                                                : 'border-violet-500/20 bg-violet-500/10 text-violet-300' }}">

                                    <svg class="h-5 w-5"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="1.7">
                                        <path d="M12 3 5 6v5c0 4.6 2.9 8.1 7 10 4.1-1.9 7-5.4 7-10V6z"/>
                                        <path d="m9 12 2 2 4-4"/>
                                    </svg>

                                </div>


                                <div>

                                    <p class="text-xs font-semibold uppercase
                                              tracking-[0.14em]
                                              {{ $twoFactorConfirmed
                                                  ? 'text-emerald-400'
                                                  : 'text-violet-400' }}">
                                        Two-Factor Authentication
                                    </p>

                                    <h3 class="mt-1 font-semibold text-slate-100">
                                        Authenticator Protection
                                    </h3>

                                </div>

                            </div>


                            @if($twoFactorConfirmed)

                                <span class="inline-flex items-center gap-1.5
                                             rounded-full border
                                             border-emerald-500/20
                                             bg-emerald-500/10
                                             px-2.5 py-1
                                             text-[10px] font-semibold
                                             uppercase tracking-wider
                                             text-emerald-300">

                                    <span class="h-1.5 w-1.5 rounded-full
                                                 bg-emerald-400"></span>

                                    Enabled
                                </span>

                            @elseif($twoFactorEnabled)

                                <span class="rounded-full
                                             border border-amber-500/20
                                             bg-amber-500/10
                                             px-2.5 py-1
                                             text-[10px] font-semibold
                                             uppercase tracking-wider
                                             text-amber-300">
                                    Setup Required
                                </span>

                            @else

                                <span class="rounded-full
                                             border border-slate-700
                                             bg-slate-900
                                             px-2.5 py-1
                                             text-[10px] font-semibold
                                             uppercase tracking-wider
                                             text-slate-500">
                                    Disabled
                                </span>

                            @endif

                        </div>
                    </div>


                    <div class="p-6">

                        {{-- ====================================================
                             NOT ENABLED
                        ==================================================== --}}
                        @if(!$twoFactorEnabled)

                            <div>

                                <h4 class="font-semibold text-slate-200">
                                    Add another layer of account security
                                </h4>

                                <p class="mt-2 text-sm leading-6 text-slate-400">
                                    Two-factor authentication requires a temporary
                                    code from an authenticator app when signing in,
                                    even if someone knows your password.
                                </p>


                                <div class="mt-5 rounded-2xl
                                            border border-violet-500/15
                                            bg-violet-500/[0.03] p-4">

                                    <div class="grid gap-2 text-xs text-slate-400">

                                        <div class="flex items-center gap-2">
                                            <span class="text-violet-400">✓</span>
                                            Authenticator app support
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <span class="text-violet-400">✓</span>
                                            One-time sign-in codes
                                        </div>

                                        <div class="flex items-center gap-2">
                                            <span class="text-violet-400">✓</span>
                                            Emergency recovery codes
                                        </div>

                                    </div>
                                </div>


                                <form method="POST"
                                      action="/user/two-factor-authentication"
                                      class="mt-6">

                                    @csrf

                                    <button type="submit"
                                            class="inline-flex items-center gap-2
                                                   rounded-xl bg-violet-500
                                                   px-5 py-2.5
                                                   text-sm font-semibold text-white
                                                   transition hover:bg-violet-400">

                                        Enable Two-Factor Authentication
                                        <span>→</span>

                                    </button>

                                </form>

                            </div>


                            {{-- ====================================================
                                 ENABLED, NOT CONFIRMED
                            ==================================================== --}}
                        @elseif(!$twoFactorConfirmed)

                            <div>

                                <div class="rounded-2xl border
                                            border-amber-500/20
                                            bg-amber-500/[0.05] p-4">

                                    <p class="text-xs font-semibold uppercase
                                              tracking-[0.14em]
                                              text-amber-400">
                                        Setup In Progress
                                    </p>

                                    <p class="mt-2 text-sm leading-6
                                              text-slate-300">
                                        Scan the QR code with your authenticator
                                        app, then enter the six-digit code to
                                        complete setup.
                                    </p>

                                </div>


                                @if($twoFactorQrCode)

                                    <div class="mt-6">

                                        <p class="text-xs font-semibold uppercase
                                                  tracking-wide text-slate-500">
                                            Step 1 — Scan QR Code
                                        </p>

                                        <div class="mt-3 inline-block
                                                    rounded-2xl bg-white p-5
                                                    shadow-xl shadow-black/20">
                                            {!! $twoFactorQrCode !!}
                                        </div>

                                    </div>

                                @endif


                                <form method="POST"
                                      action="/user/confirmed-two-factor-authentication"
                                      class="mt-6 max-w-sm">

                                    @csrf


                                    <label class="text-xs font-medium uppercase
                                                  tracking-wide text-slate-400">
                                        Step 2 — Authentication Code
                                    </label>

                                    <input type="text"
                                           name="code"
                                           inputmode="numeric"
                                           autocomplete="one-time-code"
                                           required
                                           placeholder="000000"
                                           class="mt-2 w-full rounded-xl
                                                  border border-slate-800
                                                  bg-slate-950 px-4 py-3
                                                  font-mono text-lg
                                                  tracking-[0.2em]
                                                  text-slate-100
                                                  outline-none
                                                  placeholder:text-slate-700
                                                  focus:border-violet-500/40">


                                    <button type="submit"
                                            class="mt-4 inline-flex
                                                   items-center gap-2
                                                   rounded-xl bg-violet-500
                                                   px-5 py-2.5
                                                   text-sm font-semibold
                                                   text-white transition
                                                   hover:bg-violet-400">

                                        Confirm Setup
                                        <span>→</span>

                                    </button>

                                </form>


                                <form method="POST"
                                      action="/user/two-factor-authentication"
                                      class="mt-4">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-sm text-red-400
                                                   transition
                                                   hover:text-red-300">
                                        Cancel Setup
                                    </button>

                                </form>

                            </div>


                            {{-- ====================================================
                                 FULLY ENABLED
                            ==================================================== --}}
                        @else

                            <div>

                                <div class="rounded-2xl border
                                            border-emerald-500/20
                                            bg-emerald-500/[0.05] p-4">

                                    <div class="flex items-start gap-3">

                                        <div class="mt-0.5 text-emerald-400">
                                            ✓
                                        </div>

                                        <div>

                                            <p class="font-semibold
                                                      text-emerald-300">
                                                Two-factor authentication is active
                                            </p>

                                            <p class="mt-1 text-sm leading-6
                                                      text-slate-400">
                                                An authenticator code is required
                                                when signing in to your account.
                                            </p>

                                        </div>

                                    </div>
                                </div>


                                {{-- ====================================================
                                     RECOVERY CODES
                                ==================================================== --}}
                                @if(count($recoveryCodes))

                                    <div class="mt-6">

                                        <div class="flex flex-col gap-3
                                                    sm:flex-row
                                                    sm:items-start
                                                    sm:justify-between">

                                            <div>

                                                <p class="text-xs font-semibold
                                                          uppercase
                                                          tracking-[0.14em]
                                                          text-amber-400">
                                                    Emergency Access
                                                </p>

                                                <h4 class="mt-1 font-semibold
                                                           text-slate-200">
                                                    Recovery Codes
                                                </h4>

                                                <p class="mt-1 max-w-lg
                                                          text-sm leading-6
                                                          text-slate-500">
                                                    Keep these codes somewhere
                                                    secure. Each can be used once
                                                    if you lose access to your
                                                    authenticator.
                                                </p>

                                            </div>

                                        </div>


                                        <div class="mt-4 grid gap-2
                                                    rounded-2xl
                                                    border border-amber-500/15
                                                    bg-slate-900/50 p-4
                                                    font-mono text-sm
                                                    text-slate-300
                                                    sm:grid-cols-2">

                                            @foreach($recoveryCodes as $code)

                                                <div class="rounded-lg
                                                            bg-slate-950
                                                            px-3 py-2">
                                                    {{ $code }}
                                                </div>

                                            @endforeach

                                        </div>


                                        <form method="POST"
                                              action="/user/two-factor-recovery-codes"
                                              class="mt-4">

                                            @csrf

                                            <button type="submit"
                                                    class="rounded-xl
                                                           border border-slate-700
                                                           bg-slate-900
                                                           px-4 py-2
                                                           text-sm text-slate-300
                                                           transition
                                                           hover:border-amber-500/30
                                                           hover:bg-slate-800">
                                                Generate New Recovery Codes
                                            </button>

                                        </form>

                                    </div>

                                @endif


                                {{-- ====================================================
                                     DISABLE
                                ==================================================== --}}
                                <div class="mt-6 border-t
                                            border-slate-800 pt-5">

                                    <p class="text-xs font-semibold uppercase
                                              tracking-[0.14em]
                                              text-red-400">
                                        Disable Protection
                                    </p>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Removing two-factor authentication will
                                        return your account to password-only login.
                                    </p>


                                    <form method="POST"
                                          action="/user/two-factor-authentication"
                                          class="mt-4">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="rounded-xl
                                                       border border-red-500/30
                                                       bg-red-500/[0.05]
                                                       px-4 py-2.5
                                                       text-sm font-medium
                                                       text-red-300 transition
                                                       hover:bg-red-500/10">
                                            Disable Two-Factor Authentication
                                        </button>

                                    </form>

                                </div>

                            </div>

                        @endif

                    </div>
                </div>

            </div>
        </section>

    </div>

</x-layouts.app>
