<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Published Contributions Report</h1>

                <div class="max-w-full mx-auto mt-4">
                    <div class="p-8 bg-white shadow-lg rounded-md">
                        <!-- Header -->
                        <h1 class="text-xl font-bold mb-6">List of Published Contributions</h1>

                        <!-- Search and Filters -->
                        <form action="{{ route('marketingmanager.report') }}" method="GET">
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between mb-8">
                                <!-- Search Input -->
                                <div class="relative w-[400px]">
                                    <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    <input type="text" name="search" placeholder="Search by title or student name"
                                        value="{{ request('search') }}"
                                        class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                                </div>

                                <!-- Filter and Sort Dropdowns -->
                                <div class="flex flex-wrap gap-4">
                                    <!-- Faculty Filter -->
                                    <div class="relative group">
                                        <select name="faculty" onchange="this.form.submit()"
                                            class="flex items-center gap-2 px-6 py-2.5 rounded-lg bg-[#F1F5F9] hover:bg-gray-100">
                                            <option value="all" {{ request('faculty') == 'all' ? 'selected' : '' }}>All
                                                Faculties</option>
                                            @foreach ($faculties as $faculty)
                                            <option value="{{ $faculty->faculty_id }}"
                                                {{ request('faculty') == $faculty->faculty_id ? 'selected' : '' }}>
                                                {{ $faculty->faculty }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Sort Dropdown -->
                                    <div class="relative group">
                                        <select name="sort" onchange="this.form.submit()"
                                            class="flex items-center gap-2 px-6 py-2.5 rounded-lg bg-[#F1F5F9] hover:bg-gray-100">
                                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest
                                                First</option>
                                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest
                                                First</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Table -->
                        <div class="bg-white rounded-lg overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="w-full">
                                    <thead class="bg-[#F9F8F8]">
                                        <tr>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">No</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Title</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Faculty
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Student
                                                Name</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Published
                                                Date</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Views
                                            </th>
                                        </tr>
                                    </thead>
                                    <!-- Inside the <tbody> section -->
                                    <tbody class="divide-y divide-gray-100">
                                        @forelse ($contributions as $index => $contribution)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <div class="font-medium">{{ $contribution->contribution_title }}</div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">{{ $contribution->user->faculty->faculty }}</td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $contribution->user->first_name }} {{ $contribution->user->last_name }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $contribution->published_date }}
                                            </td>
                                            <td class="px-6 py-4 text-[#2F64AA]">
                                                {{ $contribution->view_count }}
                                            </td>
                                        </tr>
                                        @empty
                                        <!-- Empty State -->
                                        <tr>
                                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                                <div class="flex flex-col items-center justify-center py-12">
                                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p class="mt-4 text-lg font-medium text-gray-900">No published contributions found.</p>
                                                    <p class="text-sm text-gray-500">Try adjusting your filters or search terms.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
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