<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>

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

                <div class="space-y-4 mb-4">
                    <h1 class=" text-xl sm:text-4xl font-bold text-gray-900">Contribution Details & Approval</h1>

                    <div class="p-12 bg-white rounded-lg shadow-sm my-8">
                        <h1 class="text-4xl font-bold mb-2">Contribution Detail</h1>
                        <div class="border-b-4 border-blue-600 w-32 mb-8"></div>

                        <div class="space-y-6">
                            <!-- Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6">
                                <div class="font-semibold text-xl">Title</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->contribution_title }}</div>

                                <div class="font-semibold text-xl">Submitted By</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->user->first_name }}
                                    {{ $contribution->user->last_name }}</div>

                                <div class="font-semibold text-xl">Submission Date</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->submitted_date->format('M d, Y') }}
                                </div>

                                <div class="font-semibold text-xl">Contribution Cover</div>
                                <div class="md:col-span-2 text-xl select-none">
                                    @if ($contribution->contribution_cover)
                                        <div class="md:col-span-2 text-xl select-none">
                                            <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                                alt="Cover Image" class="w-32 h-32 object-cover">
                                        </div>
                                    @else
                                        <!-- Display the default logo image if contribution_cover is null -->
                                        <div class="flex h-full w-full">
                                            <div class="w-24 select-none">
                                                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="font-semibold text-xl">Contribution File</div>
                                <div class="md:col-span-2 text-xl">
                                    <a href="{{ asset('storage/contribution-documents/' . $contribution->contribution_file_path) }}"
                                        class="text-blue-600 hover:underline">Download File</a>
                                </div>

                                <div class="font-semibold text-xl">Contribution Category</div>
                                <div class="md:col-span-2 text-xl">{{ $contribution->category->contribution_category }}
                                </div>

                                <div class="font-semibold text-xl">Status</div>
                                <div class="md:col-span-2 text-xl flex items-center">
                                    @if ($contribution->contribution_status == 'Upload')
                                        <span class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></span>
                                    @elseif($contribution->contribution_status == 'Reject')
                                        <span class="w-4 h-4 bg-red-400 rounded-full mr-3"></span>
                                    @elseif($contribution->contribution_status == 'Update')
                                        <span class="w-4 h-4 bg-blue-400 rounded-full mr-3"></span>
                                    @elseif($contribution->contribution_status == 'Select')
                                        <span class="w-4 h-4 bg-green-400 rounded-full mr-3"></span>
                                    @elseif($contribution->contribution_status == 'Publish')
                                        <span class="w-4 h-4 bg-purple-400 rounded-full mr-3"></span>
                                    @endif
                                    {{ $contribution->contribution_status }}
                                </div>
                            </div>

                            <!-- Approval Options -->
                            <div class="mt-12">
                                <h2 class="text-3xl font-bold mb-8">Approval Options</h2>
                                <form
                                    action="{{ route('marketingcoordinator.submission-management.update-status', $contribution->contribution_id) }}"
                                    method="POST" class="flex flex-wrap gap-4 select-none">
                                    @csrf
                                    <button type="submit" name="status" value="Select"
                                        class="bg-green-400 hover:bg-green-500 text-black px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Select
                                    </button>
                                    <button type="submit" name="status" value="Reject"
                                        class="bg-red-400 hover:bg-red-500 text-black px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Reject
                                    </button>
                                    <button type="submit" name="status" value="Upload"
                                        class="bg-blue-300 hover:bg-blue-400 text-black px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Give Feedback
                                    </button>
                                    <a href="{{ route('marketingcoordinator.submission-management') }}"
                                        class="bg-black text-white px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Back
                                    </a>
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
