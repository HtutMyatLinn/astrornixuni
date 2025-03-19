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
            @include('marketingmanager.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
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
                    <p class="text-lg mb-2 text-gray-400">By : {{ $contribution->user->first_name }}
                        {{ $contribution->user->last_name }}</p>

                    <!-- Inside the Content section -->
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Image -->
                        @if ($contribution->contribution_cover)
                            <!-- Display the contribution cover image if it exists -->
                            <div class="w-full md:max-w-96 h-auto md:max-h-96 select-none">
                                <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                    alt="{{ $contribution->contribution_title }}"
                                    class="w-full h-full object-cover rounded-md">
                            </div>
                        @else
                            <!-- Display the default logo image if contribution_cover is null -->
                            <div class="w-full md:max-w-96 h-56 md:max-h-96 flex items-center justify-center">
                                <!-- Match the same dimensions as the cover image container -->
                                <div class="w-24 select-none">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                        class="w-full h-full object-cover">
                                </div>
                            </div>
                        @endif

                        <!-- Text content -->
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold mb-4">Title : {{ $contribution->contribution_title }}</h2>
                            <div x-data="{ expanded: false }">
                                <p class="mt-2 text-gray-700 text-lg text-start">
                                    <span x-show="!expanded">
                                        {!! nl2br(e(Str::limit($contribution->contribution_description, 350))) !!}
                                    </span>
                                    <span x-show="expanded">
                                        {!! nl2br(e($contribution->contribution_description)) !!}
                                    </span>
                                </p>

                                @if (strlen($contribution->contribution_description) > 350)
                                    <button @click="expanded = !expanded"
                                        class="text-blue-500 hover:underline mt-2 flex justify-start">
                                        <span x-show="!expanded">Read more</span>
                                        <span x-show="expanded">Show less</span>
                                    </button>
                                @endif
                            </div>
                            <p class="text-lg mb-2"> Faculty : {{ $contribution->user->faculty->faculty }}</p>
                            <p class="text-lg">
                                Published: {{ $contribution->published_date->format('M d, Y') }}
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
