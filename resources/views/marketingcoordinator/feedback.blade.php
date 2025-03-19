<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
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
                @if(session('success'))
                <div id="successMessage"
                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                        <svg class="fill-current h-6 w-6 text-green-500" role="button"
                            onclick="document.getElementById('successMessage').remove()"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <title>Close</title>
                            <path
                                d="M14.348 14.849a1 1 0 0 1-1.414 0L10 11.414l-2.93 2.93a1 1 0 1 1-1.414-1.414l2.93-2.93-2.93-2.93a1 1 0 1 1 1.414-1.414l2.93 2.93 2.93-2.93a1 1 0 1 1 1.414 1.414l-2.93 2.93 2.93 2.93a1 1 0 0 1 0 1.414z" />
                        </svg>
                    </span>
                </div>

                <!-- Auto-hide script -->
                <script>
                    setTimeout(function() {
                        document.getElementById('successMessage').remove();
                    }, 3000); // 3 seconds
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
                                <div class="md:col-span-2 text-xl">{{ $contribution->user->username }}</div>

                                <div class="font-semibold text-xl">Submission Date</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->submitted_date->format('M d, Y') }}
                                </div>

                                <div class="font-semibold text-xl">Contribution Category</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->category->contribution_category }}
                                </div>

                                <div class="font-semibold text-xl">Status</div>
                                <div class="md:col-span-2 text-xl flex items-center">
                                    <span class="w-4 h-4 bg-blue-400 rounded-full mr-3"></span>
                                    {{ $contribution->contribution_status }}
                                </div>
                            </div>

                            <!-- Feedback Form -->
                            <div class="mt-12">
                                <h2 class="text-3xl font-bold mb-8">Provide Feedback</h2>
                                <form
                                    action="{{ route('marketingcoordinator.submit-feedback', $contribution->contribution_id) }}"
                                    method="POST">
                                    @csrf
                                    <textarea name="feedback" rows="5"
                                        class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500"
                                        placeholder="Enter your feedback here..." required></textarea>
                                    <div class="mt-6">
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                            Submit Feedback
                                        </button>
                                        <a href="{{ route('marketingcoordinator.submission-management') }}"
                                            class="bg-gray-500 hover:bg-gray-600 text-white px-8 py-3 rounded-md text-lg font-semibold transition-colors ml-4">
                                            Back
                                        </a>
                                    </div>
                                </form>
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
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>

</html>