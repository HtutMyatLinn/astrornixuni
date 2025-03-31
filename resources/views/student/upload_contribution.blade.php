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
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Cover Image (High-Quality JPG/PNG/JPEG)</label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center transition-colors hover:border-blue-400 bg-gray-50 relative">
                        <div id="cover-preview-container" class="hidden mb-4 relative">
                            <div class="flex justify-center">
                                <div class="relative select-none">
                                    <img id="cover-preview"
                                        class="max-h-40 rounded-lg shadow-sm border border-gray-200">
                                    <button type="button" onclick="removeCoverImage()"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600 shadow-md">
                                        ×
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div id="cover-upload-area" class="flex flex-col items-center justify-center space-y-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="text-sm text-gray-600">Drag & drop your cover image here</p>
                            <p class="text-xs text-gray-500">or click to browse</p>
                        </div>
                        <input type="file" name="contribution_cover" id="cover-input"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            accept="image/jpeg,image/png,image/jpg">
                    </div>
                    @error('contribution_cover')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Additional Images Upload -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Additional Images - JPG/PNG/JPEG</label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center transition-colors hover:border-blue-400 bg-gray-50 relative">
                        <div id="additional-preview-container" class="grid grid-cols-4 gap-2 mb-4 hidden select-none">
                        </div>
                        <div id="additional-upload-area" class="flex flex-col items-center justify-center space-y-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            <p class="text-sm text-gray-600">Drag & drop your additional images here</p>
                            <p class="text-xs text-gray-500">or click to browse</p>
                        </div>
                        <input type="file" name="contribution_images[]" id="additional-input" multiple
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            accept="image/jpeg,image/png,image/jpg">
                    </div>
                    @error('contribution_images.*')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Document Upload -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Upload Word Document (.docx)</label>
                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center transition-colors hover:border-blue-400 bg-gray-50 relative">
                        <div id="document-preview-container" class="hidden mb-4 relative">
                            <div
                                class="flex items-center justify-between bg-blue-50 rounded-lg p-3 border border-blue-100 select-none">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span id="document-name"
                                        class="text-sm font-medium text-gray-700 truncate max-w-xs"></span>
                                </div>
                                <button type="button" onclick="removeDocument()"
                                    class="ml-4 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                        </div>
                        <div id="document-upload-area" class="flex flex-col items-center justify-center space-y-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="text-sm text-gray-600">Drag & drop your Word document here</p>
                            <p class="text-xs text-gray-500">or click to browse (.docx only)</p>
                        </div>
                        <input type="file" name="contribution_file_path" id="document-input"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept=".docx">
                    </div>
                    @error('contribution_file_path')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <script>
                    // Cover Image Preview
                    const coverInput = document.getElementById('cover-input');
                    coverInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                document.getElementById('cover-preview').src = event.target.result;
                                document.getElementById('cover-preview-container').classList.remove('hidden');
                                document.getElementById('cover-upload-area').classList.add('hidden');
                            };
                            reader.readAsDataURL(file);
                        }
                    });

                    // Remove Cover Image
                    window.removeCoverImage = function() {
                        coverInput.value = '';
                        document.getElementById('cover-preview-container').classList.add('hidden');
                        document.getElementById('cover-upload-area').classList.remove('hidden');
                    };

                    // Additional Images Preview
                    const additionalInput = document.getElementById('additional-input');
                    additionalInput.addEventListener('change', function(e) {
                        const files = e.target.files;
                        const previewContainer = document.getElementById('additional-preview-container');

                        if (files.length > 0) {
                            previewContainer.innerHTML = '';
                            previewContainer.classList.remove('hidden');
                            document.getElementById('additional-upload-area').classList.add('hidden');

                            Array.from(files).forEach((file, index) => {
                                if (file.type.match('image.*')) {
                                    const reader = new FileReader();
                                    reader.onload = function(event) {
                                        const previewDiv = document.createElement('div');
                                        previewDiv.className =
                                            'relative group h-24'; // Fixed height for consistency
                                        previewDiv.innerHTML = `
                            <div class="h-full w-full overflow-hidden rounded-lg border border-gray-200">
                                <img src="${event.target.result}" class="w-full h-full object-cover">
                            </div>
                            <button type="button"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 shadow-md"
                                onclick="removeAdditionalImage(this, ${index})">
                                ×
                            </button>
                        `;
                                        previewContainer.appendChild(previewDiv);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            });
                        }
                    });

                    // Remove Additional Image
                    window.removeAdditionalImage = function(button, index) {
                        // Create new DataTransfer object
                        const dataTransfer = new DataTransfer();
                        const files = additionalInput.files;

                        // Add all files except the one being removed
                        for (let i = 0; i < files.length; i++) {
                            if (i !== index) {
                                dataTransfer.items.add(files[i]);
                            }
                        }

                        // Update files in input
                        additionalInput.files = dataTransfer.files;

                        // Remove preview
                        button.closest('.relative').remove();

                        const previewContainer = document.getElementById('additional-preview-container');
                        if (previewContainer.children.length === 0) {
                            previewContainer.classList.add('hidden');
                            document.getElementById('additional-upload-area').classList.remove('hidden');
                        }

                        // Trigger change event to update UI if needed
                        additionalInput.dispatchEvent(new Event('change'));
                    };

                    // Document Preview
                    const documentInput = document.getElementById('document-input');
                    documentInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            document.getElementById('document-name').textContent = file.name;
                            document.getElementById('document-preview-container').classList.remove('hidden');
                            document.getElementById('document-upload-area').classList.add('hidden');
                        }
                    });

                    // Remove Document
                    window.removeDocument = function() {
                        documentInput.value = '';
                        document.getElementById('document-preview-container').classList.add('hidden');
                        document.getElementById('document-upload-area').classList.remove('hidden');
                    };
                </script>

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
