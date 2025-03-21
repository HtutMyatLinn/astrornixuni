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
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h1 class="text-2xl font-bold mb-4">List of Published Contributions</h1>
                            <h2 class="text-lg font-semibold text-gray-400">Total - {{ $contributions->total() }}
                            </h2>
                        </div>
                        <button id="downloadSelected"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 h-fit self-center select-none">
                            Download Selected
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @if ($contributions->isNotEmpty())
                            @foreach ($contributions as $contribution)
                                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                    <div class="py-2 flex justify-between items-center">
                                        <!-- Custom SVG Checkbox -->
                                        <div class="cursor-pointer contribution-checkbox"
                                            data-contribution-id="{{ $contribution->contribution_id }}"
                                            data-tippy-content="Select this contribution for download">
                                            <!-- Unchecked State -->
                                            <svg class="h-5 w-5 text-gray-400 unchecked-icon" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <!-- Checked State (Hidden by Default) -->
                                            <svg class="h-5 w-5 text-blue-500 checked-icon hidden" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @if ($contribution->contribution_cover)
                                        <!-- Display the contribution cover image if it exists -->
                                        <div class="h-56">
                                            <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                                alt="{{ $contribution->contribution_title }}"
                                                class="w-full h-full object-cover select-none">
                                        </div>
                                    @else
                                        <!-- Display the default logo image if contribution_cover is null -->
                                        <div class="flex h-56 w-full items-center justify-center">
                                            <!-- Center the logo -->
                                            <div class="w-24 select-none">
                                                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="mt-4 text-center">
                                        <a href="{{ route('marketingmanager.publishedcontributionviewdetail', $contribution->contribution_id) }}"
                                            class="text-blue-600 font-medium hover:underline">View</a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p class="px-6 py-24 text-gray-600 text-center col-span-4">
                                No contributions found.
                            </p>
                        @endif
                    </div>

                    <!-- Include Tippy.js CSS -->
                    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/dist/tippy.css" />

                    <!-- Include Tippy.js JavaScript -->
                    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

                    <!-- JavaScript to Handle Checkbox Toggle and Download Selected -->
                    <script>
                        // Initialize Tippy.js for tooltips
                        tippy('.contribution-checkbox', {
                            placement: 'top', // Tooltip position
                            arrow: true, // Show arrow
                        });

                        // Toggle Checkbox State
                        document.querySelectorAll('.contribution-checkbox').forEach(checkbox => {
                            checkbox.addEventListener('click', function() {
                                const contributionId = this.getAttribute('data-contribution-id');
                                const uncheckedIcon = this.querySelector('.unchecked-icon');
                                const checkedIcon = this.querySelector('.checked-icon');

                                // Toggle visibility of checked/unchecked icons
                                uncheckedIcon.classList.toggle('hidden');
                                checkedIcon.classList.toggle('hidden');

                                // Toggle the selected state
                                this.classList.toggle('selected');
                            });
                        });

                        // Handle Download Selected
                        // Handle Download Selected
                        document.getElementById('downloadSelected').addEventListener('click', function() {
                            // Get all selected contribution IDs
                            const selectedContributions = Array.from(document.querySelectorAll('.contribution-checkbox.selected'))
                                .map(checkbox => checkbox.getAttribute('data-contribution-id'));

                            if (selectedContributions.length === 0) {
                                alert('Please select at least one contribution to download.');
                                return;
                            }

                            // Fetch the intake details for the selected contributions
                            fetch("{{ route('marketingmanager.checkIntakeStatus') }}", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        contributionIds: selectedContributions
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.error) {
                                        alert(data
                                        .error); // Show error message if intake is not active or final_closure_date has not passed
                                    } else {
                                        // Unselect all checkboxes after initiating the download
                                        document.querySelectorAll('.contribution-checkbox.selected').forEach(checkbox => {
                                            const uncheckedIcon = checkbox.querySelector('.unchecked-icon');
                                            const checkedIcon = checkbox.querySelector('.checked-icon');

                                            // Show the unchecked icon and hide the checked icon
                                            uncheckedIcon.classList.remove('hidden');
                                            checkedIcon.classList.add('hidden');

                                            // Remove the selected class
                                            checkbox.classList.remove('selected');
                                        });

                                        // Redirect to the download route with selected contribution IDs
                                        window.location.href =
                                            "{{ route('marketingmanager.downloadMultipleContributions') }}?ids=" +
                                            selectedContributions.join(',');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                });
                        });
                    </script>

                    <!-- Pagination -->
                    <div class="mt-10 flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-500 mb-4 md:mb-0">
                            Showing {{ $contributions->firstItem() }} to {{ $contributions->lastItem() }} of
                            {{ $contributions->total() }} results
                        </div>
                        <div class="flex items-center">
                            {{ $contributions->links() }}
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle & File Download -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('translate-x-full');
        });

        // Initialize Tippy.js
        tippy('.download-zip', {
            placement: 'top', // Position of the tooltip
            animation: 'fade', // Animation type
            arrow: true, // Show arrow
        });

        // Add event listener for download buttons
        document.querySelectorAll('.download-zip').forEach(button => {
            button.addEventListener('click', function() {
                const contributionId = this.getAttribute('data-contribution-id');
                window.location.href = `/marketingmanager/download-contribution-zip/${contributionId}`;
            });
        });
    </script>
</body>

</html>
