<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            <!-- LEFT SIDE -->
            <div class="flex items-center">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:ms-10 sm:flex items-center">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    @if(auth()->user()->role?->slug === 'admin')
                        <div x-data="{ openAdmin: false }" class="relative">

                            <button
                                @click="openAdmin = !openAdmin"
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5
                                       text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300
                                       hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none transition ">
                                Administration
                                <svg class="ms-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>

                            <div x-show="openAdmin"
     x-transition:enter="transition ease-out duration-200"
     x-transition:enter-start="opacity-0 scale-95"
     x-transition:enter-end="opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-75"
     x-transition:leave-start="opacity-100 scale-100"
     x-transition:leave-end="opacity-0 scale-95"
     @click.away="openAdmin = false"
     class="absolute left-0 mt-2 w-48 bg-white dark:bg-gray-700
            shadow-lg rounded-md py-2 z-50">


                                <a href="{{ route('admin.users.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300
                                          hover:bg-gray-100 dark:hover:bg-gray-700">
                                    👤 Users
                                </a>

                                <a href="{{ route('admin.roles.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300
                                          hover:bg-gray-100 dark:hover:bg-gray-700">
                                    🛡 Roles
                                </a>

                                <a href="{{ route('admin.permissions.index') }}"
                                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300
                                          hover:bg-gray-100 dark:hover:bg-gray-700">
                                    🔑 Permissions
                                </a>
                                <a href="{{ route('admin.logs.index') }}" 
                                    class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
                                    hover:bg-gray-100 dark:hover:bg-gray-700"> 
                                    📜 Activity Logs 
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <!-- RIGHT SIDE -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">

                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm leading-4
                                       font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800
                                       hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                          clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500
                               hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900
                               focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }"
                              class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }"
                              class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(auth()->user()->role?->slug === 'admin')
                <div class="border-t border-gray-200 dark:border-gray-600 mt-2 pt-2">
                    <div class="px-4 text-gray-600 dark:text-gray-300 font-semibold text-sm">
                        Administration
                    </div>

                    <x-responsive-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
                        👤 Users
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.roles.index')" :active="request()->routeIs('admin.roles.*')">
                        🛡 Roles
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('admin.permissions.index')" :active="request()->routeIs('admin.permissions.*')">
                        🔑 Permissions
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('admin.permissions.index')" :active="request()->routeIs('admin.permissions.*')">
                        📜 Activity Logs
                    </x-responsive-nav-link>
                </div>
            @endif
        </div>

        <!-- Responsive Settings -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                                           onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>

    </div>
</nav>
