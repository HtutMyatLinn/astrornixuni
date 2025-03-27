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
    <section class="py-10 px-4 flex justify-center bg-gray-100 relative">
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

            <!-- History Link -->
            <div class="mt-6 flex justify-end">
                <a href="{{ route('student.re_upload_contribution') }}"
                    class="text-sm text-blue-600 hover:text-blue-800">
                    Contribution History →
                </a>
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

            @php
                $currentDate = now()->toDateString(); // Get the current date in 'Y-m-d' format
                $activeIntake = \App\Models\Intake::where('status', 'active')->first(); // Get the active intake
                $upcomingIntake = \App\Models\Intake::where('status', 'upcoming')
                    ->orderBy('closure_date', 'asc')
                    ->first(); // Get the earliest upcoming intake
            @endphp

            @if (Auth::check() &&
                    Auth::user()->role &&
                    Auth::user()->role->role === 'Student' &&
                    $activeIntake &&
                    $currentDate >= $activeIntake->closure_date)
                <div class="flex flex-col sm:flex-row gap-4 my-4"> <!-- Parent flex container -->
                    <!-- Contribution Period Ended Alert -->
                    <div
                        class="bg-orange-100 border-l-4 border-orange-500 text-orange-700 p-4 rounded-md shadow-sm flex items-center flex-1">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0 text-orange-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="font-semibold">The contribution period has ended.</p>
                            <p class="text-sm">Submissions will reopen in the next intake.</p>
                        </div>
                    </div>

                    <!-- Upcoming Intake Alert -->
                    @if ($upcomingIntake)
                        <div
                            class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md shadow-sm flex items-center flex-1">
                            <svg class="w-6 h-6 mr-3 flex-shrink-0 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-semibold">Upcoming Intake</p>
                                <p class="text-sm">The next intake starts on
                                    {{ \Carbon\Carbon::parse($upcomingIntake->closure_date)->format('F j, Y') }}.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <form action="{{ route('upload_contribution.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- User id --}}
                <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}">

                <!-- Title -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" name="contribution_title" value="{{ old('contribution_title') }}"
                        placeholder="Enter your contribution title"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('contribution_title')
                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Intake</label>
                    @foreach ($intakes as $intake)
                        <input type="text" value="{{ $intake->intake }}" disabled
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @endforeach
                    <select name="intake_id"
                        class="w-full hidden border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @if ($intakes->isEmpty())
                            <option disabled>No active intakes found</option>
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
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 h-24 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('contribution_description') }}</textarea>
                    @error('contribution_description')
                        <p class="absolute left-2 -bottom-1 bg-white text-red-500 text-sm mt-1">
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
                        <p class="absolute left-2 -bottom-3 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Additional Images Upload -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Additional Images (Up to 3) - JPG/PNG</label>
                    <input type="file" name="contribution_images[]" multiple
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 bg-white focus:outline-none">
                    @error('contribution_images')
                        <p class="absolute left-2 -bottom-3 bg-white text-red-500 text-sm mt-1">
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
                        <p class="absolute left-2 -bottom-3 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="terms_and_conditions" id="terms_and_conditions"
                            class="w-4 h-4 border border-gray-300 rounded focus:ring-2 focus:ring-blue-500">
                        <label for="terms_and_conditions" class="ml-2 text-sm text-gray-600">
                            I agree to the <a href="{{ asset('pdfs/Term&Conditionforstudent.pdf') }}" target="-blank"
                                class="text-blue-500 hover:underline">terms and
                                conditions</a>.
                        </label>
                    </div>
                    @error('terms_and_conditions')
                        <p class="bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="text-center">
                    @php
                        $currentDate = now()->toDateString(); // Get current date
                        $intake = \App\Models\Intake::where('status', 'active')->first(); // Get active intake
                    @endphp

                    @if (Auth::check() &&
                            Auth::user()->role &&
                            Auth::user()->role->role === 'Student' &&
                            $intake &&
                            $currentDate < $intake->closure_date)
                        <button type="submit"
                            class="w-full bg-[#5A7BAF] text-white py-2 rounded-lg font-semibold hover:bg-[#4A6A9F] transition select-none">
                            Upload your Contribution
                        </button>
                    @else
                        <button type="button"
                            class="w-full bg-[#5A7BAF] text-white py-2 rounded-lg font-semibold select-none cursor-not-allowed opacity-50"
                            disabled>
                            Upload your Contribution
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
