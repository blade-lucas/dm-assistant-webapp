<x-layouts.app title="Login">

    <div class="mx-auto max-w-md">

        <section class="relative overflow-hidden rounded-3xl
                        border border-amber-500/20
                        bg-gradient-to-br from-slate-900
                        via-amber-950/10 to-slate-950
                        p-7 md:p-8">

            <div class="pointer-events-none absolute -right-20 -top-20
                        h-56 w-56 rounded-full
                        bg-amber-500/[0.06] blur-3xl">
            </div>

            <div class="relative">

                <div class="mx-auto flex h-14 w-14 items-center
                            justify-center rounded-2xl
                            border border-amber-500/20
                            bg-amber-500/10 text-amber-300">

                    <svg class="h-7 w-7"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.7">
                        <path d="M12 3 5 6v5c0 4.6 2.9 8.1 7 10 4.1-1.9 7-5.4 7-10V6z"/>
                        <path d="M9 12h6"/>
                    </svg>

                </div>

                <div class="mt-5 text-center">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] text-amber-400">
                        DM Assistant
                    </p>

                    <h1 class="mt-2 text-3xl font-bold tracking-tight
                               text-slate-50">
                        Welcome Back
                    </h1>

                    <p class="mt-2 text-sm text-slate-400">
                        Sign in to continue to your Dungeon Master workspace.
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


                @if (session('status'))

                    <div class="mt-6 rounded-2xl border
                                border-emerald-800/60
                                bg-emerald-950/30 p-4
                                text-sm text-emerald-200">
                        {{ session('status') }}
                    </div>

                @endif


                <form method="POST"
                      action="/login"
                      class="mt-7 grid gap-5">

                    @csrf


                    <div>
                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
                               autofocus
                               autocomplete="username"
                               placeholder="you@example.com"
                               class="mt-2 w-full rounded-xl
                                      border border-slate-800
                                      bg-slate-950 px-4 py-3
                                      text-sm text-slate-100
                                      outline-none transition
                                      placeholder:text-slate-600
                                      focus:border-amber-500/40
                                      focus:ring-1 focus:ring-amber-500/20">
                    </div>


                    <div>
                        <div class="flex items-center justify-between">

                            <label class="text-xs font-medium uppercase
                                          tracking-wide text-slate-400">
                                Password
                            </label>

                            <a href="/forgot-password"
                               class="text-xs text-slate-500
                                      transition hover:text-amber-300">
                                Forgot password?
                            </a>

                        </div>

                        <input type="password"
                               name="password"
                               required
                               autocomplete="current-password"
                               class="mt-2 w-full rounded-xl
                                      border border-slate-800
                                      bg-slate-950 px-4 py-3
                                      text-sm text-slate-100
                                      outline-none transition
                                      focus:border-amber-500/40
                                      focus:ring-1 focus:ring-amber-500/20">
                    </div>


                    <label class="flex cursor-pointer items-center gap-3
                                  rounded-xl border border-slate-800
                                  bg-slate-900/30 px-4 py-3
                                  text-sm text-slate-400">

                        <input type="checkbox"
                               name="remember"
                               class="accent-amber-400">

                        Remember me on this device
                    </label>


                    <button type="submit"
                            class="inline-flex w-full items-center
                                   justify-center gap-2 rounded-xl
                                   bg-amber-400 px-5 py-3
                                   text-sm font-semibold text-slate-950
                                   transition hover:bg-amber-300">

                        Sign In
                        <span>→</span>

                    </button>


                    <div class="border-t border-slate-800 pt-5
                                text-center text-sm text-slate-500">

                        Don't have an account?

                        <a href="/register"
                           class="ml-1 font-medium text-amber-300
                                  hover:text-amber-200">
                            Create one
                        </a>

                    </div>

                </form>

            </div>
        </section>

    </div>

</x-layouts.app>
