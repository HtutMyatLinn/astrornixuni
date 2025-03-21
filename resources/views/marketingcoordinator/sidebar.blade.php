<aside id="sidebar"
    class="bg-[#1C2434] text-[#D4D4D4] w-64 min-h-screen flex flex-col
    fixed lg:static inset-y-0 left-0 z-40
    transform lg:transform-none transition-transform duration-300 ease-in-out
    -translate-x-full lg:translate-x-0">

    <!-- Logo Section -->
    <div class="p-4 pt-8 pb-8">
        <div class="flex items-center space-x-2 pl-2">
            <span class="text-base font-bold text-white">ASTRORNIX</span>
            <span class="text-sm text-gray-300">University</span>
        </div>
    </div>

    <!-- User Profile Section with Dropdown -->
    <div class="p-4 text-white bg-[#1C2434]" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center justify-between w-full space-x-3 py-2 focus:outline-none">
            <div class="flex items-center space-x-3">
                <!-- Centered Profile Picture -->
                @if (Auth::check())
                    @if (Auth::user()->profile_image)
                        <img id="profilePreview"
                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                            src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}" alt="Profile">
                    @else
                        <p
                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                            {{ strtoupper(Auth::user()->username[0]) }}
                        </p>
                    @endif
                @else
                    <div class="w-12 h-12 select-none">
                        <img src="{{ asset('images/guest.jpg') }}" alt="Guest Profile"
                            class="w-full h-full rounded-full object-cover">
                    </div>
                @endif
                <div class="text-left">
                    <h3 class="text-sm font-semibold">{{ Auth::user()->username }}</h3>
                    <p class="text-xs text-gray-400">{{ Auth::user()->role->role }}</p>
                </div>
            </div>
            <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : 'rotate-0'"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <!-- Dropdown Items -->
        <div x-show="open" x-transition class="mt-2 bg-[#1C2A3A] shadow-lg rounded-md overflow-hidden">
            <a href="{{ route('marketingcoordinator.account-setting') }}"
                class="flex items-center px-4 py-3 text-sm text-[#D4D4D4] hover:bg-gray-700 transition-colors">
                <img class="h-4 w-4 mr-3 select-none" src="{{ asset('images/editprofile.png') }}" alt="">
                Edit Profile
            </a>
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-3 text-sm text-[#D4D4D4] hover:bg-gray-700 transition-colors">
                    <img class="h-4 w-4 mr-3 select-none" src="{{ asset('images/logout.png') }}" alt="">
                    Log Out
                </button>
            </form>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto py-4">
        <div class="px-5 mb-4">
            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">
                Pages
            </h2>
            <div class="space-y-1 text-[#D4D4D4]">
                <a href="{{ route('marketingcoordinator.dashboard') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.dashboard') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3 select-none" src="{{ asset('images/dashboard.png') }}" alt="">
                    Dashboard
                </a>

                <a href="{{ route('marketingcoordinator.guest-management') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.guest-management') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3 select-none" src="{{ asset('images/Usermanagement.png') }}"
                        alt="">
                    View Users
                </a>

                <a href="{{ route('marketingcoordinator.submission-management') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.submission-management') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3 select-none" src="{{ asset('images/notifications.png') }}" alt="">
                    Submission Management
                </a>

                <a href="{{ route('marketingcoordinator.selected-contributions') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.selected-contribution') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3 select-none" src="{{ asset('images/report&analysis.png') }}"
                        alt="">
                    Selected Contributions
                </a>

                <a href="{{ route('marketingcoordinator.published-contribution') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.published-contribution') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3 select-none" src="{{ asset('images/report&analysis.png') }}"
                        alt="">
                    Published Contributions
                </a>
                <a href="{{ route('marketingcoordinator.notifications') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.notifications') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3 select-none" src="{{ asset('images/notifications.png') }}" alt="">
                    Notifications
                </a>

                <a href="{{ route('marketingcoordinator.report') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.report') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3 select-none" src="{{ asset('images/notifications.png') }}" alt="">
                    Reports
                </a>
            </div>
        </div>
    </nav>
    <p>

    </p>
</aside>
