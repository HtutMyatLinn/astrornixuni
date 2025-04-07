<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Update</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="flex flex-col justify-center items-center min-h-screen py-10">
        <div class="w-full max-w-4xl p-8 rounded-xl">
            <!-- Success/Error Messages -->
            @if (session('status'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

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

            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert">
                    @foreach ($errors->all() as $error)
                        <span class="block sm:inline">{{ $error }}</span>
                    @endforeach
                </div>
            @endif

            <!-- Form Section -->
            <form
                action="{{ Auth::check() && Auth::user()->role && Auth::user()->role->role === 'Student'
                    ? route('profile.update')
                    : route('guest.profile.update') }}"
                method="POST" enctype="multipart/form-data"
                class="space-y-3 md:space-y-4 border-gray-200 border-x-2 px-10">

                @csrf
                @method('PUT')

                <!-- Profile Picture Upload -->
                <div class="flex justify-center mb-3">
                    <div class="relative w-40 h-40 rounded-full my-3 select-none group">
                        @if (Auth::user()->profile_image)
                            <img id="profilePreview"
                                class="w-full h-full rounded-full object-cover bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                src="{{ asset('profile_images/' . Auth::user()->profile_image) }}" alt="Profile">
                        @else
                            <p id="profilePreview"
                                class="w-full h-full rounded-full bg-blue-100 text-blue-500 flex items-center justify-center select-none text-4xl font-bold uppercase">
                                {{ strtoupper(Auth::user()->username[0]) }}
                            </p>
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                            onclick="document.getElementById('profile_image').click()">
                            <i class="ri-camera-line text-white text-3xl"></i>
                        </div>
                        <input type="file" id="profile_image" name="profile_image" class="hidden"
                            onchange="previewProfileImage(event)">
                    </div>
                </div>

                <div class="text-center mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Edit Your Profile</h2>
                    <p class="text-gray-600 text-sm max-w-md mx-auto">
                        Update your personal details to keep your profile up-to-date.
                    </p>
                </div>

                <h3 class="font-semibold text-gray-800">Personal Details</h3>

                <div class="flex flex-col sm:flex-row gap-4">
                    <!-- Username Field -->
                    <div class="flex-1">
                        <label class="block text-sm md:text-base font-semibold">
                            User Name<span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="username" placeholder="Enter your username"
                            value="{{ old('username', Auth::user()->username) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                    </div>

                    <!-- First Name Field -->
                    <div class="flex-1">
                        <label class="block text-sm md:text-base font-semibold">
                            First Name<span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="first_name" placeholder="Enter your first name"
                            value="{{ old('first_name', Auth::user()->first_name) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                    </div>
                </div>

                <div class="flex-1">
                    <label class="block text-sm md:text-base font-semibold">Last Name <span>(Optional)</span></label>
                    <input type="text" name="last_name" placeholder="Enter your last name"
                        value="{{ old('last_name', Auth::user()->last_name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                </div>

                <div class="flex-1">
                    <label class="block text-sm md:text-base font-semibold">Email</label>
                    <input type="email" value="{{ Auth::user()->email }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base"
                        disabled>
                </div>

                <!-- Change Password Link -->
                <p class="text-[#5A7BAF] cursor-pointer hover:underline" id="changePasswordBtn">Change Password?</p>

                <button type="submit"
                    class="w-full bg-[#5A7BAF] text-white py-2 md:py-2.5 rounded-md hover:bg-[#4A6A9F] transition text-sm md:text-base">
                    Save Changes
                </button>
            </form>
        </div>

        <!-- Password Change Modal -->
        <div id="passwordModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-lg">
                <h2 class="text-3xl font-bold text-center mb-8">Update Your Password</h2>

                <form id="passwordForm" action="{{ route('profile.change-password') }}" method="POST"
                    class="space-y-6">
                    @csrf
                    <!-- Current Password -->
                    <div class="space-y-2">
                        <label for="old_password" class="text-xl font-medium">Current Password</label>
                        <div class="relative">
                            <input type="password" id="old_password" name="old_password"
                                class="w-full px-4 py-3 bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-[#5A7BAF] pr-10"
                                placeholder="Enter Current Password" required />
                            <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                                data-password-toggle="old_password">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed hidden"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- New Password -->
                    <div class="space-y-2">
                        <label for="new_password" class="text-xl font-medium">New Password</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="new_password"
                                class="w-full px-4 py-3 bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-[#5A7BAF] pr-10"
                                placeholder="Enter New Password" required />
                            <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                                data-password-toggle="new_password">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed hidden"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <div id="passwordStrength" class="hidden">
                            <div class="h-1 w-full bg-gray-200 rounded-full mt-2">
                                <div id="passwordStrengthBar"
                                    class="h-1 rounded-full bg-red-500 w-0 transition-all duration-300"></div>
                            </div>
                            <p id="passwordStrengthText" class="text-xs mt-1 text-gray-500">Password strength: Weak
                            </p>
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="space-y-2">
                        <label for="new_password_confirmation" class="text-xl font-medium">Confirm New
                            Password</label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                class="w-full px-4 py-3 bg-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-[#5A7BAF] pr-10"
                                placeholder="Enter Confirm Password" required />
                            <button type="button"
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700"
                                data-password-toggle="new_password_confirmation">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-open" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 eye-closed hidden"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        <p id="passwordMatchError" class="text-red-500 text-sm hidden">Passwords do not match</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-[#5A7BAF] text-white py-3 rounded-md hover:bg-[#4A6A9F] transition text-lg font-medium">
                        Update Password
                    </button>

                    <!-- Cancel Button -->
                    <button type="button" id="cancelPasswordChange"
                        class="w-full text-gray-600 py-2 rounded-md hover:bg-gray-100 transition text-sm">
                        Cancel
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show/Hide Password Modal
        document.addEventListener('DOMContentLoaded', function() {
            const changePasswordBtn = document.getElementById('changePasswordBtn');
            const passwordModal = document.getElementById('passwordModal');
            const cancelPasswordChange = document.getElementById('cancelPasswordChange');
            const passwordForm = document.getElementById('passwordForm');
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('new_password_confirmation');
            const passwordMatchError = document.getElementById('passwordMatchError');
            const passwordStrength = document.getElementById('passwordStrength');
            const passwordStrengthBar = document.getElementById('passwordStrengthBar');
            const passwordStrengthText = document.getElementById('passwordStrengthText');

            // Toggle password visibility buttons
            const toggleButtons = document.querySelectorAll('[data-password-toggle]');

            // Show modal
            if (changePasswordBtn) {
                changePasswordBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (passwordModal) {
                        passwordModal.classList.remove('hidden');
                        document.body.style.overflow = 'hidden'; // Prevent scrolling
                    }
                });
            }

            // Hide modal
            if (cancelPasswordChange) {
                cancelPasswordChange.addEventListener('click', function() {
                    if (passwordModal) {
                        passwordModal.classList.add('hidden');
                        document.body.style.overflow = ''; // Re-enable scrolling

                        // Reset form
                        if (passwordForm) {
                            passwordForm.reset();
                            passwordMatchError.classList.add('hidden');
                            passwordStrength.classList.add('hidden');
                        }
                    }
                });
            }

            // Close modal when clicking outside
            if (passwordModal) {
                passwordModal.addEventListener('click', function(e) {
                    if (e.target === passwordModal) {
                        passwordModal.classList.add('hidden');
                        document.body.style.overflow = ''; // Re-enable scrolling

                        // Reset form
                        if (passwordForm) {
                            passwordForm.reset();
                            passwordMatchError.classList.add('hidden');
                            passwordStrength.classList.add('hidden');
                        }
                    }
                });
            }

            // Toggle password visibility
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-password-toggle');
                    const targetInput = document.getElementById(targetId);
                    const eyeOpen = this.querySelector('.eye-open');
                    const eyeClosed = this.querySelector('.eye-closed');

                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        eyeOpen.classList.add('hidden');
                        eyeClosed.classList.remove('hidden');
                    } else {
                        targetInput.type = 'password';
                        eyeOpen.classList.remove('hidden');
                        eyeClosed.classList.add('hidden');
                    }
                });
            });

            // Password strength meter
            if (newPasswordInput) {
                newPasswordInput.addEventListener('input', function() {
                    const password = this.value;

                    if (password.length > 0) {
                        passwordStrength.classList.remove('hidden');

                        // Calculate password strength
                        let strength = 0;

                        // Length check
                        if (password.length >= 8) strength += 25;

                        // Contains lowercase
                        if (/[a-z]/.test(password)) strength += 25;

                        // Contains uppercase
                        if (/[A-Z]/.test(password)) strength += 25;

                        // Contains number or special char
                        if (/[0-9!@#$%^&*(),.?":{}|<>]/.test(password)) strength += 25;

                        // Update strength bar
                        passwordStrengthBar.style.width = strength + '%';

                        // Update color and text based on strength
                        if (strength <= 25) {
                            passwordStrengthBar.className =
                                'h-1 rounded-full bg-red-500 transition-all duration-300';
                            passwordStrengthText.textContent = 'Password strength: Weak';
                            passwordStrengthText.className = 'text-xs mt-1 text-red-500';
                        } else if (strength <= 50) {
                            passwordStrengthBar.className =
                                'h-1 rounded-full bg-orange-500 transition-all duration-300';
                            passwordStrengthText.textContent = 'Password strength: Fair';
                            passwordStrengthText.className = 'text-xs mt-1 text-orange-500';
                        } else if (strength <= 75) {
                            passwordStrengthBar.className =
                                'h-1 rounded-full bg-yellow-500 transition-all duration-300';
                            passwordStrengthText.textContent = 'Password strength: Good';
                            passwordStrengthText.className = 'text-xs mt-1 text-yellow-600';
                        } else {
                            passwordStrengthBar.className =
                                'h-1 rounded-full bg-green-500 transition-all duration-300';
                            passwordStrengthText.textContent = 'Password strength: Strong';
                            passwordStrengthText.className = 'text-xs mt-1 text-green-500';
                        }
                    } else {
                        passwordStrength.classList.add('hidden');
                    }

                    // Check if passwords match
                    if (confirmPasswordInput.value) {
                        checkPasswordsMatch();
                    }
                });
            }

            // Check if passwords match
            function checkPasswordsMatch() {
                if (newPasswordInput && confirmPasswordInput) {
                    if (newPasswordInput.value !== confirmPasswordInput.value) {
                        passwordMatchError.classList.remove('hidden');
                        return false;
                    } else {
                        passwordMatchError.classList.add('hidden');
                        return true;
                    }
                }
                return false;
            }

            // Validate confirm password
            if (confirmPasswordInput) {
                confirmPasswordInput.addEventListener('input', checkPasswordsMatch);
            }
        });

        // Profile image preview function
        function previewProfileImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const preview = document.getElementById('profilePreview');
                    if (preview.tagName === 'IMG') {
                        preview.src = e.target.result;
                    } else {
                        // Create an image element to replace the placeholder
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.id = 'profilePreview';
                        img.className = 'w-full h-full object-cover rounded-full';
                        preview.parentNode.replaceChild(img, preview);
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>
