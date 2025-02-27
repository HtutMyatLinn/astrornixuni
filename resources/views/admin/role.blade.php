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
        @include('admin.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @include('admin.header')

            <div class="p-8 bg-white m-5 shadow-lg">

                <div class="flex items-center justify-between mb-6">
                    <!-- Header -->
                    <h1 class="text-2xl font-bold">List of Roles ({{ $roles->count() }})</h1>
                    <!-- Add Role Button -->
                    <div class="flex justify-center mt-8">
                        <button onclick="openModal()"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Add Role
                        </button>
                    </div>
                </div>

                <!-- Search and Filters -->
                <div class="flex justify-between mb-8">
                    <div class="relative w-[400px]">
                        <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
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
                                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
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
                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Role</th>
                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Funtionalities</th>
                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Added Date</th>
                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Updated Date</th>
                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <!-- Row 1 -->

                            @if ($roles->isNotEmpty())
                                @foreach ($roles as $role)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-gray-600">{{ $role->role }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $role->functionalities }}</td>
                                        <td class="px-6 py-4 text-gray-600">{{ $role->created_at->format('M d,Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600">{{ $role->updated_at->format('M d,Y') }}
                                        </td>
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
                                @endforeach
                            @else
                                <p>No roles found.</p>
                            @endif
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex justify-end items-center gap-2 mt-6">
                    <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">1</button>
                    <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">2</button>
                    <span class="text-gray-600">...</span>
                    <button class="px-4 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100">Next</button>
                </div>
            </div>

            <!-- Add New Role Modal -->
            <div class="flex justify-center items-center mt-24 w-full">
                <!-- Modal -->
                <div id="roleModal"
                    class="fixed inset-0 z-50 flex items-center justify-center opacity-0 invisible p-2 -translate-y-5 transition-all duration-300">
                    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-lg relative">
                        <button onclick="closeModal()" class="absolute top-2 right-2 text-black">
                            ✖
                        </button>

                        <h1 class="text-2xl font-bold text-center mb-6">
                            Add <span class="border-b-2 border-blue-600">New</span> Role
                        </h1>

                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf

                            <!-- Role Name Input -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-2">Role Name :</label>
                                <input type="text" name="role" value="{{ old('role') }}"
                                    placeholder="Enter role name..."
                                    class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg
                focus:outline-none focus:ring-2 focus:ring-blue-500 @error('role') border-red-500 @enderror">

                                @error('role')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Functionalities Input -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium mb-2">Functionalities :</label>
                                <textarea name="functionalities" placeholder="Enter functionalities..."
                                    class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg
                focus:outline-none focus:ring-2 focus:ring-blue-500 @error('functionalities') border-red-500 @enderror">{{ old('functionalities') }}</textarea>

                                @error('functionalities')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="px-12 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- JavaScript for Modal -->
            <script>
                function openModal() {
                    darkOverlay2.classList.remove('opacity-0', 'invisible');
                    darkOverlay2.classList.add('opacity-100');
                    document.getElementById('roleModal').classList.remove('opacity-0', 'invisible', '-translate-y-5');
                }

                function closeModal() {
                    darkOverlay2.classList.add('opacity-0', 'invisible');
                    darkOverlay2.classList.remove('opacity-100');
                    document.getElementById('roleModal').classList.add('opacity-0', 'invisible', '-translate-y-5');
                }

                // Keep modal open if validation errors exist
                window.onload = function() {
                    @if ($errors->any())
                        openModal();
                    @endif
                };
            </script>
        </div>

        <!-- Dark Overlay -->
        <div id="darkOverlay2"
            class="fixed inset-0 bg-black bg-opacity-50 opacity-0 invisible  z-40 transition-opacity duration-300">
        </div>

        <!-- JavaScript for Sidebar Toggle -->
        <script>
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('-translate-x-full');
            });
        </script>
</body>

</html>
