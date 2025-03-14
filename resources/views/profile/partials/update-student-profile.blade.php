<div class="flex flex-col justify-center items-center min-h-screen py-10">
    <div class="w-full max-w-4xl p-8 rounded-xl">

        <!-- Form Section -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-3 md:space-y-4 border-gray-200 border-x-2 px-10">
            @csrf
            @method('PUT')

            <!-- Profile Picture Upload -->
            <div class="flex justify-center mb-3">
                <div class="relative w-40 h-40 rounded-full my-3 select-none group">
                    @if (Auth::user()->profile_image)
                        <img id="profilePreview" class="w-full h-full object-cover rounded-full"
                            src="{{ asset('profile_images/' . Auth::user()->profile_image) }}" alt="Profile">
                    @else
                        <div id="profilePreview"
                            class="w-full h-full bg-gray-300 rounded-full flex items-center justify-center text-white text-4xl font-bold uppercase">
                            {{ substr(Auth::user()->username, 0, 1) }}
                        </div>
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

            <!-- Success Message -->
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
                    <!-- Show error if validation fails -->
                    @error('username')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- First Name Field -->
                <div class="flex-1">
                    <label class="block text-sm md:text-base font-semibold">
                        First Name<span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="first_name" placeholder="Enter your first name"
                        value="{{ old('first_name', Auth::user()->first_name) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                    <!-- Show error if validation fails -->
                    @error('first_name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
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

            <button type="submit"
                class="w-full bg-[#5A7BAF] text-white py-2 md:py-2.5 rounded-md hover:bg-[#4A6A9F] transition text-sm md:text-base">
                Save Changes
            </button>
        </form>
    </div>
</div>

<script>
    const previewProfileImage = (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                document.getElementById('profilePreview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    };
</script>
