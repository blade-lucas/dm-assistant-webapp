<x-layouts.app title="Create Account">

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
                        <circle cx="10" cy="8" r="3"/>
                        <path d="M3 21a7 7 0 0 1 14 0"/>
                        <path d="M19 6v6"/>
                        <path d="M16 9h6"/>
                    </svg>

                </div>


                <div class="mt-5 text-center">

                    <p class="text-xs font-semibold uppercase
                              tracking-[0.16em] text-amber-400">
                        DM Assistant
                    </p>

                    <h1 class="mt-2 text-3xl font-bold tracking-tight
                               text-slate-50">
                        Create Your Account
                    </h1>

                    <p class="mt-2 text-sm leading-6 text-slate-400">
                        Register to save campaigns, characters, encounters,
                        dungeons, and other Dungeon Master content.
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
                      action="/register"
                      class="mt-7 grid gap-5">

                    @csrf


                    <div>

                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Name
                        </label>

                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               autocomplete="name"
                               placeholder="Your name"
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

                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               required
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

                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Password
                        </label>

                        <input type="password"
                               name="password"
                               required
                               autocomplete="new-password"
                               class="mt-2 w-full rounded-xl
                                      border border-slate-800
                                      bg-slate-950 px-4 py-3
                                      text-sm text-slate-100
                                      outline-none transition
                                      focus:border-amber-500/40
                                      focus:ring-1 focus:ring-amber-500/20">

                    </div>


                    <div>

                        <label class="text-xs font-medium uppercase
                                      tracking-wide text-slate-400">
                            Confirm Password
                        </label>

                        <input type="password"
                               name="password_confirmation"
                               required
                               autocomplete="new-password"
                               class="mt-2 w-full rounded-xl
                                      border border-slate-800
                                      bg-slate-950 px-4 py-3
                                      text-sm text-slate-100
                                      outline-none transition
                                      focus:border-amber-500/40
                                      focus:ring-1 focus:ring-amber-500/20">

                    </div>


                    <button type="submit"
                            class="inline-flex w-full items-center
                                   justify-center gap-2 rounded-xl
                                   bg-amber-400 px-5 py-3
                                   text-sm font-semibold text-slate-950
                                   transition hover:bg-amber-300">

                        Create Account
                        <span>→</span>

                    </button>


                    <div class="border-t border-slate-800 pt-5
                                text-center text-sm text-slate-500">

                        Already have an account?

                        <a href="/login"
                           class="ml-1 font-medium text-amber-300
                                  transition hover:text-amber-200">
                            Sign in
                        </a>

                    </div>

                </form>

            </div>
        </section>

    </div>

</x-layouts.app>
