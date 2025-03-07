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
        @include('marketingmanager.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @include('marketingmanager.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">Published Contributions</h1>

                <div class=" max-w-full mx-auto shadow-lg p-6 bg-white mt-4 rounded-md">
                    <h1 class="text-2xl font-bold mb-8">List of Published Contribution (30)</h1>

                    <!-- Book Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                        <!-- Book 1 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-2 border-b flex justify-start">
                                <button class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <img src="{{ asset('images/math.png') }}" alt="Mathematics Class XII" class="w-full h-5/6 object-cover">
                                <div class="mt-4 text-center">


                                    <a href="{{ route('marketingmanager.publishedcontributionviewdetail')}}" class="text-blue-600 font-medium hover:underline">View</a>


                                </div>
                            </div>
                        </div>

                        <!-- Book 2 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-2 border-b flex justify-start">
                                <button class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <img src="{{ asset('images/math.png') }}" alt="International Relations" class="w-full h-5/6 object-cover">
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-blue-600 font-medium hover:underline">View</a>
                                </div>
                            </div>
                        </div>

                        <!-- Book 3 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-2 border-b flex justify-start">
                                <button class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <img src="{{ asset('images/math.png') }}" alt="Adult Medical Surgical Nursing" class="w-full h-5/6 object-cover">
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-blue-600 font-medium hover:underline">View</a>
                                </div>
                            </div>
                        </div>

                        <!-- Book 4 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-2 border-b flex justify-start">
                                <button class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <img src="{{ asset('images/math.png') }}" alt="Mathematics Class XII" class="w-full h-5/6 object-cover">
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-blue-600 font-medium hover:underline">View</a>
                                </div>
                            </div>
                        </div>

                        <!-- Book 5 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-2 border-b flex justify-start">
                                <button class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <img src="{{ asset('images/math.png') }}" alt="Mathematics Class XII" class="w-full h-5/6 object-cover">
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-blue-600 font-medium hover:underline">View</a>
                                </div>
                            </div>
                        </div>

                        <!-- Book 6 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-2 border-b flex justify-start">
                                <button class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <img src="{{ asset('images/math.png') }}" alt="International Relations" class="w-full h-5/6 object-cover">
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-blue-600 font-medium hover:underline">View</a>
                                </div>
                            </div>
                        </div>

                        <!-- Book 7 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-2 border-b flex justify-start">
                                <button class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <img src="{{ asset('images/math.png') }}" alt="Adult Medical Surgical Nursing" class="w-full h-5/6 object-cover">
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-blue-600 font-medium hover:underline">View</a>
                                </div>
                            </div>
                        </div>

                        <!-- Book 8 -->
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <div class="p-2 border-b flex justify-start">
                                <button class="text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-4">
                                <img src="{{ asset('images/math.png') }}" alt="Mathematics Class XII" class="w-full h-5/6 object-cover">
                                <div class="mt-4 text-center">
                                    <a href="#" class="text-blue-600 font-medium hover:underline">View</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Pagination and Download -->
                    <div class="mt-10 flex flex-col md:flex-row justify-between items-center">
                        <div class="text-sm text-gray-500 mb-4 md:mb-0">
                            Showing 1 to 1 of 5 results
                        </div>

                        <div class="flex items-center">
                            <div class="flex border border-gray-300 rounded-md overflow-hidden mr-4">
                                <button class="px-3 py-1 border-r border-gray-300 text-gray-500 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                </button>
                                <button class="px-3 py-1 border-r border-gray-300 bg-blue-600 text-white">1</button>
                                <button class="px-3 py-1 border-r border-gray-300 hover:bg-gray-100">2</button>
                                <button class="px-3 py-1 border-r border-gray-300 hover:bg-gray-100">3</button>
                                <button class="px-3 py-1 border-r border-gray-300 hover:bg-gray-100">4</button>
                                <button class="px-3 py-1 border-r border-gray-300 hover:bg-gray-100">5</button>
                                <button class="px-3 py-1 hover:bg-gray-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </div>

                            <button class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Download as ZIP
                            </button>
                        </div>
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
