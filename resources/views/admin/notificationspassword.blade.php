<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                                </div>
                            </div>
                            <!-- Total Pending Contributions Card -->
                            <div
                                class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] rounded-lg col-span-0 sm:col-span-2 lg:col-span-1 p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                    <img class="w-5 h-5" src="{{ asset('images/totaluser.png') }}" alt="">
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
                                Total - {{ $reset_password_users->count() }}
                            </h2>

                            {{-- Message --}}
                            @if (session('success'))
                            <div id="success-message"
                                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-3 rounded relative"
                                role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>

                            <script>
                                setTimeout(() => {
                                    document.getElementById('success-message').style.display = 'none';
                                }, 5000);
                            </script>
                            @endif

                            <!-- Tabs -->
                            <div class="flex gap-8 border-b mb-6">
                                <a href="{{ route('admin.notifications.inquiry') }}"
                                    class="px-1 py-4 text-gray-600 hover:text-gray-900">
                                    Inquiry
                                </a>
                                <a href="{{ route('admin.notifications.password-reset') }}"
                                    class="px-1 py-4  hover:text-gray-900 text-[#4353E1] border-b-4 border-[#4353E1]">
                                    Password Reset
                                </a>
                                <a href="{{ route('admin.notifications.unregister-user') }}"
                                    class="px-1 py-4 text-gray-600 hover:text-gray-900">
                                    Unassigned User
                                </a>
                            </div>
                            <form method="GET" action="{{ route('admin.notifications.password-reset') }}">
                                <div class="flex flex-col md:flex-row gap-4 md:gap-0 justify-between mb-8">
                                    <!-- Search Input -->
                                    <div class="relative max-w-[400px]">
                                        <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8" />
                                            <path d="m21 21-4.3-4.3" />
                                        </svg>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Search..."
                                            class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                                    </div>

                                    <!-- Sort Option -->
                                    <select name="sort" onchange="this.form.submit()"
                                        class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>
                                            Newest</option>
                                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>
                                            Oldest</option>
                                    </select>
                                </div>
                            </form>

                            <!-- Table -->
                            <div class="bg-white rounded-lg overflow-hidden">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">User Code
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">User
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Faculty
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Role
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Request
                                                Date & Time
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @if ($reset_password_users->isNotEmpty())
                                        @foreach ($reset_password_users as $reset_password_user)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $reset_password_user->user->user_code }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    @if ($reset_password_user->user->profile_image)
                                                    <img id="profilePreview"
                                                        class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                                        src="{{ asset('profile_images/' . $reset_password_user->user->profile_image) }}"
                                                        alt="Profile">
                                                    @else
                                                    <p
                                                        class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                        {{ strtoupper($reset_password_user->user->username[0]) }}
                                                    </p>
                                                    @endif
                                                    <div>
                                                        <div class="font-medium">
                                                            {{ $reset_password_user->user->first_name . ' ' . $reset_password_user->user->last_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $reset_password_user->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ optional($reset_password_user->user->faculty)->faculty ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ optional($reset_password_user->user->role)->role ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ optional($reset_password_user->created_at)->format('M d, Y') ?? 'N/A' }}
                                                <p class="text-gray-400">
                                                    {{ optional($reset_password_user->created_at)->format('h:i A') }}
                                                </p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <a href="#"
                                                    class="text-blue-600 hover:text-blue-700 reset-password-btn"
                                                    data-user-id="{{ $reset_password_user->user->user_id }}"
                                                    data-user-email="{{ $reset_password_user->user->email }}"
                                                    data-user-name="{{ $reset_password_user->user->first_name }} {{ $reset_password_user->user->last_name }}">
                                                    Reset Password
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
                        @if ($reset_password_users->isNotEmpty())
                        <div class="flex justify-end items-center gap-2 mt-6">
                            {{ $reset_password_users->appends(request()->query())->links('pagination::tailwind') }}
                        </div>
                        @endif
                    </div>

                    <!-- Password Reset Modal -->
                    <div id="resetPasswordModal"
                        class="fixed inset-0 z-50 flex items-center justify-center opacity-0 invisible p-2 -translate-y-5 transition-all duration-300">
                        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                            <h2 class="text-xl font-semibold mb-4">Reset Password</h2>
                            <form id="resetPasswordForm" method="POST"
                                action="{{ route('admin.reset-password') }}">
                                @csrf
                                <input type="hidden" id="resetUserId" name="user_id">

                                <div class="mb-4">
                                    <p class="text-gray-600">A secure password will be automatically generated and
                                        emailed to the user.</p>
                                </div>

                                <div class="flex justify-end mt-4">
                                    <button type="button" id="closeModal"
                                        class="mr-2 px-4 py-2 bg-gray-400 text-white rounded-lg">Cancel</button>
                                    <button type="submit" id="resetButton"
                                        class="px-4 py-2 bg-black text-white rounded-lg flex items-center justify-center">
                                        <span id="resetButtonText">Reset</span>
                                        <svg id="resetSpinner"
                                            class="animate-spin -mr-1 ml-2 h-4 w-4 text-white hidden"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            const resetButtons = document.querySelectorAll(".reset-password-btn");
                            const modal = document.getElementById("resetPasswordModal");
                            const closeModal = document.getElementById("closeModal");
                            const userIdInput = document.getElementById("resetUserId");
                            const resetForm = document.getElementById("resetPasswordForm");
                            const resetButton = document.getElementById("resetButton");
                            const resetButtonText = document.getElementById("resetButtonText");
                            const resetSpinner = document.getElementById("resetSpinner");

                            // Get the dark overlay element (make sure this exists in your HTML)
                            const darkOverlay2 = document.getElementById("darkOverlay2"); // Add this if missing

                            resetButtons.forEach(button => {
                                button.addEventListener("click", function(event) {
                                    event.preventDefault();
                                    const userId = this.getAttribute("data-user-id");
                                    userIdInput.value = userId;

                                    // Show the modal
                                    if (darkOverlay2) {
                                        darkOverlay2.classList.remove('opacity-0', 'invisible');
                                        darkOverlay2.classList.add('opacity-100');
                                    }
                                    modal.classList.remove('opacity-0', 'invisible', '-translate-y-5');
                                });
                            });

                            closeModal.addEventListener("click", function() {
                                if (darkOverlay2) {
                                    darkOverlay2.classList.add('opacity-0', 'invisible');
                                    darkOverlay2.classList.remove('opacity-100');
                                }
                                modal.classList.add('opacity-0', 'invisible', '-translate-y-5');
                            });

                            resetForm.addEventListener("submit", function(e) {
                                e.preventDefault();

                                // Show loading state
                                resetButton.disabled = true;
                                resetButtonText.textContent = "Resetting...";
                                resetSpinner.classList.remove('hidden');

                                fetch(this.action, {
                                        method: 'POST',
                                        headers: {
                                            'Accept': 'application/json',
                                            'X-Requested-With': 'XMLHttpRequest',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                        },
                                        body: new FormData(this)
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error('Network response was not ok');
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            // Close modal on success
                                            if (darkOverlay2) {
                                                darkOverlay2.classList.add('opacity-0', 'invisible');
                                                darkOverlay2.classList.remove('opacity-100');
                                            }
                                            modal.classList.add('opacity-0', 'invisible', '-translate-y-5');

                                            // Reload the page or update UI as needed
                                            window.location.reload();
                                        } else {
                                            alert(data.message || 'An error occurred');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('An error occurred while resetting the password.');
                                    })
                                    .finally(() => {
                                        // Reset button state
                                        resetButton.disabled = false;
                                        resetButtonText.textContent = "Reset";
                                        resetSpinner.classList.add('hidden');
                                    });
                            });
                        });

                        // Password toggle function (if you keep it for other forms)
                        function togglePassword(fieldId, icon) {
                            const field = document.getElementById(fieldId);
                            if (field.type === "password") {
                                field.type = "text";
                                icon.innerHTML = '<i class="ri-eye-line"></i>';
                            } else {
                                field.type = "password";
                                icon.innerHTML = '<i class="ri-eye-off-line"></i>';
                            }
                        }
                    </script>
                </div>
            </main>
        </div>
    </div>

    <!-- Dark Overlay -->
    <div id="darkOverlay2"
        class="fixed inset-0 bg-black bg-opacity-50 opacity-0 invisible  z-40 transition-opacity duration-300">
    </div>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('translate-x-full');
        });
    </script>
</body>

</html>
