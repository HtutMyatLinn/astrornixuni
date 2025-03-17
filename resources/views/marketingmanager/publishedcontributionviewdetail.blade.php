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
        @include('marketingmanager.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            @include('marketingmanager.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <h1 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4">Published Contributions</h1>

                <!-- Full-width background section -->
                <section class="w-full bg-white shadow-lg rounded-md p-6 md:p-10">

                    <!-- Header with close button -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold">Contribution Details</h2>
                        <a href="{{ route('marketingmanager.published-contribution') }}"
                            class="text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>

                    </div>

                    <h2 class="text-3xl font-bold mb-4">{{ $contribution->contribution_title }}</h2>
                    <!-- Author -->
                    <p class="text-lg mb-2 text-gray-400">By : {{ $contribution->user->first_name }} {{ $contribution->user->last_name }}</p>



                    <!-- Inside the Content section -->
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Image -->
                        <div class="md:w-1/4">
                            <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}" alt="{{ $contribution->contribution_title }}" class="w-full rounded-md">
                        </div>

                        <!-- Text content -->
                        <div class="md:w-1/2">
                            <h2 class="text-2xl font-bold mb-4">Title : {{ $contribution->contribution_title }}</h2>
                            <p class="text-lg mb-4">
                                Description : {{ $contribution->contribution_description }}
                            </p>
                            <p class="text-lg mb-2"> Faculty : {{ $contribution->user->faculty->faculty }}</p>
                            <p class="text-lg">
                                Published: {{ $contribution->published_date }}
                            </p>
                        </div>
                    </div>
                </section>
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