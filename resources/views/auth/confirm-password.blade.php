<x-layouts.app title="Confirm Password">

    <div class="mx-auto max-w-md">

        <section class="relative overflow-hidden rounded-3xl
                        border border-blue-500/20
                        bg-gradient-to-br from-slate-900
                        via-blue-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-20 -top-20
                        h-56 w-56 rounded-full
                        bg-blue-500/[0.06] blur-3xl">
            </div>

            <div class="relative">

                <div class="mx-auto flex h-14 w-14 items-center
                            justify-center rounded-2xl
                            border border-blue-500/20
                            bg-blue-500/10 text-blue-300">

                    <svg class="h-7 w-7"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.7">
                        <rect x="5" y="10" width="14" height="10" rx="2"/>
                        <path d="M8 10V7a4 4 0 0 1 8 0v3"/>
                    </svg>

                </div>

                <div class="mt-5 text-center">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] text-blue-400">
                        Security Check
                    </p>

                    <h1 class="mt-2 text-3xl font-bold tracking-tight
                               text-slate-50">
                        Confirm Your Password
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        For your security, please confirm your current
                        password before continuing with this action.
                    </p>

                </div>


                @if ($errors->any())

                    <div class="mt-6 rounded-2xl border border-red-900
                                bg-red-950/30 p-4 text-sm text-red-200">

                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>

                    </div>

                @endif


                <form method="POST"
                      action="/user/confirm-password"
                      class="mt-7 grid gap-5">

                    @csrf


                    <div>

                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Current Password
                        </label>

                        <input type="password"
                               name="password"
                               required
                               autofocus
                               autocomplete="current-password"
                               class="mt-2 w-full rounded-xl
                                      border border-slate-800
                                      bg-slate-950 px-4 py-3
                                      text-sm text-slate-100
                                      outline-none transition
                                      focus:border-blue-500/40
                                      focus:ring-1 focus:ring-blue-500/20">

                    </div>


                    <button type="submit"
                            class="inline-flex w-full items-center
                                   justify-center gap-2 rounded-xl
                                   bg-blue-500 px-5 py-3
                                   text-sm font-semibold text-white
                                   transition hover:bg-blue-400">

                        Confirm & Continue
                        <span>→</span>

                    </button>

                </form>


                <div class="mt-5 border-t border-slate-800 pt-5">

                    <p class="text-center text-xs leading-5 text-slate-600">
                        This extra verification helps protect sensitive
                        account and security settings.
                    </p>

                </div>

            </div>
        </section>

    </div>

</x-layouts.app>
