<main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">
    <div class="flex justify-between items-center mb-4 rounded-lg shadow-sm">
        <!-- Left side -->
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-900">
                Welcome Back, {{ Auth::user()->username }}
            </h1>
            <h2 class="text-sm sm:text-lg text-gray-500">
                Here’s what is happening in your university today
            </h2>
        </div>

        <!-- Right side -->
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
        <!-- Total Contributions Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalinquiry.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $totalPublishedContributions->count() }}</h2>
                    <p class="text-xl text-gray-400">Total Published Contributions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($published_percentage_change > 0)
                        <span class="text-emerald-500 text-xl font-medium">{{ $published_percentage_change }}%
                            ↑</span>
                    @elseif ($published_percentage_change < 0)
                        <span class="text-red-500 text-xl font-medium">{{ abs($published_percentage_change) }}%
                            ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Total Faculties Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/trend.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $activeFacultyParticipation }} of {{ $totalFaculty }}</h2>
                    <p class="text-xl text-gray-400">Active Faculty Participation</p>
                </div>


            </div>
        </div>

        <!-- Submission Trends This Year Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/approved.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $submissionTrendsThisYear }}</h2>
                    <p class="text-xl text-gray-400">Submission Trends This Year</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($popular_percentage_change > 0)
                        <span class="text-emerald-500 text-xl font-medium">{{ $popular_percentage_change }}%
                            ↑</span>
                    @elseif ($popular_percentage_change < 0)
                        <span class="text-red-500 text-xl font-medium">{{ abs($popular_percentage_change) }}%
                            ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Total Contributions Submitted Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/totalinquiry.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $totalContributionsSubmitted }}</h2>
                    <p class="text-xl text-gray-400">Total Contributions Submitted</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($contribution_percentage_change > 0)
                        <span class="text-emerald-500 text-xl font-medium">{{ $contribution_percentage_change }}%
                            ↑</span>
                    @elseif ($contribution_percentage_change < 0)
                        <span class="text-red-500 text-xl font-medium">{{ abs($contribution_percentage_change) }}%
                            ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Total students Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/total_users.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $totalStudents->count() }}</h2>
                    <p class="text-xl text-gray-400">Total Students</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    @if ($student_percentage_change > 0)
                        <span class="text-emerald-500 text-xl font-medium">{{ $student_percentage_change }}%
                            ↑</span>
                    @elseif ($student_percentage_change < 0)
                        <span class="text-red-500 text-xl font-medium">{{ abs($student_percentage_change) }}%
                            ↓</span>
                    @else
                        <span class="text-gray-500 text-xl font-medium">0%</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Total marketing coordinator Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/total_users.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $totalMarketingCoordinators }}</h2>
                    <p class="text-xl text-gray-400">Total Marketing Coordinators</p>
                </div>
            </div>
        </div>

        <!-- Total faculty Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class="w-5 h-5" src="{{ asset('images/total_users.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">{{ $totalFaculty }}</h2>
                    <p class="text-xl text-gray-400">Total Faculty</p>
                </div>
            </div>
        </div>


    </div>
</main>
