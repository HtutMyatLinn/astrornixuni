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

        .profile-image-container {
            cursor: pointer;
            position: relative;
        }

        .profile-image-overlay {
            position: absolute;
            inset: 0;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .profile-image-container:hover .profile-image-overlay {
            opacity: 1;
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }

        .password-toggle:hover {
            color: #4b5563;
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

            <!-- Account Setting -->
            <div class="container mx-auto p-4">
                <form action="{{ route('marketingcoordinator.update-account-setting', Auth::user()->user_id) }}" method="POST"
                    enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6 md:p-8">
                    @csrf

                    <h2 class="text-2xl font-medium mb-6">My Account</h2>

                    <div class="flex flex-col md:flex-row items-start gap-5 mb-8">
                        @if (Auth::check())
                        <!-- Profile Image Container - Made Clickable -->
                        <div class="profile-image-container w-20 h-20 sm:w-24 sm:h-24 rounded-full overflow-hidden">
                            @if (Auth::user()->profile_image)
                            <img id="profileImagePreview"
                                src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}"
                                alt="Profile Image" class="w-full h-full object-cover">
                            @else
                            <!-- Fallback to initials if profile_image is null -->
                            <div id="profileInitials"
                                class="w-full h-full rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-2xl sm:text-3xl">
                                {{ strtoupper(Auth::user()->username[0]) }}
                            </div>
                            @endif
                            <!-- Overlay with camera icon -->
                            <div class="profile-image-overlay">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <!-- Hidden file input for profile image -->
                        <input type="file" id="profile_image" name="profile_image" class="hidden">
                        @error('profile_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
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
                        <span class="px-10 py-1 rounded-lg bg-[#CAF4E0] text-green-800 select-none">Active</span>
                        @else
                        <span class="px-10 py-1 rounded-lg bg-[#FAAFBD] text-red-800 select-none">Inactive</span>
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
                        <!-- First Name -->
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

                        <!-- Last Name -->
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

                        <!-- Username -->
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

                        <!-- Role -->
                        <div>
                            <label for="role" class="block mb-2 font-medium">Role</label>
                            <input type="text" id="role"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->role->role }}" disabled>
                        </div>

                        <!-- Faculty -->
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

                        <!-- Email -->
                        <div>
                            <label for="email" class="block mb-2 font-medium">Email</label>
                            <input type="email" id="email"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50"
                                value="{{ Auth::user()->email }}" disabled>
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block mb-2 font-medium">Password</label>
                            <input type="password" id="password"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50" value="**********"
                                disabled>
                            <button id="changePasswordBtn" type="button"
                                class="text-[#4353E1] mt-2 border-b border-[#4353E1]">Change
                                Your Password ?</button>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="bg-gray-800 hover:bg-gray-900 text-white py-3 px-8 rounded-md select-none">Save</button>
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

                    <form action="{{ route('marketingcoordinator.change-password') }}" method="POST" class="space-y-6"
                        id="passwordForm">
                        @csrf
                        <div>
                            <label for="oldPassword" class="block mb-2 font-medium">Old Password</label>
                            <input type="password" id="oldPassword" name="old_password"
                                placeholder="Enter Current Password"
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50 @error('old_password') border-red-500 @enderror">
                            @error('old_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="password-container relative">
                            <label for="newPassword" class="block mb-2 font-medium">New Password</label>
                            <div class="relative">
                                <input type="password" id="newPassword" name="new_password"
                                    placeholder="Enter New Password"
                                    class="w-full p-3 rounded-md border border-gray-200 bg-gray-50 @error('new_password') border-red-500 @enderror">
                                <span
                                    class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                                    id="newPasswordToggle">
                                    <!-- Eye Icon (Show Password) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <!-- Eye-Off Icon (Hide Password) - Initially Hidden -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed hidden"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </span>
                            </div>
                            @error('new_password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            <p id="passwordError" class="text-red-500 text-sm mt-1 hidden">Passwords do not match.</p>
                        </div>

                        <div class="password-container relative">
                            <label for="confirmPassword" class="block mb-2 font-medium">Confirm New Password</label>
                            <div class="relative">
                                <input type="password" id="confirmPassword" name="new_password_confirmation"
                                    placeholder="Enter New Password Again"
                                    class="w-full p-3 rounded-md border border-gray-200 bg-gray-50">
                                <span
                                    class="password-toggle absolute right-3 top-1/2 transform -translate-y-1/2 cursor-pointer"
                                    id="confirmPasswordToggle">
                                    <!-- Eye Icon (Show Password) -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <!-- Eye-Off Icon (Hide Password) - Initially Hidden -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed hidden"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="flex justify-center mt-6">
                            <button type="submit" id="savePasswordBtn"
                                class="bg-gray-800 hover:bg-gray-900 text-white py-3 px-8 rounded-md">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle and Modal -->
    <script>
        // Sidebar Toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });

        // Password Modal
        const modal = document.getElementById('passwordModal');
        const changePasswordBtn = document.getElementById('changePasswordBtn');

        // Open modal when change password button is clicked
        changePasswordBtn.addEventListener('click', function() {
            modal.classList.add('active');
        });

        // Close modal when clicking outside the modal content
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.classList.remove('active');
            }
        });

        // Profile Image Click Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const profileImageContainer = document.querySelector('.profile-image-container');
            const profileImageInput = document.getElementById('profile_image');

            if (profileImageContainer && profileImageInput) {
                // When the profile image is clicked, trigger the file input
                profileImageContainer.addEventListener('click', function() {
                    profileImageInput.click();
                });

                // Preview the selected image
                profileImageInput.addEventListener('change', function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const initials = document.getElementById('profileInitials');
                            const preview = document.getElementById('profileImagePreview');

                            if (preview) {
                                // Update existing image
                                preview.src = e.target.result;
                            } else if (initials) {
                                // Replace initials with image
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.id = 'profileImagePreview';
                                img.alt = 'Profile Image';
                                img.className = 'w-full h-full object-cover';

                                // Replace initials with the new image
                                initials.parentNode.replaceChild(img, initials);
                            }
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                });
            }

            // Password Toggle Functionality
            function setupPasswordToggle(toggleId, inputId) {
                const toggle = document.getElementById(toggleId);
                const input = document.getElementById(inputId);

                if (toggle && input) {
                    toggle.addEventListener('click', function() {
                        // Toggle password visibility
                        if (input.type === 'password') {
                            input.type = 'text';
                            toggle.querySelector('.eye-open').classList.add('hidden');
                            toggle.querySelector('.eye-closed').classList.remove('hidden');
                        } else {
                            input.type = 'password';
                            toggle.querySelector('.eye-open').classList.remove('hidden');
                            toggle.querySelector('.eye-closed').classList.add('hidden');
                        }
                    });
                }
            }

            // Setup password toggles
            setupPasswordToggle('newPasswordToggle', 'newPassword');
            setupPasswordToggle('confirmPasswordToggle', 'confirmPassword');
        });

        // Password Validation
        document.addEventListener('DOMContentLoaded', function() {
            const passwordForm = document.getElementById('passwordForm');
            const newPassword = document.getElementById('newPassword');
            const confirmPassword = document.getElementById('confirmPassword');
            const passwordError = document.getElementById('passwordError');

            // Real-time validation
            confirmPassword.addEventListener('input', function() {
                if (newPassword.value !== confirmPassword.value) {
                    passwordError.classList.remove('hidden');
                } else {
                    passwordError.classList.add('hidden');
                }
            });

            newPassword.addEventListener('input', function() {
                if (confirmPassword.value && newPassword.value !== confirmPassword.value) {
                    passwordError.classList.remove('hidden');
                } else {
                    passwordError.classList.add('hidden');
                }
            });

            // Form submission validation
            passwordForm.addEventListener('submit', function(event) {
                // Clear existing error messages
                const existingError = newPassword.parentNode.querySelector('.text-red-500');
                if (existingError) {
                    existingError.remove();
                }

                if (newPassword.value !== confirmPassword.value) {
                    event.preventDefault();
                    passwordError.classList.remove('hidden');
                    return false;
                }

                if (newPassword.value.length < 8) {
                    event.preventDefault();
                    newPassword.classList.add('border-red-500');
                    const minLengthError = document.createElement('p');
                    minLengthError.className = 'text-red-500 text-sm mt-1';
                    minLengthError.textContent = 'Password must be at least 8 characters.';
                    newPassword.parentNode.appendChild(minLengthError);
                    return false;
                }

                return true;
            });
        });
    </script>
</body>

</html>
