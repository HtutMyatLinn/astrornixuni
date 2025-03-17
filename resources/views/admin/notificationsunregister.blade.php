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
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            @include('admin.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <div class="space-y-4 mb-4">
                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">System Notifications & Alerts</h1>
                    <h2 class="text-sm sm:text-lg text-gray-500">Summary of Alerts</h2>
                    <div>
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
                            <!-- Total Students Card -->
                            <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] rounded-lg p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                    <img class="w-5 h-5" src="{{ asset('images/totalstudents.png') }}" alt="">
                                </div>

                                <!-- Stats Container with Flexbox -->
                                <div class="flex items-end justify-between">
                                    <!-- Numbers -->
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold">{{ $total_students->count() }}</h2>
                                        <p class="text-xl text-gray-400">Total Students</p>
                                    </div>

                                    <!-- Percentage -->
                                    <div class="flex items-center gap-1">
                                        @if ($student_percentage_change > 0)
                                            <span
                                                class="text-emerald-500 text-xl font-medium">{{ $student_percentage_change }}%
                                                ↑</span>
                                        @elseif ($student_percentage_change < 0)
                                            <span
                                                class="text-red-500 text-xl font-medium">{{ abs($student_percentage_change) }}%
                                                ↓</span>
                                        @else
                                            <span class="text-gray-500 text-xl font-medium">0%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Total submissions Card -->
                            <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] rounded-lg p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                    <img class="w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}"
                                        alt="">
                                </div>

                                <!-- Stats Container with Flexbox -->
                                <div class="flex items-end justify-between">
                                    <!-- Numbers -->
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold">{{ $inquiries->count() }}</h2>
                                        <p class="text-xl text-gray-400">New Inquiries</p>
                                    </div>

                                    <!-- Percentage -->
                                    <div class="flex items-center gap-1">
                                        @if ($inquiry_percentage_change > 0)
                                            <span
                                                class="text-emerald-500 text-xl font-medium">{{ $inquiry_percentage_change }}%
                                                ↑</span>
                                        @elseif ($inquiry_percentage_change < 0)
                                            <span
                                                class="text-red-500 text-xl font-medium">{{ abs($inquiry_percentage_change) }}%
                                                ↓</span>
                                        @else
                                            <span class="text-gray-500 text-xl font-medium">0%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Total Pending Contributions Card -->
                            <div
                                class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] rounded-lg col-span-0 sm:col-span-2 lg:col-span-1 p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                    <img class="w-5 h-5" src="{{ asset('images/totalpendingcontributions.png') }}"
                                        alt="">
                                </div>

                                <!-- Stats Container with Flexbox -->
                                <div class="flex items-end justify-between">
                                    <!-- Numbers -->
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold">{{ $unassigned_users->count() }}</h2>
                                        <p class="text-xl text-gray-400">Unassigned Users</p>
                                    </div>

                                    <!-- Percentage -->
                                    <div class="flex items-center gap-1">
                                        @if ($unassigned_user_percentage_change > 0)
                                            <span
                                                class="text-emerald-500 text-xl font-medium">{{ $unassigned_user_percentage_change }}%
                                                ↑</span>
                                        @elseif ($unassigned_user_percentage_change < 0)
                                            <span
                                                class="text-red-500 text-xl font-medium">{{ abs($unassigned_user_percentage_change) }}%
                                                ↓</span>
                                        @else
                                            <span class="text-gray-500 text-xl font-medium">0%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <h2 class="text-sm sm:text-lg text-gray-500 mb-10">All System Notifications</h2>
                        <div class="p-8 bg-white  shadow-lg">
                            <!-- Header -->
                            <h1 class="text-2xl font-bold mb-6">List of Notifications</h1>
                            <h2 class=" text-lg font-semibold text-gray-400 mb-4">
                                Total - {{ $users->count() }}
                            </h2>

                            <!-- Tabs -->
                            <div class="flex gap-8 border-b mb-6">
                                <a href="{{ route('admin.notifications.inquiry') }}"
                                    class="px-1 py-4 text-gray-600 hover:text-gray-900">
                                    Inquiry
                                </a>
                                <a href="{{ route('admin.notifications.password-reset') }}"
                                    class="px-1 py-4 text-gray-600 hover:text-gray-900">
                                    Password Reset
                                </a>
                                <a href="{{ route('admin.notifications.unregister-user') }}"
                                    class="px-1 py-4  hover:text-gray-900 text-[#4353E1] border-b-4 border-[#4353E1]">
                                    Unassigned User
                                </a>
                            </div>


                            <!-- Search and Filters -->
                            <div class="flex flex-col md:flex-row gap-4 md:gap-0 justify-between mb-8">
                                <div class="relative max-w-[400px]">
                                    <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    <form method="GET"
                                        action="{{ route('admin.notifications.unregister-user.search') }}">
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Search..."
                                            class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                                    </form>
                                </div>

                                <div class="flex gap-4">
                                    <!-- Sort Dropdown -->
                                    <form method="GET" action="{{ route('admin.notifications.unregister-user') }}">
                                        <select name="sort" onchange="this.form.submit()"
                                            class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>
                                                Newest First</option>
                                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>
                                                Oldest First</option>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="bg-white rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-[#F9F8F8]">
                                            <tr>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">User
                                                    Code
                                                </th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">User
                                                </th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Notification Type
                                                </th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Date
                                                    &
                                                    Time</th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @if ($users->isNotEmpty())
                                                @foreach ($users as $user)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-6 py-4 text-gray-600">
                                                            {{ $user->user_code }}
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center gap-3">
                                                                <p
                                                                    class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                                    {{ strtoupper($user->username[0]) }}
                                                                </p>
                                                                <div>
                                                                    <div class="font-medium">
                                                                        {{ $user->first_name . ' ' . $user->last_name }}
                                                                    </div>
                                                                    <div class="text-sm text-gray-500">
                                                                        {{ $user->email }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 text-gray-600">
                                                            Unassigned User
                                                        </td>
                                                        <td class="px-6 py-4 text-gray-600">
                                                            {{ optional($user->created_at)->format('M d, Y') ?? 'N/A' }}
                                                            <p class="text-gray-400">
                                                                {{ optional($user->created_at)->format('h:m') ?? 'N/A' }}
                                                            </p>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center gap-3">
                                                                <a href="{{ route('admin.edit-user-data', ['id' => $user->user_id]) }}"
                                                                    class="text-[#2F64AA] hover:text-blue-700">
                                                                    Assign Role
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-24 text-gray-600 text-center" colspan="5">
                                                        No users found.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            @if ($users->isNotEmpty())
                                <div class="flex justify-end items-center gap-2 mt-6">
                                    {{ $users->appends(request()->query())->links('pagination::tailwind') }}
                                </div>
                            @endif
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
