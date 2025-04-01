<x-app-layout>

    <!-- Upload Contribution Form -->
    <section class="py-10 px-4 flex justify-center bg-gray-100">
        <div class="w-[800px] max-w-none bg-white rounded-lg p-6 border border-gray-200 shadow-md">
            <h2 class="text-xl font-semibold text-center mb-6">Re-Upload Your Contribution</h2>

            <h3 class="text-lg font-semibold">Re-Upload Your Contribution</h3>
            <p class="text-sm text-gray-600">These are the files from your last submission. You can delete them and
                upload
                new ones.</p>

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

            <form action="{{ route('upload_contribution.update', $contribution->contribution_id) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- User id --}}
                <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}">

                <!-- Title -->
                <div class="mb-4 relative">
                    <label class="block text-gray-700 font-medium mb-2">Title</label>
                    <input type="text" name="contribution_title"
                        value="{{ old('contribution_title', $contribution->contribution_title ?? '') }}"
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
                        <option value=""
                            {{ old('contribution_category_id', $contribution->contribution_category_id ?? '') == '' ? 'selected' : '' }}>
                            Select a category</option>
                        @if ($contribution_categories->isEmpty())
                            <option disabled>No data found</option>
                        @else
                            @foreach ($contribution_categories as $contribution_category)
                                <option value="{{ $contribution_category->contribution_category_id }}"
                                    {{ old('contribution_category_id', $contribution->contribution_category_id ?? '') == $contribution_category->contribution_category_id ? 'selected' : '' }}>
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
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 h-24 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('contribution_description', $contribution->contribution_description ?? '') }}</textarea>
                    @error('contribution_description')
                        <p class="absolute left-2 -bottom-1 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Cover Image Upload -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Cover Image (High-Quality JPG/PNG/JPEG)</label>

                    <div class="flex items-center justify-center gap-3">
                        <!-- Existing Cover Image Preview -->
                        @if ($contribution->contribution_cover)
                            <div id="existing-cover-container" class="mb-4 relative">
                                <div class="flex justify-center">
                                    <div class="relative select-none">
                                        <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                            class="max-h-40 rounded-lg shadow-sm border border-gray-200"
                                            onerror="this.onerror=null;this.src='{{ asset('images/default-image.png') }}';">
                                        <button type="button" onclick="removeExistingCoverImage()"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600 shadow-md">
                                            ×
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- New Cover Image Preview -->
                        <div id="new-cover-preview-container" class="hidden mb-4 relative">
                            <div class="flex justify-center">
                                <div class="relative select-none">
                                    <img id="new-cover-preview"
                                        class="max-h-40 rounded-lg shadow-sm border border-gray-200">
                                    <button type="button" onclick="removeNewCoverImage()"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600 shadow-md">
                                        ×
                                    </button>
                                    <div
                                        class="absolute -top-3 left-2 bg-green-500/90 text-white rounded-md px-2 py-1 flex items-center justify-center text-xs font-medium shadow-md">
                                        New Cover Image
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center transition-colors hover:border-blue-400 bg-gray-50 relative">
                        <!-- Upload Area -->
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

                        <!-- Hidden input to track cover image deletion -->
                        <input type="hidden" id="cover-deleted" name="cover_deleted" value="0">
                    </div>
                    @error('contribution_cover')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <script>
                    // Function to remove existing cover image
                    function removeExistingCoverImage() {
                        // Mark cover image for deletion
                        document.getElementById('cover-deleted').value = '1';

                        // Remove the existing cover preview
                        document.getElementById('existing-cover-container').remove();

                        // Show upload area if no new cover is selected
                        if (document.getElementById('new-cover-preview-container').classList.contains('hidden')) {
                            document.getElementById('cover-upload-area').classList.remove('hidden');
                        }
                    }

                    // Function to remove newly uploaded cover image
                    function removeNewCoverImage() {
                        // Clear the file input
                        document.getElementById('cover-input').value = '';

                        // Hide new cover preview
                        document.getElementById('new-cover-preview-container').classList.add('hidden');

                        // Show upload area if no existing cover is present
                        if (!document.getElementById('existing-cover-container')) {
                            document.getElementById('cover-upload-area').classList.remove('hidden');
                        }
                    }

                    // Cover image preview for new uploads
                    const coverInput = document.getElementById('cover-input');
                    coverInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                document.getElementById('new-cover-preview').src = event.target.result;
                                document.getElementById('new-cover-preview-container').classList.remove('hidden');
                            };
                            reader.readAsDataURL(file);
                        }
                    });
                </script>

                <!-- Additional Images Upload -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Additional Images - JPG/PNG/JPEG</label>

                    <!-- Existing Images Preview -->
                    @if ($contribution->images->count() > 0)
                        <div id="existing-images-container" class="grid grid-cols-4 gap-2 mb-4 select-none">
                            @foreach ($contribution->images as $image)
                                <div class="relative group h-24" data-image-id="{{ $image->contribution_image_id }}">
                                    <div class="h-full w-full overflow-hidden rounded-lg border border-gray-200">
                                        <img src="{{ asset('storage/contribution-images/' . $image->contribution_image_path) }}"
                                            class="w-full h-full object-cover"
                                            onerror="this.onerror=null;this.src='{{ asset('images/default-image.png') }}';">
                                    </div>
                                    <button type="button"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 shadow-md"
                                        onclick="removeExistingImage(this, '{{ $image->contribution_image_id }}')">
                                        ×
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- New Images Preview -->
                    <div id="additional-preview-container" class="grid grid-cols-4 gap-2 mb-4 hidden select-none">
                    </div>

                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center transition-colors hover:border-blue-400 bg-gray-50 relative">
                        <!-- Upload Area -->
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

                        <!-- Hidden container for deleted image IDs -->
                        <div id="deleted-images-container" class="hidden"></div>
                    </div>
                    @error('contribution_images.*')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <script>
                    // Function to remove existing image
                    function removeExistingImage(button, imageId) {
                        // Create hidden input to track deleted images
                        const container = document.getElementById('deleted-images-container');
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'deleted_images[]';
                        input.value = imageId;
                        container.appendChild(input);

                        // Remove the image element from DOM
                        button.closest('[data-image-id]').remove();

                        // Show upload area if no images left
                        const existingImages = document.querySelectorAll('#existing-images-container > div');
                        const newImages = document.querySelectorAll('#additional-preview-container > div');

                        if (existingImages.length === 0 && newImages.length === 0) {
                            document.getElementById('additional-upload-area').classList.remove('hidden');
                        }
                    }

                    // Additional Images Preview (for new uploads)
                    const additionalInput = document.getElementById('additional-input');
                    additionalInput.addEventListener('change', function(e) {
                        const files = e.target.files;
                        const previewContainer = document.getElementById('additional-preview-container');

                        if (files.length > 0) {
                            previewContainer.innerHTML = '';
                            previewContainer.classList.remove('hidden');

                            Array.from(files).forEach((file, index) => {
                                if (file.type.match('image.*')) {
                                    const reader = new FileReader();
                                    reader.onload = function(event) {
                                        const previewDiv = document.createElement('div');
                                        previewDiv.className = 'relative group h-24';
                                        previewDiv.innerHTML = `
                            <div class="h-full w-full overflow-hidden rounded-lg border border-gray-200">
                                <img src="${event.target.result}" class="w-full h-full object-cover">
                            </div>
                            <div class="absolute -top-3 left-2 bg-green-500/90 text-white rounded-md px-2 py-1 flex items-center justify-center text-xs font-medium shadow-md">
                                New Image
                            </div>
                            <button type="button"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 shadow-md"
                                onclick="removeNewImage(this, ${index})">
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

                    // Function to remove newly uploaded image (before form submission)
                    function removeNewImage(button, index) {
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

                        // Show upload area if no images left
                        const existingImages = document.querySelectorAll('#existing-images-container > div');
                        const newImages = document.querySelectorAll('#additional-preview-container > div');

                        if (existingImages.length === 0 && newImages.length === 0) {
                            document.getElementById('additional-upload-area').classList.remove('hidden');
                        }
                    }
                </script>

                <!-- Document Upload -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-2">Upload Word Document (.docx)</label>

                    <!-- Existing Document Preview -->
                    @if ($contribution->contribution_file_path)
                        <div id="existing-document-container" class="mb-4">
                            <div
                                class="flex items-center justify-between bg-blue-50 rounded-lg p-3 border border-blue-100 select-none">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="text-sm font-medium text-gray-700 truncate max-w-xs">
                                        {{ basename($contribution->contribution_file_path) }}
                                    </span>
                                </div>
                                <button type="button" onclick="removeExistingDocument()"
                                    class="ml-4 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600">
                                    ×
                                </button>
                            </div>
                        </div>
                    @endif

                    <!-- New Document Preview -->
                    <div id="new-document-preview-container" class="hidden mb-4">
                        <div
                            class="flex items-center justify-between bg-green-50 rounded-lg p-3 border border-green-100 select-none">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span id="new-document-name"
                                    class="text-sm font-medium text-gray-700 truncate max-w-xs">
                                </span>
                            </div>
                            <button type="button" onclick="removeNewDocument()"
                                class="ml-4 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-sm hover:bg-red-600">
                                ×
                            </button>
                        </div>
                    </div>

                    <div
                        class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center transition-colors hover:border-blue-400 bg-gray-50 relative">
                        <!-- Upload Area -->
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

                        <!-- Hidden input to track document deletion -->
                        <input type="hidden" id="document-deleted" name="document_deleted" value="0">
                    </div>
                    @error('contribution_file_path')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <script>
                    // Function to remove existing document
                    function removeExistingDocument() {
                        // Mark document for deletion
                        document.getElementById('document-deleted').value = '1';

                        // Remove the existing document preview
                        document.getElementById('existing-document-container').remove();

                        // Show upload area if no new document is selected
                        if (document.getElementById('new-document-preview-container').classList.contains('hidden')) {
                            document.getElementById('document-upload-area').classList.remove('hidden');
                        }
                    }

                    // Function to remove newly uploaded document
                    function removeNewDocument() {
                        // Clear the file input
                        document.getElementById('document-input').value = '';

                        // Hide new document preview
                        document.getElementById('new-document-preview-container').classList.add('hidden');

                        // Show upload area if no existing document is present
                        if (!document.getElementById('existing-document-container')) {
                            document.getElementById('document-upload-area').classList.remove('hidden');
                        }
                    }

                    // Document preview for new uploads
                    const documentInput = document.getElementById('document-input');
                    documentInput.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        if (file) {
                            // Automatically mark existing document for deletion when new one is uploaded
                            if (document.getElementById('existing-document-container')) {
                                document.getElementById('document-deleted').value = '1';
                            }

                            // Show new document preview with filename
                            document.getElementById('new-document-name').innerHTML = file.name;
                            document.getElementById('new-document-preview-container').classList.remove('hidden');
                            document.getElementById('document-upload-area').classList.add('hidden');
                        }
                    });
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
                            Re-Upload Contribution
                        </button>
                    @else
                        <button type="button"
                            class="w-full bg-[#5A7BAF] text-white py-2 rounded-lg font-semibold select-none cursor-not-allowed opacity-50"
                            disabled>
                            Re-Upload Contribution
                        </button>
                    @endif
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
