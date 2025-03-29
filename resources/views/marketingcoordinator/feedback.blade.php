<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-w-[420px]">
    <!-- Main Container -->
    <div class="flex min-h-screen relative">
        <!-- Sidebar Toggle Button (Mobile) -->
        <button id="sidebarToggle"
            class="lg:hidden fixed bottom-4 right-4 z-50 bg-blue-600 text-white p-3 rounded-full shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="w-64 fixed inset-y-0 left-0 transform transition-transform duration-300 z-40 -translate-x-full lg:translate-x-0">
            @include('marketingcoordinator.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            @include('marketingcoordinator.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

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
                        }, 3000);
                    </script>
                @endif

                <div class="space-y-4 mb-4">
                    <h1 class=" text-xl sm:text-4xl font-bold text-gray-900">Provide Feedback</h1>

                    <div class="p-12 bg-white rounded-lg shadow-sm my-8">
                        <h1 class="text-4xl font-bold mb-2">Contribution Details</h1>
                        <div class="border-b-4 border-blue-600 w-32 mb-8"></div>

                        <div class="space-y-6">
                            <!-- Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6">
                                <div class="font-semibold text-xl">Title</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->contribution_title }}</div>

                                <div class="font-semibold text-xl">Submitted By</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->user->first_name }}
                                    {{ $contribution->user->last_name }}
                                </div>

                                <div class="font-semibold text-xl">Submission Date</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->submitted_date->format('M d, Y') }}
                                </div>

                                <div class="font-semibold text-xl">Contribution Category</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->category->contribution_category }}
                                </div>

                                <div class="font-semibold text-xl">Status</div>
                                <div class="md:col-span-2 text-xl flex items-center">
                                    <span class="w-4 h-4 bg-blue-400 rounded-full mr-3"></span>
                                    {{ $contribution->contribution_status == 'Upload'
                                        ? 'Uploaded'
                                        : ($contribution->contribution_status == 'Select'
                                            ? 'Selected'
                                            : ($contribution->contribution_status == 'Update'
                                                ? 'Updated'
                                                : ($contribution->contribution_status == 'Reject'
                                                    ? 'Rejected'
                                                    : ($contribution->contribution_status == 'Publish'
                                                        ? 'Published'
                                                        : $contribution->contribution_status)))) }}
                                </div>
                            </div>

                            <!-- Feedback Form -->
                            <div class="mt-12">
                                <h2 class="text-3xl font-bold mb-8">Provide Feedback</h2>

                                {{-- Message --}}
                                @if (now()->isAfter($contribution->submitted_date->addDays(14)))
                                    <div class="mt-2 text-red-600 font-medium">
                                        The 14-day feedback period for this contribution has expired.
                                    </div>
                                @endif

                                <form id="feedbackForm"
                                    action="{{ route('marketingcoordinator.submit-feedback', $contribution->contribution_id) }}"
                                    method="POST">
                                    @csrf
                                    <div class="relative">
                                        <textarea name="feedback" rows="5"
                                            class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                            placeholder="Enter your feedback here..."></textarea>
                                        @error('feedback')
                                            <p class="absolute left-2 -bottom-1 bg-white text-red-500 text-sm mt-1">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mt-6 flex">
                                        <button type="submit" id="submitFeedbackButton"
                                            class="bg-black hover:bg-gray-700 text-white px-8 py-3 rounded-md text-lg font-semibold transition-colors flex items-center justify-center"
                                            {{ now()->isBefore($contribution->submitted_date->addDays(14)) ? '' : 'disabled' }}>
                                            <span id="submitFeedbackText">Submit Feedback</span>
                                            <svg id="submitFeedbackSpinner"
                                                class="animate-spin ml-2 h-5 w-5 text-white hidden"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                                    stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </button>
                                        <a href="{{ route('marketingcoordinator.submission-management') }}"
                                            class="bg-black hover:bg-gray-600 text-white px-8 py-3 rounded-md text-lg font-semibold transition-colors ml-4">
                                            Back
                                        </a>
                                    </div>
                                </form>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        const feedbackForm = document.getElementById("feedbackForm");
                                        const submitFeedbackButton = document.getElementById("submitFeedbackButton");
                                        const submitFeedbackText = document.getElementById("submitFeedbackText");
                                        const submitFeedbackSpinner = document.getElementById("submitFeedbackSpinner");

                                        feedbackForm.addEventListener("submit", function(e) {
                                            submitFeedbackButton.disabled = true;
                                            submitFeedbackText.textContent = "Submitting...";
                                            submitFeedbackSpinner.classList.remove("hidden");
                                        });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('translate-x-full');
        });
    </script>
</body>

</html>
