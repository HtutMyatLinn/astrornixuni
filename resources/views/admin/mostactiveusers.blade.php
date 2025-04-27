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
                    Total - {{ $users->count() }}
                </h2>

                <!-- Tabs -->
                <div class="flex gap-8 border-b mb-6">
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
                        class="px-1 py-4 text-gray-600 hover:text-gray-900">
                        Faculty Guest
                    </a>
                    <a href="{{ route('admin.user-management.most-active-user') }}"
                        class="px-1 py-4 hover:text-gray-900 text-[#4353E1] border-b-4 border-[#4353E1]">
                        Most Active Users
                    </a>
                </div>

                <form method="GET" action="{{ route('admin.user-management.mostactiveuser.search') }}">
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

                        <div class="flex flex-wrap gap-4">
                            <!-- Role Filter -->
                            <select name="role" onchange="this.form.submit()"
                                class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                <option value="">All Roles</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->role_id }}"
                                        {{ request('role') == $role->role_id ? 'selected' : '' }}>
                                        {{ $role->role }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Sort Option -->
                            <select name="sort" onchange="this.form.submit()"
                                class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Most Active
                                </option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Least Active
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
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Total Login</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @if ($users->isNotEmpty())
                                    @foreach ($users as $student)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $student->user_code }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    @if ($student->profile_image)
                                                        @php
                                                            $publicPath = 'profile_images/' . $student->profile_image;
                                                            $storagePath =
                                                                'storage/profile_images/' . $student->profile_image;
                                                        @endphp

                                                        @if (file_exists(public_path($publicPath)))
                                                            <img id="profilePreview"
                                                                class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                                                src="{{ asset($publicPath) }}" alt="Profile">
                                                        @elseif (file_exists(public_path($storagePath)))
                                                            <img id="profilePreview"
                                                                class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                                                src="{{ asset($storagePath) }}" alt="Profile">
                                                        @else
                                                            <p
                                                                class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                                {{ strtoupper($student->username[0]) }}
                                                            </p>
                                                        @endif
                                                    @else
                                                        <p
                                                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                            {{ strtoupper($student->username[0]) }}
                                                        </p>
                                                    @endif
                                                    <div>
                                                        <div class="font-medium">
                                                            {{ $student->first_name . ' ' . $student->last_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $student->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ optional($student->faculty)->faculty ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                {{ optional($student->role)->role ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $student->login_count }}
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

                @if ($users->isNotEmpty())
                    <div class="flex justify-end items-center gap-2 mt-6">
                        {{ $users->appends(request()->query())->links('pagination::tailwind') }}
                        <!-- Paginate the links -->
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
