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

<body class="bg-gray-50 min-w-[420px]">
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
            @include('marketingmanager.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            @include('marketingmanager.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <h1 class=" text-xl sm:text-2xl font-bold text-gray-900"> Published Contributions Report</h1>

                <div class="max-w-full mx-auto mt-4">

                    <div class="p-8 bg-white  shadow-lg rounded-md">
                        <!-- Header -->
                        <h1 class="text-xl font-bold mb-6">List of Published Contributions</h1>
                        <!-- Search and Filters -->
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between mb-8">
                            <div class="relative max-w-[400px]">
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

                            <div class="flex flex-wrap gap-4">
                                <!-- Filter Dropdown -->
                                <div class="relative group">
                                    <button
                                        class="flex items-center gap-2 px-6 py-2.5 rounded-lg bg-[#F1F5F9] hover:bg-gray-100">
                                        Filter By
                                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
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
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">No</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Contributions
                                                Title</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Faculty
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Student
                                                Name
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Published
                                                Date
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Views
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <!-- Row 1 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div>
                                                        <img src="" alt="">
                                                        <div class="font-medium">AI in Marketing</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">Social Science</td>
                                            <td class="px-6 py-4 text-gray-600">Mi Mi</td>
                                            <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                160
                                            </td>

                                        </tr>
                                        <!-- Row 2 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div>
                                                        <img src="" alt="">
                                                        <div class="font-medium">AI in Marketing</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">Social Science</td>
                                            <td class="px-6 py-4 text-gray-600">Mi Mi</td>
                                            <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                160
                                            </td>

                                        </tr>

                                        <!-- Row 3 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div>
                                                        <img src="" alt="">
                                                        <div class="font-medium">AI in Marketing</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">Social Science</td>
                                            <td class="px-6 py-4 text-gray-600">Mi Mi</td>
                                            <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                160
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-end items-center gap-2 mt-6">
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">1</button>
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">2</button>
                            <span class="text-gray-600">...</span>
                            <button
                                class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">Next</button>
                        </div>
                    </div>
                </div>

                <!-- rate -->
                <div class="max-w-full mx-auto mt-12">
                    <div class="p-8 bg-white  shadow-lg rounded-md">
                        <!-- Header -->
                        <h1 class="text-xl font-bold mb-6">List of Published Contributions</h1>
                        <!-- Search and Filters -->
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between mb-8">
                            <div class="relative max-w-[400px]">
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

                            <div class="flex flex-wrap gap-4">
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
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">No</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Faculty
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Total
                                                Submissions
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Published
                                                Contributions</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Participation
                                                Rate
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <!-- Row 1 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">Social Science</td>
                                            <td class="px-6 py-4">
                                                50
                                            </td>
                                            <td class="px-6 py-4 ">
                                                10
                                            </td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                2.3%
                                            </td>

                                        </tr>
                                        <!-- Row 2 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">Social Science</td>
                                            <td class="px-6 py-4">
                                                50
                                            </td>
                                            <td class="px-6 py-4 ">
                                                10
                                            </td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                160
                                            </td>

                                        </tr>

                                        <!-- Row 3 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">Social Science</td>
                                            <td class="px-6 py-4">
                                                50
                                            </td>
                                            <td class="px-6 py-4 ">
                                                10
                                            </td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                160
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-end items-center gap-2 mt-6">
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">1</button>
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">2</button>
                            <span class="text-gray-600">...</span>
                            <button
                                class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">Next</button>
                        </div>
                    </div>
                </div>

                <!-- category -->
                <div class="max-w-full mx-auto mt-12">
                    <div class="p-8 bg-white  shadow-lg rounded-md">
                        <!-- Header -->
                        <h1 class="text-xl font-bold mb-6">List of Contribution By Category</h1>
                        <!-- Search and Filters -->
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between mb-8">
                            <div class="relative max-w-[400px]">
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

                            <div class="flex flex-wrap gap-4">
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
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">No</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Category
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Total
                                                Submissions
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Published
                                                Contributions</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Participation
                                                Rate
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <!-- Row 1 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">Social Science</td>
                                            <td class="px-6 py-4">
                                                50
                                            </td>
                                            <td class="px-6 py-4 ">
                                                10
                                            </td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                1.3 %
                                            </td>

                                        </tr>
                                        <!-- Row 2 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">Social Science</td>
                                            <td class="px-6 py-4">
                                                50
                                            </td>
                                            <td class="px-6 py-4 ">
                                                10
                                            </td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                3.2 %
                                            </td>

                                        </tr>

                                        <!-- Row 3 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">Social Science</td>
                                            <td class="px-6 py-4">
                                                50
                                            </td>
                                            <td class="px-6 py-4 ">
                                                10
                                            </td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                160
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-end items-center gap-2 mt-6">
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">1</button>
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">2</button>
                            <span class="text-gray-600">...</span>
                            <button
                                class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">Next</button>
                        </div>
                    </div>
                </div>

                <!-- comment -->
                <div class="max-w-full mx-auto mt-12">
                    <div class="p-8 bg-white  shadow-lg rounded-md">
                        <!-- Header -->
                        <h1 class="text-xl font-bold mb-6">List of Contribution By Comment</h1>
                        <!-- Search and Filters -->
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between mb-8">
                            <div class="relative max-w-[400px]">
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

                            <div class="flex flex-wrap gap-4">
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
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">No</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Contributions
                                                Title</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Commenter
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Comment
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Comment
                                                Date
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <!-- Row 1 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">AI in Marketing</td>
                                            <td class="px-6 py-4">
                                                Aung Aung
                                            </td>
                                            <td class="px-6 py-4 ">
                                                Needs more sources
                                            </td>
                                            <td class="px-6 py-4">
                                                Feb 26, 2024
                                            </td>

                                        </tr>
                                        <!-- Row 2 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">AI in Marketing</td>
                                            <td class="px-6 py-4">
                                                Aung Aung
                                            </td>
                                            <td class="px-6 py-4 ">
                                                Needs more sources
                                            </td>
                                            <td class="px-6 py-4">
                                                Feb 26, 2024
                                            </td>

                                        </tr>

                                        <!-- Row 3 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">AI in Marketing</td>
                                            <td class="px-6 py-4">
                                                Aung Aung
                                            </td>
                                            <td class="px-6 py-4 ">
                                                Needs more sources
                                            </td>
                                            <td class="px-6 py-4">
                                                Feb 26, 2024
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-end items-center gap-2 mt-6">
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">1</button>
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">2</button>
                            <span class="text-gray-600">...</span>
                            <button
                                class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">Next</button>
                        </div>
                    </div>
                </div>

                <!-- feedback -->
                <div class="max-w-full mx-auto mt-12 mb-12">

                    <div class="p-8 bg-white  shadow-lg rounded-md">
                        <!-- Header -->
                        <h1 class="text-xl font-bold mb-6">List of Contribution By Feedback</h1>
                        <!-- Search and Filters -->
                        <div class="flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between mb-8">
                            <div class="relative max-w-[400px]">
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

                            <div class="flex flex-wrap gap-4">
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
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">No</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Contributions
                                                Title</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Feedback
                                                Giver
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Feedback
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Feedback
                                                Date
                                            </th>

                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <!-- Row 1 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">AI in Marketing</td>
                                            <td class="px-6 py-4">
                                                Aung Aung
                                            </td>
                                            <td class="px-6 py-4 ">
                                                Needs more sources
                                            </td>
                                            <td class="px-6 py-4">
                                                Feb 26, 2024
                                            </td>

                                        </tr>
                                        <!-- Row 2 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">AI in Marketing</td>
                                            <td class="px-6 py-4">
                                                Aung Aung
                                            </td>
                                            <td class="px-6 py-4 ">
                                                Needs more sources
                                            </td>
                                            <td class="px-6 py-4">
                                                Feb 26, 2024
                                            </td>

                                        </tr>

                                        <!-- Row 3 -->
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">1</td>
                                            <td class="px-6 py-4 text-gray-600">AI in Marketing</td>
                                            <td class="px-6 py-4">
                                                Aung Aung
                                            </td>
                                            <td class="px-6 py-4 ">
                                                Needs more sources
                                            </td>
                                            <td class="px-6 py-4">
                                                Feb 26, 2024
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-end items-center gap-2 mt-6">
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">1</button>
                            <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">2</button>
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
