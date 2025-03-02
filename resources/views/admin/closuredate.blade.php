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
            <main class="flex-1 bg-[#F1F5F9] p-4 sm:p-5">

                <div class="max-w-7xl mx-auto space-y-4 mb-4">
                    <div class="p-8 bg-white  shadow-lg">
                        <!-- Header -->
                        <div class="flex justify-between items-center mb-6">
                            <h1 class="text-2xl font-bold">List of Academic Years ()</h1>
                            <button onclick="openModal()"
                                class="px-8 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Add Academic Year
                            </button>
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
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="bg-white rounded-lg overflow-hidden">
                            <table class="w-full">
                                <thead class="bg-[#F9F8F8]">
                                    <tr>
                                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Academic
                                            Year</th>
                                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Added Date
                                        </th>
                                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Updated Date
                                        </th>
                                        <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <!-- Row 1 -->
                                    <tr class="hover:bg-gray-50">
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">Science</td>
                                        <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                        <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <button class="text-blue-600 hover:text-blue-700">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                        <path d="m15 5 4 4" />
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 hover:text-red-700">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 6h18" />
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Row 2 -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-600">Science</td>
                                        <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                        <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <button class="text-blue-600 hover:text-blue-700">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                        <path d="m15 5 4 4" />
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 hover:text-red-700">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M3 6h18" />
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Row 3 -->
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-600">Science</td>
                                        <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                        <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3">
                                                <button class="text-blue-600 hover:text-blue-700">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                        <path d="m15 5 4 4" />
                                                    </svg>
                                                </button>
                                                <button class="text-red-600 hover:text-red-700">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M3 6h18" />
                                                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Add more rows as needed -->
                                </tbody>
                            </table>
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

                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">Manage Intake & Closure Date</h1>

                    <div class="max-w-7xl mx-auto">
                        <!-- Intake -->
                        <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg p-8 mb-10">
                            <h1 class="text-2xl md:text-xl font-bold text-gray-900 mb-8">Academic Year & Intake
                                Management</h1>

                            <form class="grid md:grid-cols-2 gap-x-8 gap-y-6">
                                <div class="space-y-2">
                                    <label class="block text-start font-bold text-gray-900">Academic Year</label>
                                    <select
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 text-gray-500 focus:ring-2 focus:ring-gray-200">
                                        <option value="">Select Academic Year . . .</option>
                                        <option value="2024">2024</option>
                                        <option value="2025">2025</option>
                                    </select>
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-start font-bold text-gray-900">Final Closure Date</label>
                                    <input type="text" placeholder="Enter Final Closure Date . . ."
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 text-gray-500 focus:ring-2 focus:ring-gray-200">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-start font-bold text-gray-900">Intake</label>
                                    <input type="text" placeholder="Enter Intake . . ."
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 text-gray-500 focus:ring-2 focus:ring-gray-200">
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-start font-bold text-gray-900">Closure Date</label>
                                    <input type="text" placeholder="Enter Closure Date . . ."
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 text-gray-500 focus:ring-2 focus:ring-gray-200">
                                </div>

                                <div class="md:col-span-2 flex justify-end mt-4">
                                    <button type="submit"
                                        class="px-8 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                                        Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="p-8 bg-white  shadow-lg">
                            <!-- Header -->
                            <h1 class="text-2xl font-bold mb-6">List of Overall Informations ()</h1>

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
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="bg-white rounded-lg overflow-hidden">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Academic
                                                Year</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Intake
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Submission
                                                Closure Date</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Final
                                                Closure Date</th>
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


                                            <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                            <td class="px-6 py-4 text-gray-600">5/7/16</td>

                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-3 py-1 rounded-full text-sm bg-green-50 text-green-700">Active</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <button class="text-blue-600 hover:text-blue-700">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path
                                                                d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                            <path d="m15 5 4 4" />
                                                        </svg>
                                                    </button>
                                                    <button class="text-red-600 hover:text-red-700">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path d="M3 6h18" />
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                        </svg>
                                                    </button>
                                                </div>
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
                                            <td class="px-6 py-4 text-gray-600">Science</td>


                                            <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                            <td class="px-6 py-4 text-gray-600">5/7/16</td>

                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-3 py-1 rounded-full text-sm bg-green-50 text-green-700">Active</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <button class="text-blue-600 hover:text-blue-700">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path
                                                                d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                            <path d="m15 5 4 4" />
                                                        </svg>
                                                    </button>
                                                    <button class="text-red-600 hover:text-red-700">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path d="M3 6h18" />
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                        </svg>
                                                    </button>
                                                </div>
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
                                            <td class="px-6 py-4 text-gray-600">Science</td>


                                            <td class="px-6 py-4 text-gray-600">5/7/16</td>
                                            <td class="px-6 py-4 text-gray-600">5/7/16</td>

                                            <td class="px-6 py-4">
                                                <span
                                                    class="px-3 py-1 rounded-full text-sm bg-green-50 text-green-700">Active</span>
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <button class="text-blue-600 hover:text-blue-700">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path
                                                                d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                            <path d="m15 5 4 4" />
                                                        </svg>
                                                    </button>
                                                    <button class="text-red-600 hover:text-red-700">
                                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path d="M3 6h18" />
                                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                        </svg>
                                                    </button>
                                                </div>
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
