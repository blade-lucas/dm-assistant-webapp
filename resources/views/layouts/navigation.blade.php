<nav x-data="{ open: false }" class="border-b border-slate-800 bg-slate-950">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-8">
            <div class="shrink-0 flex items-center">
                <a href="{{ auth()->check() ? (auth()->user()->is_admin ? route('admin.index') : route('dashboard')) : route('home') }}">
                    <span class="text-lg font-semibold text-white">DM Assistant</span>
                </a>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-6">
                @auth
                    @if(auth()->user()->is_admin)
                        <a href="{{ route('admin.index') }}"
                           class="text-sm {{ request()->routeIs('admin.*') ? 'text-white font-semibold' : 'text-slate-300 hover:text-white' }}">
                            Admin Dashboard
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}"
                           class="text-sm {{ request()->routeIs('dashboard') ? 'text-white font-semibold' : 'text-slate-300 hover:text-white' }}">
                            Dashboard
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        @auth
            <div class="hidden sm:flex sm:items-center">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-slate-700 bg-slate-900 px-3 py-2 text-sm font-medium text-slate-200 hover:bg-slate-800">
                            <span>{{ auth()->user()->name }}</span>
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if(auth()->user()->is_admin)
                            <x-dropdown-link :href="route('admin.index')">
                                Admin Dashboard
                            </x-dropdown-link>
                        @else
                            <x-dropdown-link :href="route('dashboard')">
                                Dashboard
                            </x-dropdown-link>
                        @endif

                        <x-dropdown-link :href="route('account.index')">
                            Account
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="sm:hidden">
                <button @click="open = !open"
                        class="inline-flex items-center justify-center rounded-md p-2 text-slate-400 hover:bg-slate-900 hover:text-white">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endauth
    </div>

    @auth
        <div :class="{ 'block': open, 'hidden': !open }" class="hidden border-t border-slate-800 sm:hidden">
            <div class="space-y-1 px-4 py-3">
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.index') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-300 hover:bg-slate-900 hover:text-white">
                        Admin Dashboard
                    </a>
                @else
                    <a href="{{ route('dashboard') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-300 hover:bg-slate-900 hover:text-white">
                        Dashboard
                    </a>
                @endif

                <a href="{{ route('account.index') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-300 hover:bg-slate-900 hover:text-white">
                    Account
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm text-slate-300 hover:bg-slate-900 hover:text-white">
                        Log Out
                    </button>
                </form>
            </div>

            <div class="border-t border-slate-800 px-4 py-3">
                <div class="text-sm font-medium text-white">{{ auth()->user()->name }}</div>
                <div class="text-xs text-slate-400">{{ auth()->user()->email }}</div>
            </div>
        </div>
    @endauth
</nav>
