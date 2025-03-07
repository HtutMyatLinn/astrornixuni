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
        @include('marketingmanager.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @include('marketingmanager.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">



                <div class="max-w-full mx-auto">
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                        <!-- Total Students Card -->
                        <div class="bg-white shadow-[0px_14px_19px_-12px_#4353E1] p-6 w-full">
                            <!-- Avatar Circle -->
                            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6">
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
                            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6">
                                <img class=" w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}" alt="">
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
                        <div class="bg-white shadow-[0px_14px_19px_-12px_#4353E1] p-6 w-full">
                            <!-- Avatar Circle -->
                            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6">
                                <img class=" w-5 h-5" src="{{ asset('images/totalpendingcontributions.png') }}" alt="">
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
                        <!-- Total faculty Card -->
                        <div class="bg-white shadow-[0px_14px_19px_-12px_#4353E1] p-6 w-full">
                            <!-- Avatar Circle -->
                            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6">
                                <img class=" w-5 h-5" src="{{ asset('images/totalfaculty.png') }}" alt="">
                            </div>

                            <!-- Stats Container with Flexbox -->
                            <div class="flex items-end justify-between">
                                <!-- Numbers -->
                                <div class="space-y-1">
                                    <h2 class="text-3xl font-bold">300</h2>
                                    <p class="text-xl text-gray-400">Total Faculties</p>
                                </div>

                                <!-- Percentage -->
                                <div class="flex items-center gap-1">
                                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                                </div>
                            </div>
                        </div>
                        <!-- Total approved contributions Card-->
                        <div class="bg-white shadow-[0px_14px_19px_-12px_#4353E1] p-6 w-full">
                            <!-- Avatar Circle -->
                            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6">
                                <img class=" w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}" alt="">
                            </div>

                            <!-- Stats Container with Flexbox -->
                            <div class="flex items-end justify-between">
                                <!-- Numbers -->
                                <div class="space-y-1">
                                    <h2 class="text-3xl font-bold">300</h2>
                                    <p class="text-xl text-gray-400">Total Approved Contributions</p>
                                </div>

                                <!-- Percentage -->
                                <div class="flex items-center gap-1">
                                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                                </div>
                            </div>
                        </div>
                        <!-- Total Faculties Card-->
                        <div class="bg-white shadow-[0px_14px_19px_-12px_#4353E1] p-6 w-full">
                            <!-- Avatar Circle -->
                            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6">
                                <img class=" w-5 h-5" src="{{ asset('images/rejectcontri.png') }}" alt="">
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
                        <!-- Add more stat cards here -->
                    </div>
                    <!--  -->
                </div>


                <!-- table -->
                <div class="max-w-full mx-auto mt-12">

                    <div class="p-8 bg-white  shadow-lg rounded-md">
                        <!-- Header -->
                        <h1 class="text-xl font-bold mb-6">List of Contribution By Category</h1>
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
                                                    <span>Selected</span>
                                                </button>
                                                <button
                                                    class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left flex items-center justify-between">
                                                    <span>Pending</span>
                                                </button>
                                                <button
                                                    class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left flex items-center justify-between">
                                                    <span>Published</span>
                                                </button>
                                                <button
                                                    class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left flex items-center justify-between">
                                                    <span>Reviewed</span>
                                                </button>
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
                                                class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Newest</button>
                                            <button
                                                class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Oldest</button>
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
                                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">No</th>
                                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Notification Type</th>
                                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Message
                                        </th>
                                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Date</th>
                                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Time
                                        </th>

                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <!-- Row 1 -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-600">1</td>
                                        <td class="px-6 py-4 text-gray-600">New Published</td>
                                        <td class="px-6 py-4">
                                            John Doe's article 'AI in Marketing'
                                            is now published.
                                        </td>
                                        <td class="px-6 py-4 ">
                                            10-Feb-2025
                                        </td>
                                        <td class="px-6 py-4 text-[#2F64AA]">
                                            10:00 PM
                                        </td>

                                    </tr>
                                    <!-- Row 2 -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-600">1</td>
                                        <td class="px-6 py-4 text-gray-600">New Published</td>
                                        <td class="px-6 py-4">
                                            John Doe's article 'AI in Marketing'
                                            is now published.
                                        </td>
                                        <td class="px-6 py-4 ">
                                            10-Feb-2025
                                        </td>
                                        <td class="px-6 py-4 text-[#2F64AA]">
                                            10:00 PM
                                        </td>

                                    </tr>

                                    <!-- Row 3 -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-600">1</td>
                                        <td class="px-6 py-4 text-gray-600">New Published</td>
                                        <td class="px-6 py-4">
                                            John Doe's article 'AI in Marketing'
                                            is now published.
                                        </td>
                                        <td class="px-6 py-4 ">
                                            10-Feb-2025
                                        </td>
                                        <td class="px-6 py-4 text-[#2F64AA]">
                                            10:00 PM
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
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>

</html>
