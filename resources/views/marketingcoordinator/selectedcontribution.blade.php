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
                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">Selected Contributions</h1>

                    <div class="p-8 bg-white shadow-lg">
                        <h1 class="text-xl font-bold mb-6">List of Selected Contributions</h1>
                        <!-- Search and Filters -->
                        <form action="{{ route('marketingcoordinator.selected-contributions') }}" method="GET">
                            <div class="flex flex-col md:flex-row gap-4 md:gap-0 justify-between mb-8">
                                <div class="relative max-w-[400px]">
                                    <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search..."
                                        class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                                </div>
                                <div class="flex gap-4">
                                    <!-- Sort Dropdown -->
                                    <select name="sort" onchange="this.form.submit()"
                                        class="px-6 py-2.5 rounded-lg bg-[#F1F5F9] hover:bg-gray-100">
                                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest
                                            First</option>
                                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest
                                            First</option>
                                    </select>
                                </div>
                            </div>
                        </form>



                        <!-- Table -->
                        <div class="bg-white rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Contribution Title</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Contribution Category</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Student
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Submitted
                                                Date</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Status
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @if ($contributions->isNotEmpty())
                                            @foreach ($contributions as $contribution)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 text-gray-600">
                                                        {{ $contribution->contribution_title }}
                                                    </td>
                                                    <td class="px-6 py-4 text-gray-600">
                                                        {{ $contribution->category->contribution_category }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <div class="flex items-center gap-3">
                                                            @if ($contribution->user->profile_image)
                                                                <img id="profilePreview"
                                                                    class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                                                    src="{{ asset('profile_images/' . $contribution->user->profile_image) }}"
                                                                    alt="Profile">
                                                            @else
                                                                <p
                                                                    class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                                    {{ strtoupper($contribution->user->username[0]) }}
                                                                </p>
                                                            @endif
                                                            <div>
                                                                <div class="font-medium">
                                                                    {{ $contribution->user->first_name . ' ' . $contribution->user->last_name }}
                                                                </div>
                                                                <div class="text-sm text-gray-500">
                                                                    {{ $contribution->user->email }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-gray-600">
                                                        {{ $contribution->submitted_date->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-6 py-4 text-gray-600">
                                                        <span
                                                            class="px-3 py-1 rounded-full text-sm {{ $contribution->contribution_status == 'Upload' ? 'bg-[#FCD53F]' : ($contribution->contribution_status == 'Reviewed' ? 'bg-[#CAF4E0]' : ($contribution->contribution_status == 'Published' ? 'bg-[#65FF51]' : 'bg-[#81CBEF]')) }} text-black">
                                                            {{ $contribution->contribution_status == 'Select' ? 'Selected' : $contribution->contribution_status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <form
                                                            action="{{ route('marketingcoordinator.submission-management.publish-contribution', $contribution->contribution_id) }}"
                                                            method="POST" id="publishForm">
                                                            @csrf
                                                            <button type="submit" id="publishButton"
                                                                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md select-none flex items-center justify-center {{ now() < $contribution->intake->final_closure_date ? 'opacity-50 cursor-not-allowed' : '' }}"
                                                                {{ now() < $contribution->intake->final_closure_date ? 'disabled' : '' }}>
                                                                <span id="publishText">Publish</span>
                                                                <svg id="publishSpinner"
                                                                    class="animate-spin ml-2 h-4 w-4 text-white hidden"
                                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12"
                                                                        cy="12" r="10" stroke="currentColor"
                                                                        stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor"
                                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    </td>

                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            const publishForm = document.getElementById("publishForm");
                                                            const publishButton = document.getElementById("publishButton");
                                                            const publishText = document.getElementById("publishText");
                                                            const publishSpinner = document.getElementById("publishSpinner");

                                                            if (publishForm) {
                                                                publishForm.addEventListener("submit", function(e) {
                                                                    publishButton.disabled = true;
                                                                    publishText.textContent = "Publishing...";
                                                                    publishSpinner.classList.remove("hidden");
                                                                });
                                                            }
                                                        });
                                                    </script>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-24 text-gray-600 text-center" colspan="6">
                                                    No contributions found.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-end items-center gap-2 mt-6">
                            {{ $contributions->links() }}
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
