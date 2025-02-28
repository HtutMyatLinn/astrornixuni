<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>

    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50">
    <!-- Main Container -->
    <div class="flex min-h-screen relative">
        <!-- Sidebar Toggle Button (Mobile) -->
        <button id="sidebarToggle"
            class="lg:hidden fixed bottom-4 right-4 z-50 bg-blue-600 text-white p-3 rounded-full shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="w-64 fixed inset-y-0 left-0 transform transition-transform duration-300 z-40 -translate-x-full lg:translate-x-0">
            @include('admin.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            @include('admin.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <div class="max-w-7xl mx-auto space-y-4 mb-4">
                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">System Notifications & Alerts</h1>
                    <h2 class="text-sm sm:text-lg text-gray-500">Summary of Alerts</h2>
                    <div class="max-w-7xl mx-auto">
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-10">
                            <!-- Total Students Card -->
                            <div class="bg-white shadow-[0px_14px_19px_-12px_#4353E1] p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6">
                                    <img class=" w-5 h-5" src="{{ asset('images/totalstudents.png') }}" alt="">
                                </div>

                                <!-- Stats Container with Flexbox -->
                                <div class="flex items-end justify-between">
                                    <!-- Numbers -->
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold">300</h2>
                                        <p class="text-xl text-gray-400">Total Students</p>
                                    </div>

                                    <!-- Percentage -->
                                    <div class="flex items-center gap-1">
                                        <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Total submissions Card -->
                            <div class="bg-white shadow-[0px_14px_19px_-12px_#4353E1] p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6">
                                    <img class=" w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}"
                                        alt="">
                                </div>

                                <!-- Stats Container with Flexbox -->
                                <div class="flex items-end justify-between">
                                    <!-- Numbers -->
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold">967</h2>
                                        <p class="text-xl text-gray-400">Total Submissions</p>
                                    </div>

                                    <!-- Percentage -->
                                    <div class="flex items-center gap-1">
                                        <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Pending Contributions Card -->
                            <div
                                class="bg-white shadow-[0px_14px_19px_-12px_#4353E1] col-span-0 sm:col-span-2 lg:col-span-1 p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6">
                                    <img class=" w-5 h-5" src="{{ asset('images/totalpendingcontributions.png') }}"
                                        alt="">
                                </div>

                                <!-- Stats Container with Flexbox -->
                                <div class="flex items-end justify-between">
                                    <!-- Numbers -->
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold">52</h2>
                                        <p class="text-xl text-gray-400">Total Pending Contributions</p>
                                    </div>

                                    <!-- Percentage -->
                                    <div class="flex items-center gap-1">
                                        <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <h2 class="text-sm sm:text-lg text-gray-500 mb-10">All System Notifications</h2>
                        <div class="p-8 bg-white  shadow-lg">
                            <!-- Header -->
                            <h1 class="text-2xl font-bold mb-6">List of Notifications</h1>

                            <!-- Tabs -->
                            <div class="flex gap-8 border-b mb-6">
                                <a href="{{ route('admin.notifications') }}"
                                    class="px-1 py-4 text-gray-600 hover:text-gray-900 ">
                                    All
                                </a>
                                <a href="{{ route('admin.notifications.inquiry') }}"
                                    class="px-1 py-4  hover:text-gray-900 text-[#4353E1] border-b-4 border-[#4353E1]">
                                    Inquiry
                                </a>
                                <a href="{{ route('admin.notifications.password-reset') }}"
                                    class="px-1 py-4 text-gray-600 hover:text-gray-900">
                                    Password Rest
                                </a>
                                <a href="{{ route('admin.notifications.unregister-user') }}"
                                    class="px-1 py-4 text-gray-600 hover:text-gray-900">
                                    Unregister User
                                </a>
                            </div>


                            <!-- Search and Filters -->
                            <div class="flex justify-between mb-8">
                                <div class="relative w-[400px]">
                                    <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    <input type="text" placeholder="Search..."
                                        class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                                </div>

                                <div class="flex gap-4">
                                    <!-- Filter Dropdown -->
                                    <div class="relative group">
                                        <button
                                            class="flex items-center gap-2 px-6 py-2.5 rounded-lg bg-[#F1F5F9] hover:bg-gray-100">
                                            Filter By
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m6 9 6 6 6-6" />
                                            </svg>
                                        </button>
                                        <div
                                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                            <div class="p-2">
                                                <div class="relative group/faculty">
                                                    <button
                                                        class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left flex items-center justify-between">
                                                        <span>Faculty</span>
                                                        <svg class="h-4 w-4 text-gray-400"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="none" stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            <path d="m9 18 6-6-6-6" />
                                                        </svg>
                                                    </button>
                                                    <div
                                                        class="absolute left-full top-0 ml-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover/faculty:opacity-100 group-hover/faculty:visible transition-all duration-200">
                                                        <div class="p-2">
                                                            <button
                                                                class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Science</button>
                                                            <button
                                                                class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">IT</button>
                                                            <button
                                                                class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Psychology</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sort Dropdown -->
                                    <div class="relative group">
                                        <button
                                            class="flex items-center gap-2 px-6 py-2.5 rounded-lg bg-[#F1F5F9] hover:bg-gray-100">
                                            Sort By
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m6 9 6 6 6-6" />
                                            </svg>
                                        </button>
                                        <div
                                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                            <div class="p-2">
                                                <button
                                                    class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Ascending</button>
                                                <button
                                                    class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Descending</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="bg-white rounded-lg overflow-hidden">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Notification Type</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Message
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Date &
                                                Time</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Status
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <!-- Row 1 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <img src="{{ asset('images/totaluser.png') }}" alt="Avatar"
                                                        class="w-10 h-10 rounded-full">
                                                    <div>
                                                        <div class="font-medium">Aung Aung</div>
                                                        <div class="text-sm text-gray-500">Aung1@gmail.com</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">Science</td>
                                            <td class="px-6 py-4 text-gray-600">Student</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-3 py-1 rounded-full text-sm bg-green-50 text-green-700">Read</span>
                                            </td>

                                            <td class="px-6 py-4 text-[#2F64AA] font-light">
                                                Response
                                            </td>
                                        </tr>

                                        <!-- Row 2 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <img src="{{ asset('images/totaluser.png') }}" alt="Avatar"
                                                        class="w-10 h-10 rounded-full">
                                                    <div>
                                                        <div class="font-medium">Aung Aung</div>
                                                        <div class="text-sm text-gray-500">Aung1@gmail.com</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">IT</td>
                                            <td class="px-6 py-4 text-gray-600">Student</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-3 py-1 rounded-full text-sm bg-green-50 text-green-700">Read</span>
                                            </td>

                                            <td class="px-6 py-4 text-[#2F64AA] font-light">
                                                Response
                                            </td>
                                        </tr>

                                        <!-- Row 3 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <img src="{{ asset('images/totaluser.png') }}" alt="Avatar"
                                                        class="w-10 h-10 rounded-full">
                                                    <div>
                                                        <div class="font-medium">Aung Aung</div>
                                                        <div class="text-sm text-gray-500">Aung1@gmail.com</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">Psychology</td>
                                            <td class="px-6 py-4 text-gray-600">Student</td>
                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-3 py-1 rounded-full text-sm bg-red-50 text-red-700">Unread</span>
                                            </td>

                                            <td class="px-6 py-4 text-[#2F64AA] font-light">
                                                Response
                                            </td>
                                        </tr>

                                        <!-- Add more rows as needed -->
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="flex justify-end items-center gap-2 mt-6">
                                <button
                                    class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">1</button>
                                <button
                                    class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">2</button>
                                <span class="text-gray-600">...</span>
                                <button
                                    class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">Next</button>
                            </div>
                        </div>


                    </div>
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('translate-x-full');
        });
    </script>
</body>

</html>
