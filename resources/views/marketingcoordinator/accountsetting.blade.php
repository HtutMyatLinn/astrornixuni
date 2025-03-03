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
        @include('marketingcoordinator.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @include('marketingcoordinator.header')
            <!-- account setting -->
            <div class="container mx-auto p-4">
                <h1 class="text-4xl font-bold mb-6">Setting</h1>

                <div class="bg-white rounded-lg shadow-md p-6 md:p-8">
                    <h2 class="text-2xl font-medium mb-6">My Account</h2>

                    <div class="flex flex-col md:flex-row items-start mb-8">
                        <div class="w-24 h-24 rounded-full overflow-hidden mb-4 md:mb-0 md:mr-6">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/7/7c/Profile_avatar_placeholder_large.png?20150327203541"
                                alt="Profile" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="text-xl font-medium">Zaw Zaw</h3>
                            <p class="text-gray-600">Marketing Coordinator</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="firstName" class="block mb-2 font-medium">First Name</label>
                            <input type="text" id="firstName"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->first_name }}">
                        </div>

                        <div>
                            <label for="lastName" class="block mb-2 font-medium">Last Name</label>
                            <input type="text" id="lastName"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->last_name }}">
                        </div>

                        <div>
                            <label for="userName" class="block mb-2 font-medium">User Name</label>
                            <input type="text" id="userName"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->username }}">
                        </div>

                        <div>
                            <label for="role" class="block mb-2 font-medium">Role</label>
                            <input type="text" id="role"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->role->role }}">
                        </div>

                        <div>
                            <label for="faculty" class="block mb-2 font-medium">Faculty</label>
                            <input type="text" id="faculty"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ optional(Auth::user()->faculty)->faculty }}">
                        </div>

                        <div>
                            <label for="status" class="block mb-2 font-medium">Status</label>
                            <input type="text" id="status"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->status }}">
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
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->password }}" disabled>
                            <button id="changePasswordBtn" class="text-[#4353E1] mt-2 border-b border-[#4353E1]">Change
                                Your Password ?</button>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button class="bg-gray-800 hover:bg-gray-900 text-white py-3 px-8 rounded-md">Save</button>
                    </div>
                </div>
            </div>

            <!-- Password Change Modal -->
            <div id="passwordModal" class="modal">
                <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md mx-4">
                    <h2 class="text-2xl font-bold mb-6 ">
                        <span class="border-b-4 border-[#4353E1]">
                            Change
                        </span> Your Password
                    </h2>

                    <div class="space-y-6">
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
                    </div>
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
