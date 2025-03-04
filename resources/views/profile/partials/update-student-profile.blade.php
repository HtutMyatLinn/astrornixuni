<div class="flex flex-col justify-center items-center min-h-screen bg-gray-100 py-10">
    <div class="w-full max-w-4xl bg-white p-8 rounded-xl">
        <div class="flex flex-col items-center">
            <div class="relative">
                <img src="{{ asset('images/math.png') }}" alt="Profile Picture"
                     class="w-44 h-44 rounded-full border-4 border-gray-300">
            </div>
        </div>

        <!-- Form Section (Border & Shadow Fully Aligning with Profile Image) -->
        <div class="bg-white p-6 pt-28 rounded-lg border border-gray-300 border-t-0 shadow-sm shadow-gray-200 -mt-28">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-900">Edit Your Profile</h2>
                <p class="text-gray-600 text-sm max-w-md mx-auto">
                    Update your personal details to keep your profile up-to-date.
                </p>
            </div>

            <form class="space-y-3 md:space-y-4">
                <h3 class="font-semibold text-gray-800">Personal Details</h3>
                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm md:text-base font-semibold">UserName <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Enter your username"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                    </div>
                </div>

                <hr class="my-4 border-gray-400">

                <h3 class="font-semibold text-gray-800">Mail / Password</h3>
                <div>
                    <label class="block text-sm md:text-base font-semibold">University Email <span class="text-red-500">*</span></label>
                    <input type="email" placeholder="University@edu.mm"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-200 text-sm md:text-base" disabled>
                </div>

                <div class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm md:text-base font-semibold">Old Password <span class="text-red-500">*</span></label>
                        <input type="password" placeholder="Enter a secure password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                    </div>
                    <div>
                        <label class="block text-sm md:text-base font-semibold">Password <span class="text-red-500">*</span></label>
                        <input type="password" placeholder="Enter a secure password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                    </div>
                    <div>
                        <label class="block text-sm md:text-base font-semibold">Confirm Password <span class="text-red-500">*</span></label>
                        <input type="password" placeholder="Enter a confirm password"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                    </div>
                </div>

                <button class="w-full bg-[#5A7BAF] text-white py-2 md:py-2.5 rounded-md hover:bg-[#4A6A9F] transition text-sm md:text-base">
                    Save Changes
                </button>
            </form>
        </div>
        <!-- End Form Section -->
    </div>
</div>
