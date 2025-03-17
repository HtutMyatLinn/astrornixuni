<nav x-data="{ open: false, isSticky: false }" x-on:scroll.window="isSticky = window.scrollY > 80" :class="{ 'shadow-sm': isSticky }"
    class="transition-all duration-500 bg-white border-b sticky top-0 border-gray-100 z-50 min-w-[420px]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[74px]">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a
                        href="{{ Auth::check() ? (Auth::user()->role === 'Student' ? route('student.dashboard') : url('/')) : url('/') }}">
                        <x-logo />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="Auth::check() && Auth::user()->role ? (Auth::user()->role->role === 'Student' ? route('student.dashboard') : url('/')) : url('/')" :active="request()->routeIs('student.dashboard') || request()->is('/')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contributions')" :active="request()->routeIs('contributions')">
                        {{ __('Contributions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('faculty')" :active="request()->routeIs('faculty')" id="faculty-link">
                        {{ __('Faculty') }}
                    </x-nav-link>
                    <x-nav-link :href="route('aboutus')" :active="request()->routeIs('aboutus')">
                        {{ __('About') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contactus')" :active="request()->routeIs('contactus')">
                        {{ __('Contact') }}
                    </x-nav-link>
                </div>

                <!-- Mega Menu Dropdown -->
                <div id="mega-menu"
                    class="absolute left-0 top-full w-full bg-white shadow-lg p-6 flex-col space-y-4 border border-gray-200 opacity-0 invisible transition-all duration-300 transform -translate-y-2">
                    <div class="grid grid-cols-3 gap-6">
                        <div>
                            <h3 class="font-semibold text-gray-800">Departments</h3>
                            <ul class="mt-2 space-y-2">
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Science</a></li>
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Engineering</a>
                                </li>
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Arts</a></li>
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Business</a></li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800">Resources</h3>
                            <ul class="mt-2 space-y-2">
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Research</a></li>
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Events</a></li>
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Publications</a>
                                </li>
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Scholarships</a>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800">Departments</h3>
                            <ul class="mt-2 space-y-2">
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Science</a></li>
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Engineering</a>
                                </li>
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Arts</a></li>
                                <li><a href="" class="block text-gray-600 hover:text-blue-600">Business</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <script>
                    // Get the Faculty link and Mega Menu elements
                    const facultyLink = document.getElementById('faculty-link');
                    const megaMenu = document.getElementById('mega-menu');

                    // Show Mega Menu on hover
                    facultyLink.addEventListener('mouseenter', () => {
                        megaMenu.classList.remove('opacity-0', 'invisible', '-translate-y-2');
                        megaMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                    });

                    // Hide Mega Menu when mouse leaves
                    facultyLink.addEventListener('mouseleave', () => {
                        megaMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                        megaMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
                    });

                    // Optional: Keep Mega Menu open if mouse is over it
                    megaMenu.addEventListener('mouseenter', () => {
                        megaMenu.classList.remove('opacity-0', 'invisible', '-translate-y-2');
                        megaMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
                    });

                    megaMenu.addEventListener('mouseleave', () => {
                        megaMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
                        megaMenu.classList.add('opacity-0', 'invisible', '-translate-y-2');
                    });
                </script>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if (Auth::check() && Auth::user()->role && Auth::user()->role->role === 'Student')
                    <a href="{{ route('upload_contribution.index') }}"
                        class="leading-4 font-medium text-blue-800 hover:text-blue-900 border-l-2 py-2 pl-4 transition-colors duration-200">
                        Contribute your article
                    </a>
                @endif

                <x-dropdown align="right">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @if (Auth::check())
                                <div class="truncate max-w-[100px]">{{ Auth::user()->username }}</div>
                            @else
                                <div>Guest</div>
                            @endif
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
                        {{-- Profile --}}
                        <div class="flex items-center gap-3 p-2">
                            @if (Auth::check())
                                @if (Auth::user()->profile_image)
                                    <img id="profilePreview"
                                        class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                        src="{{ asset('profile_images/' . Auth::user()->profile_image) }}"
                                        alt="Profile">
                                @else
                                    <p
                                        class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                        {{ strtoupper(Auth::user()->username[0]) }}
                                    </p>
                                @endif
                            @else
                                <div class="w-10 h-10 sm:w-12 sm:h-12 select-none">
                                    <img src="{{ asset('images/guest.jpg') }}" alt="Guest Profile"
                                        class="w-full h-full rounded-full object-cover">
                                </div>
                            @endif
                            <div class="flex-1 min-w-0">
                                @if (Auth::check())
                                    <p class="text-xs sm:text-sm text-gray-500 text-wrap w-56"
                                        title="{{ Auth::user()->email }}">
                                        {{ Auth::user()->email }}
                                    </p>
                                    <p class="text-xs text-gray-500 text-wrap">
                                        Last login date -
                                        {{ Auth::user()->last_login_date ? Auth::user()->last_login_date->format('d-m-Y') : 'Never' }}
                                    </p>
                                @else
                                    <p class="text-xs sm:text-sm text-gray-500 w-44 text-wrap" title="Guest">
                                        Register to get access to all features
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if (Auth::check())
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('register')">
                                {{ __('Register') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('login')">
                                {{ __('Log In') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>

                {{-- Notidication --}}
                <i class="ri-notification-3-line text-lg cursor-pointer"></i>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <!-- Mobile Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('/')" :active="request()->routeIs('/')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contributions')" :active="request()->routeIs('contributions')">
                {{ __('Contributions') }}
            </x-responsive-nav-link>

            <!-- Faculty Link with Mega Menu Toggle -->
            <div x-data="{ isFacultyOpen: false }">
                <x-responsive-nav-link @click="isFacultyOpen = !isFacultyOpen" :active="request()->routeIs('faculty')">
                    {{ __('Faculty') }}
                    <svg class="w-4 h-4 inline ml-1 transition-transform" :class="{ 'rotate-180': isFacultyOpen }"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </x-responsive-nav-link>

                <!-- Mega Menu for Mobile -->
                <div x-show="isFacultyOpen" x-collapse class="pl-4 space-y-1">
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <h3 class="font-semibold text-gray-800">Departments</h3>
                            <ul class="mt-2 space-y-2">
                                <li><a href="#" class="block text-gray-600 hover:text-blue-600">Science</a></li>
                                <li><a href="#" class="block text-gray-600 hover:text-blue-600">Engineering</a>
                                </li>
                                <li><a href="#" class="block text-gray-600 hover:text-blue-600">Arts</a></li>
                                <li><a href="#" class="block text-gray-600 hover:text-blue-600">Business</a>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <h3 class="font-semibold text-gray-800">Resources</h3>
                            <ul class="mt-2 space-y-2">
                                <li><a href="#" class="block text-gray-600 hover:text-blue-600">Research</a>
                                </li>
                                <li><a href="#" class="block text-gray-600 hover:text-blue-600">Events</a></li>
                                <li><a href="#" class="block text-gray-600 hover:text-blue-600">Publications</a>
                                </li>
                                <li><a href="#" class="block text-gray-600 hover:text-blue-600">Scholarships</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <x-responsive-nav-link :href="route('aboutus')" :active="request()->routeIs('aboutus')">
                {{ __('About') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contactus')" :active="request()->routeIs('contactus')">
                {{ __('Contact') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @if (Auth::check())
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                @endif
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
