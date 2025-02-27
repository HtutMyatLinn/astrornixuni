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
        <button @click="open = !open"
            class="flex items-center justify-between w-full space-x-3 px-4 py-2 focus:outline-none">
            <div class="flex  float-start space-x-3">
                <!-- Centered Profile Picture -->
                <div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center">
                    <img class="w-6 h-4" src="{{ asset('images/two_person.png') }}" alt="">
                </div>
                <div class="text-left">
                    <h3 class="text-sm font-semibold">{{ Auth::user()->username }}</h3>
                    <p class="text-xs text-gray-400">Marketing Coordinator</p>
                    <p class="text-xs text-gray-400">[Science]</p>
                </div>
            </div>
            <svg class="w-5 h-5 transition-transform duration-200" :class="open ? 'rotate-180' : 'rotate-0'"
                fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <!-- Dropdown Items -->
        <div x-show="open" x-transition class="mt-2 bg-[#1C2A3A] shadow-lg rounded-md overflow-hidden">
            <a href="#"
                class="flex items-center px-4 py-3 text-sm text-[#D4D4D4] hover:bg-gray-700 transition-colors">
                <img class="h-4 w-4 mr-3" src="{{ asset('images/editprofile.png') }}" alt="">
                Edit Profile
            </a>
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center w-full px-4 py-3 text-sm text-[#D4D4D4] hover:bg-gray-700 transition-colors">
                    <img class="h-4 w-4 mr-3" src="{{ asset('images/logout.png') }}" alt="">
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
                    <img class="w-4 h-4 mr-3" src="{{ asset('images/dashboard.png') }}" alt="">
                    Dashboard
                </a>

                <a href="{{ route('marketingcoordinator.guest-management') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.guest-management') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3" src="{{ asset('images/Usermanagement.png') }}" alt="">
                    Guest Management
                </a>

                <a href="{{ route('marketingcoordinator.submission-management') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.submission-management') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3" src="{{ asset('images/notifications.png') }}" alt="">
                    Submission Management
                </a>

                <a href="{{ route('marketingcoordinator.provide-feedback') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.provide-feedback') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3" src="{{ asset('images/report&analysis.png') }}" alt="">
                    Provide Feedback
                </a>
                <a href="{{ route('marketingcoordinator.published-contribution') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.published-contribution') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3" src="{{ asset('images/report&analysis.png') }}" alt="">
                    Published Contributions
                </a>
                <a href="{{ route('marketingcoordinator.notifications') }}"
                    class="flex items-center px-4 py-4 text-sm rounded-lg
                          {{ request()->routeIs('marketingcoordinator.notifications') ? 'bg-gray-700 text-white' : 'bg-[#1C2434] text-[#D4D4D4]' }}
                          hover:bg-gray-700 transition-colors duration-200">
                    <img class="w-4 h-4 mr-3" src="{{ asset('images/notifications.png') }}" alt="">
                    Notifications
                </a>
            </div>
        </div>
    </nav>
    <p>

    </p>
</aside>
