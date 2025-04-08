<header class="bg-white border-b border-gray-200 sticky top-0 z-30">
    <div class="px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center justify-between">
            <!-- Left side -->
            <div class="flex items-center space-x-4 select-none">
                <img src="{{ asset('images/logo.png') }}" class="h-16 w-16" alt="Logo" />
            </div>

            <!-- Right side -->
            <div class="flex items-center space-x-4">

                <!-- Profile Dropdown -->
                <div class="flex items-center space-x-4">
                    <!-- Text Section -->
                    <div class="text-right">
                        <h4 class="text-sm font-medium text-black">{{ Auth::user()->username }}</h4>
                        <span class="text-sm text-gray-500">{{ Auth::user()->role->role }}</span>
                        @if (optional(Auth::user()->faculty)->faculty)
                            <p class="text-xs text-gray-400">[{{ Auth::user()->faculty->faculty }}]</p>
                        @endif
                    </div>

                    <!-- Profile Image with Link to Account Settings -->
                    <a href="{{ route('marketingmanager.account-setting') }}" class="block cursor-pointer">
                        @if (Auth::check())
                            @if (Auth::user()->profile_image)
                                <img id="profilePreview"
                                    class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                    src="{{ asset('storage/profile_images/' . Auth::user()->profile_image) }}"
                                    alt="Profile">
                            @else
                                <p
                                    class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                    {{ strtoupper(Auth::user()->username[0]) }}
                                </p>
                            @endif
                        @else
                            <div class="w-12 h-12 select-none">
                                <img src="{{ asset('images/guest.jpg') }}" alt="Guest Profile"
                                    class="w-full h-full rounded-full object-cover">
                            </div>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
