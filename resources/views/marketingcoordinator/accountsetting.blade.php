<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 50;
            justify-content: center;
            align-items: center;
        }

        .modal.active {
            display: flex;
        }
    </style>

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

            <!-- account setting -->
            <div class="container mx-auto p-4">
                <form action="{{ route('admin.update-account-setting', Auth::user()->user_id) }}" method="POST"
                    enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6 md:p-8">
                    @csrf

                    <h2 class="text-2xl font-medium mb-6">My Account</h2>

                    <div class="flex flex-col md:flex-row items-start gap-5 mb-8">
                        @if (Auth::check())
                            @if (Auth::user()->profile_image)
                                <!-- Check if profile_image exists -->
                                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden">
                                    <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="Profile Image"
                                        class="w-full h-full object-cover">
                                </div>
                            @else
                                <!-- Fallback to initials if profile_image is null -->
                                <p
                                    class="m-0 w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-2xl sm:text-3xl">
                                    {{ strtoupper(Auth::user()->username[0]) }}
                                </p>
                            @endif
                        @else
                            <!-- Guest user -->
                            <div class="w-24 h-24 select-none">
                                <img src="{{ asset('images/guest.jpg') }}" alt="Guest Profile"
                                    class="w-full h-full rounded-full object-cover">
                            </div>
                        @endif
                        <div>
                            <h3 class="text-xl font-medium">{{ Auth::user()->username }}</h3>
                            <p class="text-gray-600">{{ Auth::user()->role->role }}</p>
                        </div>
                        @if (Auth::user()->status == 1)
                            <span class="px-10 py-1 rounded-lg bg-[#CAF4E0] text-green-800">Active</span>
                        @else
                            <span class="px-10 py-1 rounded-lg bg-[#FAAFBD] text-red-800">Inactive</span>
                        @endif
                    </div>

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
                            }, 3000);
                        </script>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative">
                            <label for="firstName" class="block mb-2 font-medium">First Name</label>
                            <input type="text" id="firstName" name="first_name"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50 @error('first_name') border-red-500 @enderror"
                                value="{{ Auth::user()->first_name }}">
                            <div class="absolute left-2 -bottom-2 bg-white">
                                @error('first_name')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="relative">
                            <label for="lastName" class="block mb-2 font-medium">Last Name</label>
                            <input type="text" id="lastName" name="last_name"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50 @error('last_name') border-red-500 @enderror"
                                value="{{ Auth::user()->last_name }}">
                            <div class="absolute left-2 -bottom-2 bg-white">
                                @error('last_name')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="relative">
                            <label for="userName" class="block mb-2 font-medium">User Name</label>
                            <input type="text" id="userName" name="username"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50 @error('username') border-red-500 @enderror"
                                value="{{ Auth::user()->username }}">
                            <div class="absolute left-2 -bottom-2 bg-white">
                                @error('username')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label for="role" class="block mb-2 font-medium">Role</label>
                            <input type="text" id="role"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->role->role }}" disabled>
                        </div>

                        <div>
                            <label for="faculty" class="block mb-2 font-medium">Faculty</label>
                            @if (optional(Auth::user()->faculty)->faculty)
                                <input type="text" id="faculty"
                                    class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                    value="{{ Auth::user()->faculty->faculty }}" disabled>
                            @else
                                <input type="text" id="faculty"
                                    class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                    value="No faculty assigned" disabled>
                            @endif
                        </div>

                        <div>
                            <label for="email" class="block mb-2 font-medium">Email</label>
                            <input type="email" id="email"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->email }}" disabled>
                        </div>

                        <div>
                            <label for="password" class="block mb-2 font-medium">Password</label>
                            <input type="password" id="password"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50" value="**********"
                                disabled>
                            <button id="changePasswordBtn"
                                class="text-[#4353E1] mt-2 border-b border-[#4353E1]">Change
                                Your Password ?</button>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="bg-gray-800 hover:bg-gray-900 text-white py-3 px-8 rounded-md">Save</button>
                    </div>
                </form>
            </div>

            <!-- Password Change Modal -->
            <div id="passwordModal" class="modal">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
                    <h2 class="text-2xl font-bold mb-6 ">
                        <span class="border-b-4 border-[#4353E1]">
                            Change
                        </span> Your Password
                    </h2>

                    <form action="" method="post" class="space-y-6">
                        @csrf
                        <div>
                            <label for="oldPassword" class="block mb-2 font-medium">Old Password</label>
                            <input type="password" id="oldPassword" placeholder="Enter Current Password"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50">
                        </div>

                        <div>
                            <label for="newPassword" class="block mb-2 font-medium">New Password</label>
                            <input type="password" id="newPassword" placeholder="Enter New Password"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50">
                        </div>

                        <div>
                            <label for="confirmPassword" class="block mb-2 font-medium">Confirm New Password</label>
                            <input type="password" id="confirmPassword" placeholder="Enter New Password Again"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50">
                        </div>

                        <div class="flex justify-center mt-6">
                            <button id="savePasswordBtn"
                                class="bg-gray-800 hover:bg-gray-900 text-white py-3 px-8 rounded-md">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle -->

    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
        const modal = document.getElementById('passwordModal');
        const changePasswordBtn = document.getElementById('changePasswordBtn');
        const savePasswordBtn = document.getElementById('savePasswordBtn');

        // Open modal when change password button is clicked
        changePasswordBtn.addEventListener('click', function() {
            modal.classList.add('active');
        });

        // Close modal when save button is clicked
        savePasswordBtn.addEventListener('click', function() {
            modal.classList.remove('active');
        });

        // Close modal when clicking outside the modal content
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });
    </script>
</body>

</html>
