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

<body class="bg-gray-50">
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
        @include('marketingcoordinator.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @include('marketingcoordinator.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <div class="max-w-7xl mx-auto space-y-4 mb-4">
                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">Provide Feedback</h1>
                    <div class="max-w-7xl mx-auto p-6 bg-white rounded-lg shadow-sm my-8">
                        <h1 class="text-xl font-bold mb-2">Feedback Form</h1>
                        <div class="border-b-4 border-blue-600 w-32 mb-8"></div>

                        <form class="space-y-8">
                            <!-- Form Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-y-8">
                                <div class="font-semibold text-xl">Title</div>
                                <div class="md:col-span-2 text-xl">Green In Tech</div>

                                <div class="font-semibold text-xl">Contributions Category</div>
                                <div class="md:col-span-2 text-xl">Journal</div>

                                <div class="font-semibold text-xl">Student Name</div>
                                <div class="md:col-span-2 text-xl">Khin Khin</div>

                                <div class="font-semibold text-xl">Enter Your Comment</div>
                                <div class="md:col-span-2"></div>
                            </div>

                            <!-- Comment Textarea -->
                            <div class="w-full">
                                <textarea
                                    class="w-full h-80 p-4 border border-gray-300 rounded-lg bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none"
                                    placeholder="Enter Your Comment..."></textarea>
                            </div>

                            <!-- Submit Button -->
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-green-400 hover:bg-green-500 text-black px-6 py-3 rounded-md text-lg font-semibold transition-colors">
                                    Submit Feedback
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </main>


        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>

</html>
