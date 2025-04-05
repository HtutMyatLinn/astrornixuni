<main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

    <div class="flex items-center justify-between mb-4">
        <div class="space-y-4">
            @if (Auth::user()->login_count === 1)
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                    Welcome, {{ Auth::user()->username }}
                </h1>
                <h2 class="text-sm sm:text-lg text-gray-500">
                    Here is what's happening in your university today.
                </h2>
            @else
                <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                    Welcome Back, {{ Auth::user()->username }}!
                </h1>
                <h2 class="text-sm sm:text-lg text-gray-500">
                    Here is what's new in your university today.
                </h2>
            @endif
        </div>
        <div class="text-right">
            <p class="text-sm sm:text-base font-bold text-gray-900">
                Last Login at : <span
                    class="text-sm sm:text-base font-normal text-gray-500">{{ \Carbon\Carbon::parse(Auth::user()->last_login_date)->format('j-F-Y') }}</span>
            </p>
            <p class="text-sm sm:text-base font-normal text-gray-500">
                {{ \Carbon\Carbon::parse(Auth::user()->last_login_date)->format('h:i A') }}
            </p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white p-6 w-full flex flex-col items-center row-span-2 rounded-lg">
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-5">Uploaded vs Published Rate Contributions</h1>
            <p>This chart compares publishing rate of contributions submitted by students and see how many have been
                approved for publication.</p>
            <div style="width: 80%;">
                <canvas id="contributionChart"></canvas>
            </div>
        </div>

        <!-- Include Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            var ctx = document.getElementById('contributionChart').getContext('2d');
            var contributionChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($labels), // Labels for the chart
                    datasets: [{
                        label: 'Contributions',
                        data: @json($data), // Data for the chart
                        backgroundColor: [
                            'rgba(250, 204, 21, 0.2)', // Yellow for Uploaded (bg-yellow-400)
                            'rgba(34, 197, 94, 0.2)', // Green for Published (bg-green-400)
                        ],
                        borderColor: [
                            'rgba(250, 204, 21, 1)', // Yellow for Uploaded (bg-yellow-400)
                            'rgba(34, 197, 94, 1)', // Green for Published (bg-green-400)
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'start', // Align the legend to the start (left) of the container
                            labels: {
                                boxWidth: 20, // Adjust the width of the color box
                                padding: 10, // Adjust the padding between legend items
                                usePointStyle: true, // Use point style for a cleaner look
                            },
                            display: true,
                            layout: {
                                padding: {
                                    top: 10,
                                    bottom: 10
                                }
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += context.raw + ' contributions';
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        </script>

        <!-- Total Students Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/total_users.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $faculty_guests->count() }}</h2>
                    <p class="text-xl text-gray-400">New Guest Registration</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($faculty_guests_percentage_change > 0)
                        <span class="text-emerald-500 text-xl font-medium">{{ $faculty_guests_percentage_change }}%
                            ↑</span>
                    @elseif ($faculty_guests_percentage_change < 0)
                        <span class="text-red-500 text-xl font-medium">{{ abs($faculty_guests_percentage_change) }}%
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
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalinquiry.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $total_contributions->count() }}</h2>
                    <p class="text-xl text-gray-400">Total Submissions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($contributions_percentage_change > 0)
                        <span class="text-emerald-500 text-xl font-medium">{{ $contributions_percentage_change }}%
                            ↑</span>
                    @elseif ($contributions_percentage_change < 0)
                        <span class="text-red-500 text-xl font-medium">{{ abs($contributions_percentage_change) }}%
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
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/total_users.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $total_students->count() }}</h2>
                    <p class="text-xl text-gray-400">Total Students</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($student_percentage_change > 0)
                        <span class="text-emerald-500 text-xl font-medium">{{ $student_percentage_change }}% ↑</span>
                    @elseif ($student_percentage_change < 0)
                        <span class="text-red-500 text-xl font-medium">{{ abs($student_percentage_change) }}% ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Total faculty Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalpendingcontributions.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $pending_contributions->count() }}</h2>
                    <p class="text-xl text-gray-400">Pending Contributions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($pending_contributions_percentage_change > 0)
                        <span
                            class="text-emerald-500 text-xl font-medium">{{ $pending_contributions_percentage_change }}%
                            ↑</span>
                    @elseif ($pending_contributions_percentage_change < 0)
                        <span
                            class="text-red-500 text-xl font-medium">{{ abs($pending_contributions_percentage_change) }}%
                            ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Total approved contributions Card-->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalinquiry.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $selected_contributions->count() }}</h2>
                    <p class="text-xl text-gray-400">Selected Contributions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($selected_contributions_percentage_change > 0)
                        <span
                            class="text-emerald-500 text-xl font-medium">{{ $selected_contributions_percentage_change }}%
                            ↑</span>
                    @elseif ($selected_contributions_percentage_change < 0)
                        <span
                            class="text-red-500 text-xl font-medium">{{ abs($selected_contributions_percentage_change) }}%
                            ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Total Faculties Card-->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class=" w-5 h-5" src="{{ asset('images/rejectcontri.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $rejected_contributions->count() }}</h2>
                    <p class="text-xl text-gray-400">Rejected Contributions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($rejected_contributions_percentage_change > 0)
                        <span
                            class="text-emerald-500 text-xl font-medium">{{ $rejected_contributions_percentage_change }}%
                            ↑</span>
                    @elseif ($rejected_contributions_percentage_change < 0)
                        <span
                            class="text-red-500 text-xl font-medium">{{ abs($rejected_contributions_percentage_change) }}%
                            ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Total users Card-->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full col-span-1 sm:col-span-2 lg:col-span-1">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $published_contributions->count() }}</h2>
                    <p class="text-xl text-gray-400">Published Contribtuions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($published_contributions_percentage_change > 0)
                        <span
                            class="text-emerald-500 text-xl font-medium">{{ $published_contributions_percentage_change }}%
                            ↑</span>
                    @elseif ($published_contributions_percentage_change < 0)
                        <span
                            class="text-red-500 text-xl font-medium">{{ abs($published_contributions_percentage_change) }}%
                            ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
