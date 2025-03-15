<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css"
        integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            @include('marketingcoordinator.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            @include('marketingcoordinator.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <div class="space-y-4 mb-4">
                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">Guest Management</h1>
                    <div class="p-8 bg-white  shadow-lg">
                        <!-- Header -->
                        <h1 class="text-xl font-bold mb-6">List of guest</h1>
                        <!-- Search and Filters -->
                        <form action="{{ route('marketingcoordinator.guest-management') }}" method="GET">
                            <div class="flex justify-between mb-8">
                                <div class="relative w-[400px]">
                                    <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    <input type="text" name="search" placeholder="Search..."
                                        class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500"
                                        value="{{ request('search') }}" />
                                </div>

                                <div class="flex gap-4">
                                    <!-- Filter Dropdown -->
                                    <div class="relative group">
                                        <button type="button"
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
                                                <a href="{{ route('marketingcoordinator.guest-management', ['status' => 'active']) }}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Active</a>
                                                <a href="{{ route('marketingcoordinator.guest-management', ['status' => 'inactive']) }}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Inactive</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sort Dropdown -->
                                    <div class="relative group">
                                        <button type="button"
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
                                                <a href="{{ route('marketingcoordinator.guest-management', ['sort' => 'last_login_date', 'order' => 'desc']) }}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Newest</a>
                                                <a href="{{ route('marketingcoordinator.guest-management', ['sort' => 'last_login_date', 'order' => 'asc']) }}"
                                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left">Oldest</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="bg-white rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">User Code
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">User</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Faculty
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Role</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Status
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Last Login
                                                Date</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @if ($guests->isNotEmpty())
                                            @foreach ($guests as $guest)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 text-gray-600">
                                                        {{ $guest->user_code }}
                                                    </td>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-3">
                                                            @if ($guest->profile_image)
                                                                @php
                                                                    $publicPath =
                                                                        'profile_images/' . $guest->profile_image;
                                                                    $storagePath =
                                                                        'storage/profile_images/' .
                                                                        $guest->profile_image;
                                                                @endphp

                                                                @if (file_exists(public_path($publicPath)))
                                                                    <img id="profilePreview"
                                                                        class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                                                        src="{{ asset($publicPath) }}" alt="Profile">
                                                                @elseif (file_exists(public_path($storagePath)))
                                                                    <img id="profilePreview"
                                                                        class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                                                        src="{{ asset($storagePath) }}"
                                                                        alt="Profile">
                                                                @else
                                                                    <p
                                                                        class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                                        {{ strtoupper($guest->username[0]) }}
                                                                    </p>
                                                                @endif
                                                            @else
                                                                <p
                                                                    class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                                    {{ strtoupper($guest->username[0]) }}
                                                                </p>
                                                            @endif
                                                            <div>
                                                                <div class="font-medium">
                                                                    {{ $guest->first_name . ' ' . $guest->last_name }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{ $guest->email }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-gray-600">{{ $guest->faculty->faculty }}
                                                    </td>
                                                    <td class="px-6 py-4 text-gray-600">Guest</td>
                                                    <!-- Hardcoded as "Guest" -->
                                                    <td class="px-6 py-4">
                                                        @if ($guest->status == 1)
                                                            <span
                                                                class="px-3 py-1 rounded-full text-sm bg-[#CAF4E0] text-green-800">Active</span>
                                                        @else
                                                            <span
                                                                class="px-3 py-1 rounded-full text-sm bg-[#FAAFBD] text-red-800">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="px-6 py-4 text-gray-600">
                                                        {{ $guest->last_login_date ?? 'N/A' }}
                                                    </td>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-3">
                                                            <!-- Edit Button -->
                                                            <a href="{{ route('marketingcoordinator.edit-user-data', ['id' => $guest->user_id]) }}"
                                                                class="text-[#2F64AA] hover:text-blue-700">
                                                                <i class="ri-eye-line text-xl"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-24 text-gray-600 text-center" colspan="7">
                                                    No users found.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-end items-center gap-2 mt-6">
                            {{ $guests->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-96">
            <h2 class="text-xl font-bold mb-4">Update Status</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>
                <div class="flex justify-end">
                    <button type="button" onclick="closeEditModal()"
                        class="mr-2 px-4 py-2 bg-gray-300 rounded-lg">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
                </div>
            </form>
        </div>
    </div>


    <!-- JavaScript for Sidebar Toggle and Modal -->
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('translate-x-full');
        });

        // Edit Modal Functions

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function openEditModal(userId, currentStatus) {
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editForm').action = `/marketingcoordinator/guest-management/${userId}`;
            document.getElementById('status').value = currentStatus ? '1' : '0'; // Map boolean to integer
        }
    </script>
</body>

</html>
