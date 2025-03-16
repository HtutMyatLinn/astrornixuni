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
                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">Review Contributions</h1>

                    <div class="p-8 bg-white shadow-lg">
                        <h1 class="text-xl font-bold mb-6">List of Submitted Contributions</h1>
                        <!-- Search and Filters -->
                        <div class="flex justify-between mb-8">
                            <div class="relative w-[400px]">
                                <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                                <input type="text" placeholder="Search..." name="search"
                                    class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                            </div>
                            <div class="flex gap-4">
                                <!-- Filter Dropdown -->
                                <select name="status" class="px-6 py-2.5 rounded-lg bg-[#F1F5F9] hover:bg-gray-100">
                                    <option value="">All Statuses</option>
                                    <option value="upload">Upload</option>
                                    <option value="update">Update</option>
                                    <option value="reject">Rejected</option>
                                    <option value="publish">Published</option>
                                </select>
                                <!-- Sort Dropdown -->
                                <select name="sort" class="px-6 py-2.5 rounded-lg bg-[#F1F5F9] hover:bg-gray-100">
                                    <option value="desc">Newest First</option>
                                    <option value="asc">Oldest First</option>
                                </select>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="bg-white rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Contributions Title</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Contributions Type</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Student
                                                Name</th>
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
                                                    <td class="px-6 py-4">{{ $contribution->contribution_title }}</td>
                                                    <td class="px-6 py-4">
                                                        {{ $contribution->category->contribution_category }}</td>
                                                    <td class="px-6 py-4">{{ $contribution->user->username }}</td>
                                                    <td class="px-6 py-4">{{ $contribution->submitted_date }}</td>
                                                    <td class="px-6 py-4">
                                                        <span
                                                            class="px-3 py-1 rounded-full text-sm {{ $contribution->contribution_status == 'Upload' ? 'bg-[#FCD53F]' : ($contribution->contribution_status == 'Reviewed' ? 'bg-[#CAF4E0]' : ($contribution->contribution_status == 'Published' ? 'bg-[#65FF51]' : 'bg-[#81CBEF]')) }} text-black">{{ $contribution->contribution_status }}</span>
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <a href="{{ route('marketingcoordinator.submission-management.view-detail-contribution', $contribution->contribution_id) }}"
                                                            class="text-[#2F64AA]">View</a>
                                                    </td>
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
