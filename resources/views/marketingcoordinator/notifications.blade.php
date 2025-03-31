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
                    <h1 class=" text-2xl sm:text-2xl font-bold text-gray-900">System Notifications & Alerts</h1>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Total Students Card -->
                        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
                            <!-- Avatar Circle -->
                            <div
                                class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                <img class=" w-5 h-5" src="{{ asset('images/totalpendingcontributions.png') }}"
                                    alt="">
                            </div>

                            <!-- Stats Container with Flexbox -->
                            <div class="flex items-end justify-between">
                                <!-- Numbers -->
                                <div class="space-y-1">
                                    <h2 class="text-3xl font-bold">{{ $pending_review->count() }}</h2>
                                    <p class="text-xl text-gray-400">Pending Review Remiders</p>
                                </div>

                                <!-- Percentage -->
                                <div class="flex items-center gap-1">
                                    @if ($pending_review_percentage_change > 0)
                                        <span
                                            class="text-emerald-500 text-xl font-medium">{{ $pending_review_percentage_change }}%
                                            ↑</span>
                                    @elseif ($pending_review_percentage_change < 0)
                                        <span
                                            class="text-red-500 text-xl font-medium">{{ abs($pending_review_percentage_change) }}%
                                            ↓</span>
                                    @else
                                        <span class="text-gray-500 text-xl font-medium">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Total submissions Card -->
                        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
                            <!-- Avatar Circle -->
                            <div
                                class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                <img class=" w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}" alt="">
                            </div>

                            <!-- Stats Container with Flexbox -->
                            <div class="flex items-end justify-between">
                                <!-- Numbers -->
                                <div class="space-y-1">
                                    <h2 class="text-3xl font-bold">{{ $total_feedback_sent }}</h2>
                                    <p class="text-xl text-gray-400">Total Feedback Sent</p>
                                </div>

                                <!-- Percentage -->
                                <div class="flex items-center gap-1">
                                    @if ($feedback_percentage_change > 0)
                                        <span
                                            class="text-emerald-500 text-xl font-medium">{{ $feedback_percentage_change }}%
                                            ↑</span>
                                    @elseif ($feedback_percentage_change < 0)
                                        <span
                                            class="text-red-500 text-xl font-medium">{{ abs($feedback_percentage_change) }}%
                                            ↓</span>
                                    @else
                                        <span class="text-gray-500 text-xl font-medium">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Total Pending Contributions Card -->
                        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
                            <!-- Avatar Circle -->
                            <div
                                class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                <img class=" w-5 h-5" src="{{ asset('images/totalpendingcontributions.png') }}"
                                    alt="">
                            </div>

                            <!-- Stats Container with Flexbox -->
                            <div class="flex items-end justify-between">
                                <!-- Numbers -->
                                <div class="space-y-1">
                                    <h2 class="text-3xl font-bold">{{ $resubmitted_contributions->count() }}</h2>
                                    <p class="text-xl text-gray-400">Resubmitted Contribution</p>
                                </div>

                                <!-- Percentage -->
                                <div class="flex items-center gap-1">
                                    @if ($update_contributions_percentage_change > 0)
                                        <span
                                            class="text-emerald-500 text-xl font-medium">{{ $update_contributions_percentage_change }}%
                                            ↑</span>
                                    @elseif ($update_contributions_percentage_change < 0)
                                        <span
                                            class="text-red-500 text-xl font-medium">{{ abs($update_contributions_percentage_change) }}%
                                            ↓</span>
                                    @else
                                        <span class="text-gray-500 text-xl font-medium">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- Total submissions Card -->
                        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full col-span-1 md:col-span-3">
                            <!-- Avatar Circle -->
                            <div
                                class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                <img class=" w-5 h-5" src="{{ asset('images/totalstudents.png') }}" alt="">
                            </div>

                            <!-- Stats Container with Flexbox -->
                            <div class="flex items-end justify-between">
                                <!-- Numbers -->
                                <div class="space-y-1">
                                    <h2 class="text-3xl font-bold">{{ $faculty_guests }}</h2>
                                    <p class="text-xl text-gray-400">New Guest Registration</p>
                                </div>

                                <!-- Percentage -->
                                <div class="flex items-center gap-1">
                                    @if ($faculty_guests_percentage_change > 0)
                                        <span
                                            class="text-emerald-500 text-xl font-medium">{{ $faculty_guests_percentage_change }}%
                                            ↑</span>
                                    @elseif ($faculty_guests_percentage_change < 0)
                                        <span
                                            class="text-red-500 text-xl font-medium">{{ abs($faculty_guests_percentage_change) }}%
                                            ↓</span>
                                    @else
                                        <span class="text-gray-500 text-xl font-medium">0%</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Resubmitted Contributions for Review</h1>

                    <!-- Table Section -->
                    <div class="p-8 bg-white shadow-lg mb-8">
                        <h1 class="text-xl font-bold mb-6">Resubmitted Contributions</h1>
                        <form action="{{ route('marketingcoordinator.notifications') }}" method="GET">
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
                                    <div class="relative group">
                                        <button type="button"
                                            class="flex items-center gap-2 px-6 py-2.5 rounded-lg bg-[#F1F5F9] hover:bg-gray-100">
                                            Sort By
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m6 9 6 6 6-6" />
                                            </svg>
                                        </button>
                                        <div
                                            class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-10">
                                            <div class="p-2">
                                                <button type="submit" name="sort" value="desc"
                                                    class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left {{ request('sort') == 'desc' ? 'bg-blue-50 text-blue-600' : '' }}">
                                                    Newest First
                                                </button>
                                                <button type="submit" name="sort" value="asc"
                                                    class="w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg text-left {{ request('sort') == 'asc' ? 'bg-blue-50 text-blue-600' : '' }}">
                                                    Oldest First
                                                </button>
                                            </div>
                                        </div>
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
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Contribution Title</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                Contribution Category</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Student
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Submitted
                                                Date</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @if ($contributions->isNotEmpty())
                                            @foreach ($contributions as $contribution)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 text-gray-600">
                                                        <div class="flex items-center gap-3">
                                                            <div>
                                                                <div class="font-medium">
                                                                    {{ $contribution->contribution_title }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 text-gray-600">
                                                        {{ $contribution->category->contribution_category }}</td>
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
                                                        {{ $contribution->submitted_date->format('M d, Y') }}</td>
                                                    <td class="px-6 py-4">
                                                        <a href="{{ route('marketingcoordinator.submission-management.view-detail-contribution', $contribution->contribution_id) }}"
                                                            class="text-[#2F64AA]">View</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-24 text-gray-600 text-center" colspan="7">
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
