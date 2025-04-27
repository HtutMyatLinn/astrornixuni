<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="bg-white p-4 rounded-sm w-full h-screen sm:h-full flex flex-col md:flex-row justify-center items-center">
        {{-- Left Section - Form --}}
        <div class="w-full md:w-1/2 pl-0 sm:pl-4 pr-0 sm:pr-8">
            {{-- Logo --}}
            <a href="{{ route('/') }}">
                <x-logo />
            </a>

            @if (session('error'))
                <div
                    class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 my-4 rounded-md shadow-sm flex items-center">
                    <svg class="w-6 h-6 mr-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <div>
                        <p class="font-semibold">Account Suspended</p>
                        <p class="text-sm">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <h1 class="text-2xl font-bold text-gray-900 {{ session('error') ? 'mt-0' : 'mt-10' }} mb-2">Login to your
                account</h1>
            <p class="text-gray-600 text-sm mb-6">Access exclusive content, stay informed, and connect with the
                university
                community.</p>

            <form action="{{ route('login') }}" method="POST" class="space-y-3">
                @csrf

                {{-- Email --}}
                <div class="relative">
                    <label for="email" class="block text-gray-700 font-semibold">University Email</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="example@gmail.com" value="{{ old('email') }}">
                    <div class="absolute left-2 -bottom-2 bg-white">
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

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

                {{-- Forgot Password --}}
                @if (Route::has('password.request'))
                    <a class="block mt-4 underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                {{-- Submit --}}
                <x-primary-button>
                    {{ __('Log in') }}
                </x-primary-button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-gray-700 text-sm">Don't have an account? <a href="{{ route('register') }}"
                        class="text-blue-500 hover:underline">Register</a></p>
            </div>
        </div>

        {{-- Right Section - Image --}}
        <div class="w-1/2 h-full relative hidden md:block">
            <!-- Background Image -->
            <img src="{{ asset('images/people-2562380_1280.jpg') }}" alt="University Magazine"
                class="w-full h-full object-cover rounded-sm select-none">

            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/50 to-transparent rounded-md"></div>

            <!-- Text Overlay -->
            <div class="absolute bottom-6 left-6 text-white text-lg max-w-[90%]">
                <p class="text-xl font-semibold">University Annual Magazine</p>
                <p class="mt-2 text-sm text-gray-200">
                    Join the legacy! Be part of a vibrant community of writers, photographers, and creative minds.
                    Share your experiences, achievements, and perspectives with the university.
                    Register today and make your voice heard!
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
