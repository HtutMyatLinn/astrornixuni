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

                <div class="max-w-7xl mx-auto space-y-4 mb-4">
                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">Contribution Details & Approval</h1>



                    <div class="max-w-7xl mx-auto p-8 bg-white rounded-lg shadow-sm my-8">
                        <h1 class="text-2xl font-bold mb-2">Contribution Detail</h1>
                        <div class="border-b-4 border-blue-600 w-32 mb-8"></div>

                        <div class="space-y-6">
                            <!-- Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6">
                                <div class="font-semibold text-xl">Title</div>
                                <div class="md:col-span-2 text-xl">Green Tech Future</div>

                                <div class="font-semibold text-xl">Submitted By</div>
                                <div class="md:col-span-2 text-xl">Khin Khin</div>

                                <div class="font-semibold text-xl">Submission Date</div>
                                <div class="md:col-span-2 text-xl">Feb 26, 2025</div>

                                <div class="font-semibold text-xl">Contribution Cover</div>
                                <div class="md:col-span-2 text-xl">[Preview Image]</div>

                                <div class="font-semibold text-xl">Contribution File</div>
                                <div class="md:col-span-2 text-xl">[ Download File ]</div>

                                <div class="font-semibold text-xl">Contribution Category</div>
                                <div class="md:col-span-2 text-xl">Journal</div>

                                <div class="font-semibold text-xl">Status</div>
                                <div class="md:col-span-2 text-xl flex items-center">
                                    <span class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></span>
                                    Pending
                                </div>
                            </div>

                            <!-- Approval Options -->
                            <div class="mt-12">
                                <h2 class="text-3xl font-bold mb-8">Approval Options</h2>
                                <div class="flex flex-wrap gap-4">
                                    <button
                                        class="bg-green-400 hover:bg-green-500 text-black px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Approve
                                    </button>
                                    <button
                                        class="bg-red-400 hover:bg-red-500 text-black px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Reject
                                    </button>
                                    <button
                                        class="bg-blue-300 hover:bg-blue-400 text-black px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Give Comment
                                    </button>
                                    <a href="{{ url()->previous() }}"
                                        class=" bg-black text-white px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Back
                                    </a>
                                </div>
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
