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
            @include('admin.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F1F5F9] lg:ml-64">
            @include('admin.header')

            <!-- Main Content Container -->
            <div class="p-8 bg-white m-5 shadow-lg">
                <!-- Header -->
                <h1 class="text-2xl font-bold mb-6">List of Users</h1>
                <h2 class=" text-lg font-semibold text-gray-400 mb-4">
                    Total - {{ $marketing_managers->count() }}
                </h2>

                <!-- Tabs -->
                <div class="flex gap-8 border-b mb-6 overflow-x-auto whitespace-nowrap">
                    <a href="{{ route('admin.user-management') }}" class="px-1 py-4 hover:text-gray-900">
                        Admin
                    </a>
                    <a href="{{ route('admin.user-management.student') }}"
                        class="px-1 py-4 text-gray-600 hover:text-gray-900">
                        Student
                    </a>
                    <a href="{{ route('admin.user-management.marketing-coordinator') }}"
                        class="px-1 py-4 text-gray-600 hover:text-gray-900">
                        Marketing Coordinator
                    </a>
                    <a href="{{ route('admin.user-management.marketing-manager') }}"
                        class="px-1 py-4 text-gray-600 hover:text-gray-900">
                        Marketing Manager
                    </a>
                    <a href="{{ route('admin.user-management.faculty-guest') }}"
                        class="px-1 py-4 text-[#4353E1] border-b-4 border-[#4353E1] hover:text-gray-900">
                        Faculty Guest
                    </a>
                    <a href="{{ route('admin.user-management.most-active-user') }}"
                        class="px-1 py-4 text-gray-600 hover:text-gray-900">
                        Most Active Users
                    </a>
                </div>

                <!-- Search and Filters -->
                <form method="GET" action="{{ route('admin.user-management.marketing-manager.search') }}">
                    <div class="flex flex-col md:flex-row gap-4 md:gap-0 justify-between mb-8">
                        <!-- Search Input -->
                        <div class="relative max-w-[400px]">
                            <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search..."
                                class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                        </div>

                        <!-- Sort Dropdown -->
                        <div class="flex gap-4">
                            <select name="sort" onchange="this.form.submit()"
                                class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest Login
                                </option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest Login
                                </option>
                            </select>
                        </div>
                    </div>
                </form>

                <!-- Table -->
                <div class="bg-white rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-[#F9F8F8]">
                                <tr>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">User Code</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">User</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Faculty</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Role</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Status</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Last Login Date
                                    </th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @if ($marketing_managers->isNotEmpty())
                                    @foreach ($marketing_managers as $marketing_manager)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $marketing_manager->user_code }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    @if ($marketing_manager->profile_image)
                                                        <img id="profilePreview"
                                                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                                            src="{{ asset('storage/profile_images/' . $marketing_manager->profile_image) }}"
                                                            alt="Profile">
                                                    @else
                                                        <p
                                                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                            {{ strtoupper($marketing_manager->username[0]) }}
                                                        </p>
                                                    @endif
                                                    <div>
                                                        <div class="font-medium">
                                                            {{ $marketing_manager->first_name . ' ' . $marketing_manager->last_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $marketing_manager->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ optional($marketing_manager->faculty)->faculty ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ optional($marketing_manager->role)->role ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($marketing_manager->status == 1)
                                                    <span
                                                        class="px-3 py-1 rounded-full text-sm bg-[#CAF4E0] text-green-800">Active</span>
                                                @else
                                                    <span
                                                        class="px-3 py-1 rounded-full text-sm bg-[#FAAFBD] text-red-800">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $marketing_manager->last_login_date ? \Carbon\Carbon::parse($marketing_manager->last_login_date)->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="{{ route('admin.edit-user-data', ['id' => $marketing_manager->user_id]) }}"
                                                    class="text-blue-600 hover:text-blue-700">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                        <path d="m15 5 4 4" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-24 text-gray-600 text-center" colspan="6">
                                            No users found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($marketing_managers->isNotEmpty())
                    <div class="flex justify-end items-center gap-2 mt-6">
                        {{ $marketing_managers->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @endif

            </div>
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
