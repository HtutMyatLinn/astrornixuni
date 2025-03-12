<x-app-layout>

    <!-- Hero Section -->
    <section class="bg-[#5A7BAF] text-white py-14 text-center">
        <h1 class="text-3xl font-bold">Upload Your <br> Contributions</h1>
        <p class="mt-2 text-lg">
            Showcase your work in the University Magazine. Submit your research,
            articles, or creative works today.
        </p>
    </section>

    <!-- Contribution Benefits -->
    <section class="py-10 px-4 flex justify-center bg-gray-100">
        <div class="max-w-[900px] w-full bg-white rounded-lg p-6 border border-gray-200 shadow-md">
            <h2 class="text-xl font-semibold text-center mb-6">Why Contribute to the Magazine?</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Card 1 -->
                <div class="border border-gray-300 p-4 rounded-lg text-center bg-white shadow-sm">
                    <h3 class="text-md font-semibold">Gain Recognition</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Get your work published and recognized by faculty, students, and industry experts.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="border border-gray-300 p-4 rounded-lg text-center bg-white shadow-sm">
                    <h3 class="text-md font-semibold">Improve your skills</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Enhance your writing, research, and analytical skills through real-world publishing.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="border border-gray-300 p-4 rounded-lg text-center bg-white shadow-sm">
                    <h3 class="text-md font-semibold">Boost Your Resume</h3>
                    <p class="mt-2 text-gray-600 text-sm">
                        Showcase your published work as part of your academic and career achievements.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Upload Contribution Form -->
    <section class="py-10 px-4 flex justify-center bg-gray-100">
        <div class="w-[800px] max-w-none bg-white rounded-lg p-6 border border-gray-200 shadow-md">
            <h2 class="text-xl font-semibold text-center mb-6">Upload Your Contribution</h2>

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
                    }, 5000);
                </script>
            @endif

            <form action="{{ route('upload_contribution.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- User id --}}
                <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}">

                <!-- Title -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" name="contribution_title" placeholder="Enter your contribution title"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('contribution_title')
                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Intake</label>
                    <select name="intake_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" {{ old('intake_id') == '' ? 'selected' : '' }}>Select a
                            intake</option>
                        @if ($intakes->isEmpty())
                            <option disabled>No data found</option>
                        @else
                            @foreach ($intakes as $intake)
                                <option value="{{ $intake->intake_id }}"
                                    {{ old('intake_id') == $intake->intake_id ? 'selected' : '' }}>
                                    {{ $intake->intake }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('intake_id')
                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Category</label>
                    <select name="contribution_category_id"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="" {{ old('contribution_category_id') == '' ? 'selected' : '' }}>Select a
                            category</option>
                        @if ($contribution_categories->isEmpty())
                            <option disabled>No data found</option>
                        @else
                            @foreach ($contribution_categories as $contribution_category)
                                <option value="{{ $contribution_category->contribution_category_id }}"
                                    {{ old('contribution_category_id') == $contribution_category->contribution_category_id ? 'selected' : '' }}>
                                    {{ $contribution_category->contribution_category }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @error('contribution_category_id')
                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="contribution_description" placeholder="Provide a brief summary of your contributions..."
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 h-24 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    @error('contribution_description')
                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Cover Image Upload -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Cover Image (High-Quality JPG/PNG)</label>
                    <input type="file" name="contribution_cover"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none">
                    @error('contribution_cover')
                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Document Upload -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Upload Word Document (.docx)</label>
                    <input type="file" name="contribution_file_path"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none">
                    @error('contribution_file_path')
                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit"
                        class="w-full bg-[#5A7BAF] text-white py-2 rounded-lg font-semibold hover:bg-[#4A6A9F] transition">
                        Upload your Contribution
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
