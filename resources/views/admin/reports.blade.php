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
            @include('admin.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden bg-[#F1F5F9] lg:ml-64">
            @include('admin.header')

            <!-- Main Content Container -->
            <div class="p-8 bg-white m-5 shadow-lg">
                <!-- Header -->
                <h1 class="text-2xl font-bold mb-6">List of Published Contributions</h1>
                <h2 class=" text-lg font-semibold text-gray-400 mb-4">
                    Total - {{ $published_contributions->count() }}
                </h2>

                <!-- Search and Filters -->
                <form method="GET" action="{{ route('admin.reports') }}">
                    <div class="flex flex-col md:flex-row gap-4 md:gap-0 justify-between mb-8">
                        <!-- Search Input -->
                        <div class="relative max-w-[400px]">
                            <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                                class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <!-- Faculty Filter -->
                            <select name="faculty" onchange="this.form.submit()"
                                class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                <option value="">All Faculties</option>
                                @foreach ($all_faculties as $faculty)
                                    <option value="{{ $faculty->faculty_id }}"
                                        {{ request('faculty') == $faculty->faculty_id ? 'selected' : '' }}>
                                        {{ $faculty->faculty }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Sort Option -->
                            <select name="sort" onchange="this.form.submit()"
                                class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest
                                </option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest
                                </option>
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
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">No</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Contribution Title
                                    </th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Faculty</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Student</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Published Date
                                    </th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Views</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @if ($published_contributions->isNotEmpty())
                                    @foreach ($published_contributions as $published_contribution)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $published_contribution->contribution_title }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $published_contribution->user->faculty->faculty }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    @if ($published_contribution->profile_image)
                                                        <img id="profilePreview"
                                                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                                            src="{{ asset('profile_images/' . $published_contribution->user->profile_image) }}"
                                                            alt="Profile">
                                                    @else
                                                        <p
                                                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                            {{ strtoupper($published_contribution->user->username[0]) }}
                                                        </p>
                                                    @endif
                                                    <div>
                                                        <div class="font-medium">
                                                            {{ $published_contribution->user->first_name . ' ' . $published_contribution->user->last_name }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $published_contribution->user->email }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $published_contribution->published_date ? $published_contribution->published_date->format('M d, Y') : 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $published_contribution->view_count }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-24 text-gray-600 text-center" colspan="6">
                                            No published contributions found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($published_contributions->isNotEmpty())
                    <div class="flex justify-end items-center gap-2 mt-6">
                        {{ $published_contributions->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>

            {{-- Commented Contributions --}}
            <div class="p-8 bg-white m-5 shadow-lg">
                <!-- Header -->
                <h1 class="text-2xl font-bold mb-6">List of Feedbacked Contributions</h1>
                <h2 class=" text-lg font-semibold text-gray-400 mb-4">
                    Total - {{ $feedbacked_contributions->count() }}
                </h2>

                <!-- Search and Filters -->
                <!-- Form for Feedbacked Contributions -->
                <form method="GET" action="{{ route('admin.reports') }}">
                    <div class="flex flex-col md:flex-row gap-4 md:gap-0 justify-between mb-8">
                        <!-- Search Input -->
                        <div class="relative max-w-[400px]">
                            <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            <input type="text" name="feedback_search" value="{{ request('feedback_search') }}"
                                placeholder="Search Feedback..."
                                class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <!-- Faculty Filter -->
                            <select name="feedback_faculty" onchange="this.form.submit()"
                                class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                <option value="">All Faculties</option>
                                @foreach ($all_faculties as $faculty)
                                    <option value="{{ $faculty->faculty_id }}"
                                        {{ request('feedback_faculty') == $faculty->faculty_id ? 'selected' : '' }}>
                                        {{ $faculty->faculty }}
                                    </option>
                                @endforeach
                            </select>

                            <!-- Sort Option -->
                            <select name="feedback_sort" onchange="this.form.submit()"
                                class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                <option value="desc" {{ request('feedback_sort') == 'desc' ? 'selected' : '' }}>
                                    Newest</option>
                                <option value="asc" {{ request('feedback_sort') == 'asc' ? 'selected' : '' }}>
                                    Oldest</option>
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
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">No</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Contribution
                                        Title</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Feedbacker</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Feedback</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Feedbacked Date
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @if ($feedbacked_contributions->isNotEmpty())
                                    @foreach ($feedbacked_contributions as $feedback)
                                        <tr>
                                            <!-- Display the row number -->
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $loop->iteration }} <!-- Increment the counter -->
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $feedback->contribution->contribution_title ?? 'No Title' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    @if ($feedback->user->profile_image)
                                                        <img id="profilePreview"
                                                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base"
                                                            src="{{ asset('storage/profile_images/' . $feedback->user->profile_image) }}"
                                                            alt="Profile">
                                                    @else
                                                        <p
                                                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                            {{ strtoupper($feedback->user->username[0] ?? 'N') }}
                                                        </p>
                                                    @endif
                                                    <div>
                                                        <div class="font-medium">
                                                            {{ $feedback->user->first_name ?? 'First Name' }}
                                                            {{ $feedback->user->last_name ?? 'Last Name' }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $feedback->user->email ?? 'No email available' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $feedback->feedback ?? 'No Feedback' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $feedback->feedback_given_date->format('M d, Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-24 text-gray-600 text-center" colspan="6">
                                            No feedbacked contributions found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($feedbacked_contributions->isNotEmpty())
                    <div class="flex justify-end items-center gap-2 mt-6">
                        {{ $feedbacked_contributions->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>

            <div class="p-8 bg-white m-5 shadow-lg">
                <!-- Header -->
                <h1 class="text-2xl font-bold mb-6">List of Contributions by Faculty (Per Academic Year)</h1>

                <!-- Academic Year Filter -->
                <form action="{{ route('admin.reports') }}" method="GET">
                    <select class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300"
                        name="academic_year" id="academic_year" onchange="this.form.submit()">
                        <option value="" selected>Select Academic Years</option>
                        @foreach ($academicYears as $id => $year)
                            <option value="{{ $id }}"
                                {{ request('academic_year') == $id ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Chart Canvas for Count -->
                <div style="width: 100%; margin: 0 auto;">
                    <canvas id="countChart"></canvas>
                </div>

                <!-- Chart Script for Count -->
                <script>
                    const countCtx = document.getElementById('countChart').getContext('2d');
                    const countChart = new Chart(countCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($labels),
                            datasets: [{
                                label: 'Number of Contributions',
                                data: @json($countData),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 20, // Set the step size to 20
                                    },
                                    title: {
                                        display: true,
                                        text: 'Number of Contributions'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>

            <div class="p-8 bg-white m-5 shadow-lg">
                <!-- Header -->
                <h1 class="text-2xl font-bold mb-6">List of Percentage of Contributions by Each Faculty</h1>

                <!-- Academic Year Filter -->
                <form action="{{ route('admin.reports') }}" method="GET">
                    <select class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300"
                        name="academic_year" id="academic_year" onchange="this.form.submit()">
                        <option value="" selected>Select Academic Years</option>
                        @foreach ($academicYears as $id => $year)
                            <option value="{{ $id }}"
                                {{ request('academic_year') == $id ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Chart Canvas for Percentage -->
                <div style="width: 100%; margin: 0 auto; margin-top: 40px;">
                    <canvas id="percentageChart"></canvas>
                </div>

                <!-- Chart Script for Percentage -->
                <script>
                    const percentageCtx = document.getElementById('percentageChart').getContext('2d');
                    const percentageChart = new Chart(percentageCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($labels),
                            datasets: [{
                                label: 'Percentage of Contributions',
                                data: @json($percentageData),
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 20, // Set the step size to 20
                                        callback: function(value) {
                                            return value + '%'; // Append '%' to the y-axis values
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Percentage of Contributions'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>

            <div class="p-8 bg-white m-5 shadow-lg">
                <!-- Header -->
                <h1 class="text-2xl font-bold mb-6">Number of Contributors Within Each Faculty for Each Academic Year
                </h1>

                <!-- Academic Year Filter -->
                <form action="{{ route('admin.reports') }}" method="GET">
                    <select class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300"
                        name="academic_year" id="academic_year" onchange="this.form.submit()">
                        <option value="" selected>Select Academic Years</option>
                        @foreach ($academicYears as $id => $year)
                            <option value="{{ $id }}"
                                {{ request('academic_year') == $id ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Chart Canvas for Contributor Count -->
                <div style="width: 100%; margin: 0 auto;">
                    <canvas id="contributorCountChart"></canvas>
                </div>

                <!-- Chart Script for Contributor Count -->
                <script>
                    const contributorCountCtx = document.getElementById('contributorCountChart').getContext('2d');
                    const contributorCountChart = new Chart(contributorCountCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($labels),
                            datasets: [{
                                label: 'Number of Contributors',
                                data: @json($contributorCountData),
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 20, // Set the step size to 20
                                    },
                                    title: {
                                        display: true,
                                        text: 'Number of Contributors'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>

            <div class="p-8 bg-white m-5 shadow-lg">
                <!-- Header -->
                <h1 class="text-2xl font-bold mb-6">List of Participation Published Contributions</h1>

                <!-- Academic Year Filter -->
                <form action="{{ route('admin.reports') }}" method="GET">
                    <select class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300"
                        name="academic_year" id="academic_year" onchange="this.form.submit()">
                        <option value="" selected>Select Academic Years</option>
                        @foreach ($academicYears as $id => $year)
                            <option value="{{ $id }}"
                                {{ request('academic_year') == $id ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <!-- Chart Canvas for Contributor Percentage -->
                <div style="width: 100%; margin: 0 auto; margin-top: 40px;">
                    <canvas id="contributorPercentageChart"></canvas>
                </div>

                <!-- Chart Script for Contributor Percentage -->
                <script>
                    const contributorPercentageCtx = document.getElementById('contributorPercentageChart').getContext('2d');
                    const contributorPercentageChart = new Chart(contributorPercentageCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($labels),
                            datasets: [{
                                label: 'Percentage of Contributors',
                                data: @json($contributorPercentageData),
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 20, // Set the step size to 20
                                        callback: function(value) {
                                            return value + '%'; // Append '%' to the y-axis values
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Percentage of Contributors'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
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
