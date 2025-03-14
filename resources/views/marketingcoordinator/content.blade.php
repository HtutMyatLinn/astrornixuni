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
                Last Login at :
            </p>
            <p class="text-sm sm:text-base text-gray-500">{{ Auth::user()->last_login_date }}</p>
            <p class="text-sm sm:text-base text-gray-500">25-February-2025</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <!-- Total Students Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class=" w-5 h-5" src="{{ asset('images/totalstudents.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">300</h2>
                    <p class="text-xl text-gray-400">Total Students</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>
        <!-- Total submissions Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class=" w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">967</h2>
                    <p class="text-xl text-gray-400">Total Submissions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>
        <!-- Total Pending Contributions Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class=" w-5 h-5" src="{{ asset('images/totalpendingcontributions.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">52</h2>
                    <p class="text-xl text-gray-400">Total Pending Contributions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>
        <!-- Total faculty Card -->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class=" w-5 h-5" src="{{ asset('images/totalfaculty.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">300</h2>
                    <p class="text-xl text-gray-400">Total Faculties</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>
        <!-- Total approved contributions Card-->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class=" w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">300</h2>
                    <p class="text-xl text-gray-400">Total Approved Contributions</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
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
                    <h2 class="text-3xl font-bold">300</h2>
                    <p class="text-xl text-gray-400">Total Students</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>

        <!-- Total users Card-->
        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class=" w-5 h-5" src="{{ asset('images/totaluser.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">300</h2>
                    <p class="text-xl text-gray-400">Total Users</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>

        <!-- total inquiries received -->

        <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] p-6 w-full">
            <!-- Avatar Circle -->
            <div class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                <img class=" w-5 h-5" src="{{ asset('images/totalinquiry.png') }}" alt="">
            </div>

            <!-- Stats Container with Flexbox -->
            <div class="flex items-end justify-between">
                <!-- Numbers -->
                <div class="space-y-1">
                    <h2 class="text-3xl font-bold">300</h2>
                    <p class="text-xl text-gray-400">Total Inquiries Received</p>
                </div>

                <!-- Percentage -->
                <div class="flex items-center gap-1">
                    <span class="text-emerald-500 text-xl font-medium">2.3% ↑</span>
                </div>
            </div>
        </div>
    </div>
</main>
