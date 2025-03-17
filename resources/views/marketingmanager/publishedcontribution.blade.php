<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    <!-- Load Tippy.js -->
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>

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
            @include('marketingmanager.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            @include('marketingmanager.header')
            <!-- Content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Published Contributions</h1>

                <div class="max-w-full mx-auto shadow-lg p-6 bg-white mt-4 rounded-md">
                    <h1 class="text-2xl font-bold mb-4">List of Published Contributions</h1>
                    <h2 class="text-lg font-semibold mb-4 text-gray-400">Total - {{ $contributions->total() }}</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach ($contributions as $contribution)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-2 border-b flex justify-start">
                                <!-- Tooltip and Button -->
                                <button class="text-gray-600 download-zip" data-contribution-id="{{ $contribution->contribution_id }}" data-tippy-content="Download Zip">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}" alt="{{ $contribution->contribution_title }}" class="w-full h-5/6 object-cover">
                                <div class="mt-4 text-center">
                                    <a href="{{ route('marketingmanager.publishedcontributionviewdetail', $contribution->contribution_id) }}" class="text-blue-600 font-medium hover:underline">View</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-10 flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-500 mb-4 md:mb-0">
                            Showing {{ $contributions->firstItem() }} to {{ $contributions->lastItem() }} of {{ $contributions->total() }} results
                        </div>
                        <div class="flex items-center">
                            {{ $contributions->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle & Zip Download -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('translate-x-full');
        });

        // Add download functionality
        document.querySelectorAll('.download-zip').forEach(button => {
            button.addEventListener('click', function() {
                const contributionId = this.getAttribute('data-contribution-id');
                window.location.href = `/marketingmanager/download-contribution-zip/${contributionId}`;
            });
        });

        // Initialize Tippy.js
        tippy('.download-zip', {
            placement: 'top', // Position of the tooltip
            animation: 'fade', // Animation type
            arrow: true, // Show arrow
        });
    </script>
</body>

</html>