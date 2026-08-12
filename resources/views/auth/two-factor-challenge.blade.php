<x-layouts.app title="Two-Factor Authentication">

    <div class="mx-auto max-w-md">

        <section class="relative overflow-hidden rounded-3xl
                        border border-violet-500/20
                        bg-gradient-to-br from-slate-900
                        via-violet-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-20 -top-20
                        h-56 w-56 rounded-full
                        bg-violet-500/[0.06] blur-3xl">
            </div>

            <div class="relative">

                <div class="mx-auto flex h-14 w-14 items-center
                            justify-center rounded-2xl
                            border border-violet-500/20
                            bg-violet-500/10 text-violet-300">

                    <svg class="h-7 w-7"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.7">
                        <path d="M12 3 5 6v5c0 4.6 2.9 8.1 7 10 4.1-1.9 7-5.4 7-10V6z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>

                </div>


                <div class="mt-5 text-center">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] text-violet-400">
                        Additional Verification
                    </p>

                    <h1 class="mt-2 text-3xl font-bold
                               tracking-tight text-slate-50">
                        Two-Factor Authentication
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        Your password was accepted. Enter the code from your
                        authenticator app to finish signing in.
                    </p>

                </div>


                @if ($errors->any())

                    <div class="mt-6 rounded-2xl border border-red-900
                                bg-red-950/30 p-4
                                text-sm text-red-200">

                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                @endif


                <div x-data="{ recovery: false }"
                     class="mt-7">

                    <form method="POST"
                          action="/two-factor-challenge"
                          class="grid gap-5">

                        @csrf


                        {{-- AUTHENTICATOR MODE --}}
                        <div x-show="!recovery">

                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Authentication Code
                            </label>

                            <input type="text"
                                   name="code"
                                   inputmode="numeric"
                                   autocomplete="one-time-code"
                                   placeholder="000000"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          text-center font-mono
                                          text-xl tracking-[0.25em]
                                          text-slate-100
                                          outline-none transition
                                          placeholder:text-slate-700
                                          focus:border-violet-500/40
                                          focus:ring-1
                                          focus:ring-violet-500/20">

                            <p class="mt-2 text-center text-xs text-slate-600">
                                Enter the current six-digit code from your authenticator.
                            </p>

                        </div>


                        {{-- RECOVERY MODE --}}
                        <div x-show="recovery"
                             x-cloak>

                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Recovery Code
                            </label>

                            <input type="text"
                                   name="recovery_code"
                                   autocomplete="off"
                                   placeholder="Enter one of your recovery codes"
                                   class="mt-2 w-full rounded-xl
                                          border border-slate-800
                                          bg-slate-950 px-4 py-3
                                          font-mono text-sm text-slate-100
                                          outline-none transition
                                          placeholder:text-slate-600
                                          focus:border-amber-500/40">

                            <div class="mt-3 rounded-xl
                                        border border-amber-500/15
                                        bg-amber-500/[0.04]
                                        px-4 py-3">

                                <p class="text-xs leading-5 text-slate-500">
                                    Recovery codes are single-use emergency codes.
                                    Use one if you cannot access your authenticator app.
                                </p>

                            </div>

                        </div>


                        <button type="submit"
                                class="inline-flex w-full items-center
                                       justify-center gap-2 rounded-xl
                                       bg-violet-500 px-5 py-3
                                       text-sm font-semibold text-white
                                       transition hover:bg-violet-400">

                            Verify & Continue
                            <span>→</span>

                        </button>

                    </form>


                    <div class="mt-5 border-t border-slate-800 pt-5
                                text-center">

                        <button type="button"
                                @click="recovery = !recovery"
                                class="text-sm text-slate-500
                                       transition hover:text-violet-300">

                            <span x-show="!recovery">
                                Can't access your authenticator?
                                <span class="font-medium text-violet-300">
                                    Use a recovery code
                                </span>
                            </span>

                            <span x-show="recovery">
                                Have your authenticator?
                                <span class="font-medium text-violet-300">
                                    Use an authentication code
                                </span>
                            </span>

                        </button>

                    </div>

                </div>

            </div>
        </section>

    </div>

</x-layouts.app>
