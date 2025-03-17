<main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

    <div class="flex items-center justify-between mb-4">
        <div class="space-y-4 mb-4">
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
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-5">Browser Usage Statistics</h1>
            <p>This chart displays the percentage of users accessing the system from different browsers.</p>
            <div style="width: 80%;">
                <canvas id="browserChart"></canvas>
            </div>
        </div>

        <!-- Include Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            var ctx = document.getElementById('browserChart').getContext('2d');
            var browserChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Browser Usage',
                        data: @json($data),
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
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
                        }
                    }
                }
            });
        </script>
        <!-- Total Students Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full rounded-lg">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalstudents.png') }}" alt="">
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
        <!-- Total users Card-->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full rounded-lg">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totaluser.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $total_users->count() }}</h2>
                    <p class="text-xl text-gray-400">Total Users</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($percentage_change > 0)
                        <span class="text-emerald-500 text-xl font-medium">{{ $percentage_change }}% ↑</span>
                    @elseif ($percentage_change < 0)
                        <span class="text-red-500 text-xl font-medium">{{ abs($percentage_change) }}% ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>
        <!-- Total faculty Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full rounded-lg">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalfaculty.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $faculties->count() }}</h2>
                    <p class="text-xl text-gray-400">Total Faculties</p>
                </div>
            </div>
        </div>
        <!-- Total submissions Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full rounded-lg">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}" alt="">
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
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>
        <!-- Total Pending Contributions Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full rounded-lg">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalpendingcontributions.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $pending_contributions->count() }}</h2>
                    <p class="text-xl text-gray-400">Total Pending Contributions</p>
                </div>
            </div>
        </div>
        <!-- Total approved contributions Card-->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full rounded-lg">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $selected_contributions->count() }}</h2>
                    <p class="text-xl text-gray-400">Approved Contributions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>
        <!-- Total reject contributions Card-->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full rounded-lg">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/rejectcontri.png') }}" alt="">
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
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>
        <!-- Total approved contributions Card-->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full rounded-lg">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $published_contributions->count() }}</h2>
                    <p class="text-xl text-gray-400">Published Contributions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>

        <!-- total inquiries received -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full rounded-lg col-span-1 lg:col-span-2">
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalinquiry.png') }}" alt="">
            </div>
            <div class="flex items-end justify-between">
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $inquiries->count() }}</h2>
                    <p class="text-xl text-gray-400">Total Inquiries Received</p>
                </div>
                <div class="flex items-center gap-1">
                    @if ($inquiry_percentage_change > 0)
                        <span class="text-emerald-500 text-xl font-medium">{{ $inquiry_percentage_change }}% ↑</span>
                    @elseif ($inquiry_percentage_change < 0)
                        <span class="text-red-500 text-xl font-medium">{{ abs($inquiry_percentage_change) }}% ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
