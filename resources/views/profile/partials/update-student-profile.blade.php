<div class="flex flex-col justify-center items-center min-h-screen py-10">
    <div class="w-full max-w-4xl p-8 rounded-xl">
        <!-- Form Section (Border & Shadow Fully Aligning with Profile Image) -->
        <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data"
            class="space-y-3 md:space-y-4 border-gray-200 border-x-2 px-10">
            @csrf

            <!-- Profile Picture Upload -->
            <div class="flex justify-center mb-3">
                <div class="relative w-40 h-40 rounded-full my-3 select-none group">
                    <!-- Profile Image -->
                    <img id="profilePreview" class="w-full h-full object-cover rounded-full"
                        src="{{ asset('images/809812e35ca241ddeca6bd1f191e857e.jfif') }}" alt="Profile">
                    <!-- Camera Icon Overlay -->
                    <div class="absolute inset-0 bg-black bg-opacity-50 rounded-full flex items-center justify-center cursor-pointer opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                        onclick="document.getElementById('profile_image').click()">
                        <i class="ri-camera-line text-white text-3xl"></i>
                    </div>
                    <!-- Alert Box -->
                    <div id="unsavedAlert"
                        class="absolute -top-2 right-0 bg-yellow-500 text-black text-xs font-semibold py-1 px-3 rounded shadow-md opacity-0 pointer-events-none transition-opacity duration-300">
                        Profile unsaved
                    </div>
                    <!-- Hidden File Input -->
                    <input type="file" id="profile_image" name="profile_image" class="hidden"
                        onchange="previewProfileImage(event)">
                </div>
            </div>

            <script>
                const previewProfileImage = (event) => {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            const previewImg = document.getElementById('profilePreview');
                            if (previewImg) {
                                previewImg.src = e.target.result;
                            }
                            // Show alert with transition
                            const alertBox = document.getElementById('unsavedAlert');
                            if (alertBox) {
                                alertBox.classList.remove('opacity-0', 'pointer-events-none');
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                };
            </script>
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">Edit Your Profile</h2>
                <p class="text-gray-600 text-sm max-w-md mx-auto">
                    Update your personal details to keep your profile up-to-date.
                </p>
            </div>

            <h3 class="font-semibold text-gray-800">Personal Details</h3>

            <div class="flex flex-col sm:flex-row gap-4">
                {{-- Username --}}
                <div class="flex-1">
                    <label class="block text-sm md:text-base font-semibold">UserName<span
                            class="text-red-500">*</span></label>
                    <input type="text" name="username" placeholder="Enter your username"
                        value="{{ Auth::user()->username }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                </div>

                {{-- Firstname --}}
                <div class="flex-1">
                    <label class="block text-sm md:text-base font-semibold">First Name<span
                            class="text-red-500">*</span></label>
                    <input type="text" name="first_name" placeholder="Enter your first name"
                        value="{{ Auth::user()->first_name }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                </div>
            </div>

            {{-- Lastname --}}
            <div class="flex-1">
                <label class="block text-sm md:text-base font-semibold">Last Name <span>(Optional)</span></label>
                <input type="text" name="last_name" placeholder="Enter your last name"
                    value="{{ Auth::user()->last_name }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
            </div>

            <hr class="my-4 border-gray-400">

            <h3 class="font-semibold text-gray-800">Mail / Password</h3>
            <div>
                <label class="block text-sm md:text-base font-semibold">University Email<span
                        class="text-red-500">*</span></label>
                <input type="email" placeholder="University@edu.mm" value="{{ Auth::user()->email }}"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm md:text-base" disabled>
            </div>

            <div>
                <label class="block text-sm md:text-base font-semibold">Old Password<span
                        class="text-red-500">*</span></label>
                <input type="password" placeholder="Enter a secure password" value="**********"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
            </div>

            <div class="flex flex-col sm:flex-row gap-4">
                {{-- New password --}}
                <div class="flex-1">
                    <label class="block text-sm md:text-base font-semibold">New Password<span
                            class="text-red-500">*</span></label>
                    <input type="password" placeholder="Enter a secure password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                </div>

                {{-- Confirm password --}}
                <div class="flex-1">
                    <label class="block text-sm md:text-base font-semibold">Confirm Password<span
                            class="text-red-500">*</span></label>
                    <input type="password" placeholder="Enter a confirm password"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-[#5A7BAF] text-white py-2 md:py-2.5 rounded-md hover:bg-[#4A6A9F] transition text-sm md:text-base">
                Save Changes
            </button>
        </form>
    </div>
</div>
