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
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4">
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold mb-4">List of Published Contributions</h1>
                            <h2 class="text-lg font-semibold text-gray-400">Total - {{ $contributions->total() }}</h2>
                        </div>
                        <div class="flex w-full md:w-auto items-end md:items-center flex-col-reverse md:flex-row gap-2">
                            <button id="selectAllWithFiles"
                                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg h-fit self-end sm:self-center select-none">
                                Select All with Files
                            </button>
                            <button id="downloadSelected"
                                class="bg-black hover:bg-gray-700 text-white px-4 py-2 rounded-lg h-fit self-end sm:self-center select-none"
                                disabled>
                                Download Selected
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @if ($contributions->isNotEmpty())
                            @foreach ($contributions as $contribution)
                                <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                                    <div class="py-2 flex justify-between items-center">
                                        <div class="cursor-pointer contribution-checkbox"
                                            data-contribution-id="{{ $contribution->contribution_id }}"
                                            data-tippy-content="Select this contribution for download"
                                            @if (!$contribution->contribution_file_path) style="cursor: not-allowed;"
                                    title="No file available"
                                    data-disabled="true" @endif>
                                            <svg class="h-5 w-5 text-gray-400 unchecked-icon" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <rect x="4" y="4" width="16" height="16" rx="2"
                                                    ry="2" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <img class="h-5 w-5 checked-icon hidden select-none"
                                                src="{{ asset('images/tabler_checkbox.png') }}" alt="">
                                        </div>
                                    </div>

                                    @if ($contribution->contribution_cover)
                                        <div class="h-56">
                                            <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                                alt="{{ $contribution->contribution_title }}"
                                                class="w-full h-full object-cover select-none">
                                        </div>
                                    @else
                                        <div class="flex h-56 w-full items-center justify-center">
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

                                    <!-- Hidden File Path Element -->
                                    @if ($contribution->contribution_file_path)
                                        <div class="contribution-file-path hidden">
                                            {{ $contribution->contribution_file_path }}</div>
                                    @else
                                        <div class="contribution-file-path hidden"></div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <p class="px-6 py-24 text-gray-600 text-center col-span-4">
                                No contributions found.
                            </p>
                        @endif
                    </div>

                    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>

                    <script>
                        // Initialize Tippy.js for tooltips
                        tippy('.contribution-checkbox', {
                            placement: 'top',
                            arrow: true,
                        });

                        // Toggle Checkbox State
                        document.querySelectorAll('.contribution-checkbox').forEach(checkbox => {
                            checkbox.addEventListener('click', function() {
                                if (this.hasAttribute('data-disabled')) {
                                    return; // Prevent selection if checkbox is disabled
                                }
                                const uncheckedIcon = this.querySelector('.unchecked-icon');
                                const checkedIcon = this.querySelector('.checked-icon');

                                uncheckedIcon.classList.toggle('hidden');
                                checkedIcon.classList.toggle('hidden');

                                this.classList.toggle('selected');

                                // Enable/Disable Download Selected button
                                toggleDownloadButton();
                            });
                        });

                        // Select All Contributions with Files
                        let isAllSelected = false; // Tracks toggle state

                        document.getElementById('selectAllWithFiles').addEventListener('click', function() {
                            const allCheckboxes = document.querySelectorAll('.contribution-checkbox:not([data-disabled])');

                            if (!isAllSelected) {
                                // Select all with files
                                allCheckboxes.forEach(checkbox => {
                                    const uncheckedIcon = checkbox.querySelector('.unchecked-icon');
                                    const checkedIcon = checkbox.querySelector('.checked-icon');

                                    uncheckedIcon.classList.add('hidden');
                                    checkedIcon.classList.remove('hidden');
                                    checkbox.classList.add('selected');
                                });

                                isAllSelected = true;
                                this.textContent = 'Unselect All';
                            } else {
                                // Deselect all
                                document.querySelectorAll('.contribution-checkbox.selected').forEach(checkbox => {
                                    const uncheckedIcon = checkbox.querySelector('.unchecked-icon');
                                    const checkedIcon = checkbox.querySelector('.checked-icon');

                                    uncheckedIcon.classList.remove('hidden');
                                    checkedIcon.classList.add('hidden');
                                    checkbox.classList.remove('selected');
                                });

                                isAllSelected = false;
                                this.textContent = 'Select All with Files';
                            }

                            toggleDownloadButton();
                        });


                        // Enable/Disable Download Selected button
                        function toggleDownloadButton() {
                            const selectedContributions = Array.from(document.querySelectorAll('.contribution-checkbox.selected'))
                                .map(checkbox => checkbox.getAttribute('data-contribution-id'));

                            const downloadButton = document.getElementById('downloadSelected');
                            const hasFile = selectedContributions.some(contributionId => {
                                const filePath = document.querySelector(`[data-contribution-id="${contributionId}"]`)
                                    .closest('.bg-white')
                                    .querySelector('.contribution-file-path')
                                    .textContent;

                                return filePath && filePath.trim() !== '';
                            });

                            // Enable or disable the button
                            downloadButton.disabled = !hasFile;

                            // Update button label with count
                            const countText = selectedContributions.length > 0 ? ` (${selectedContributions.length})` : '';
                            downloadButton.textContent = `Download Selected${countText}`;

                            // Update the Select All button state
                            const selectAllButton = document.getElementById('selectAllWithFiles');
                            const totalWithFiles = document.querySelectorAll('.contribution-checkbox:not([data-disabled])').length;
                            selectAllButton.disabled = totalWithFiles === 0;
                        }

                        // Initialize the buttons on page load
                        document.addEventListener('DOMContentLoaded', function() {
                            toggleDownloadButton();
                        });

                        // Download Selected Contributions
                        document.getElementById('downloadSelected').addEventListener('click', function() {
                            const selectedContributions = Array.from(document.querySelectorAll('.contribution-checkbox.selected'))
                                .map(checkbox => checkbox.getAttribute('data-contribution-id'));

                            if (selectedContributions.length === 0) {
                                alert('Please select at least one contribution to download.');
                                return;
                            }

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
                                        alert(data.error);
                                    } else {
                                        // Clear the selection count from the button
                                        this.textContent = 'Download Selected';

                                        // Reset the select all state
                                        isAllSelected = false;
                                        document.getElementById('selectAllWithFiles').textContent = 'Select All with Files';

                                        // Reset all checkboxes
                                        document.querySelectorAll('.contribution-checkbox.selected').forEach(checkbox => {
                                            const uncheckedIcon = checkbox.querySelector('.unchecked-icon');
                                            const checkedIcon = checkbox.querySelector('.checked-icon');

                                            uncheckedIcon.classList.remove('hidden');
                                            checkedIcon.classList.add('hidden');
                                            checkbox.classList.remove('selected');
                                        });

                                        // Disable the download button
                                        this.disabled = true;

                                        // Proceed with download
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
    </script>
</body>

</html>
