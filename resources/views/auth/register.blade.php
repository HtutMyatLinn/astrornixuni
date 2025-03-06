<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="bg-white p-3 rounded-sm w-full md:w-[700px] flex flex-col md:flex-row justify-center items-center">

        {{-- Left Section - Form --}}
        <div class="w-full px-0 md:px-4">
            {{-- Logo --}}
            <a href="{{ route('/') }}">
                <x-logo />
            </a>

            <h1 class="text-2xl font-bold text-gray-900 mt-10 mb-2">Join the University Magazine</h1>
            <p class="text-gray-600 text-sm mb-6">Stay updated with the latest news, articles, and student stories.</p>

            <form action="{{ route('register') }}" method="POST" class="space-y-3">
                @csrf

                {{-- Username --}}
                <div class="relative">
                    <label for="username" class="block text-gray-700 font-semibold">Username <span
                            class="text-red-500">*</span></label>
                    <input id="username" type="text"
                        class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        name="username" placeholder="Enter your username" value="{{ old('username') }}">
                    <div class="absolute left-2 -bottom-2 bg-white">
                        @error('username')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-2 w-full">
                    {{-- Firstname --}}
                    <div class="w-full relative">
                        <label for="first_name" class="block text-gray-700 font-semibold">First Name <span
                                class="text-red-500">*</span></label>
                        <input id="first_name" type="text"
                            class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            name="first_name" placeholder="Enter your first name" value="{{ old('first_name') }}">
                        <div class="absolute left-2 -bottom-2 bg-white">
                            @error('first_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    {{-- Lastname --}}
                    <div class="w-full relative">
                        <label for="last_name" class="block text-gray-700 font-semibold">Last Name (Optional)</label>
                        <input id="last_name" type="text"
                            class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                            name="last_name" placeholder="Enter your last name" value="{{ old('last_name') }}">
                        <div class="absolute left-2 -bottom-2 bg-white">
                            @error('last_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Email --}}
                <div class="w-full relative">
                    <label for="email" class="block text-gray-700 font-semibold">University Email
                        <span class="text-red-500">*</span></label>
                    <input id="email" type="email"
                        class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        name="email" placeholder="example@gmail.com" value="{{ old('email') }}">
                    <div class="absolute left-2 -bottom-2 bg-white">
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-2 w-full">
                    {{-- Password --}}
                    <div class="w-full relative">
                        <label for="password" class="block text-gray-700 font-semibold">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input id="password" type="password"
                                class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10"
                                name="password" placeholder="Enter a secure password">
                            <button type="button" class="absolute right-3 top-3 text-gray-500"
                                onclick="togglePassword('password', this)">
                                <i class="ri-eye-off-line"></i>
                            </button>
                        </div>
                        <div class="absolute left-2 -bottom-2 bg-white">
                            @error('password')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Confirm Password --}}
                    <div class="w-full relative">
                        <label for="password_confirmation" class="block text-gray-700 font-semibold">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input id="password_confirmation" type="password"
                                class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10"
                                name="password_confirmation" placeholder="Confirm a password">
                            <button type="button" class="absolute right-3 top-3 text-gray-500"
                                onclick="togglePassword('password_confirmation', this)">
                                <i class="ri-eye-off-line"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function togglePassword(fieldId, icon) {
                        const field = document.getElementById(fieldId);
                        if (field.type === "password") {
                            field.type = "text";
                            icon.innerHTML = '<i class="ri-eye-line"></i>'; // Change to eye open
                        } else {
                            field.type = "password";
                            icon.innerHTML = '<i class="ri-eye-off-line"></i>'; // Change to eye closed
                        }
                    }
                </script>

                {{-- Faculty --}}
                <div class="w-full relative">
                    <label for="faculty" class="block text-gray-700 font-semibold">Faculty</label>
                    <select id="faculty" name="faculty_id"
                        class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="" disabled {{ old('faculty_id') == '' ? 'selected' : '' }}>Select your
                            faculty</option>
                        @if ($faculties->isEmpty())
                            <option disabled>No data found</option>
                        @else
                            @foreach ($faculties as $faculty)
                                <option value="{{ $faculty->faculty_id }}"
                                    {{ old('faculty_id') == $faculty->faculty_id ? 'selected' : '' }}>
                                    {{ $faculty->faculty }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('faculty_id')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-6">
                    <!-- Clickable text to toggle requirements visibility -->
                    <p id="toggle-requirements" class="text-sm text-gray-500 cursor-pointer hover:text-indigo-600">
                        Password must meet the following requirements<span class="text-red-500">*</span>
                    </p>

                    <!-- Requirements list -->
                    <ul id="requirements-list" class="list-disc list-inside text-sm text-gray-600 mt-2 hidden">
                        <li id="password-min" class="text-red-500">Password must be at least 8 characters.</li>
                        <li id="password-max" class="text-red-500">Password must not exceed 16 characters.</li>
                        <li id="password-regex" class="text-red-500">Password must be at least 1 uppercase.</li>
                        <li id="password-defaults" class="text-red-500">Password must be at least 1 lowercase.</li>
                        <li id="password-defaults" class="text-red-500">Password must be at least 1 number.</li>
                        <li id="password-defaults" class="text-red-500">Password must be at least 1 special character.
                        </li>
                    </ul>
                </div>

                <script>
                    // Toggle visibility of the requirements list
                    const toggleButton = document.getElementById('toggle-requirements');
                    const requirementsList = document.getElementById('requirements-list');

                    toggleButton.addEventListener('click', () => {
                        requirementsList.classList.toggle('hidden');
                    });
                </script>

                {{-- Submit --}}
                <x-primary-button>
                    {{ __('Register') }}
                </x-primary-button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-700 text-sm">Already have an account? <a href="{{ route('login') }}"
                        class="text-blue-500 hover:underline">Login</a></p>
            </div>
        </div>
    </div>
</x-guest-layout>
