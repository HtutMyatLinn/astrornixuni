<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    <!-- SwiperJS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <!-- SwiperJS JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
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
                        {{ $contribution->user->last_name }}
                    </p>

                    <!-- Inside the Content section -->
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Left Column: Cover Image and Additional Images -->
                        <div class="w-full md:w-1/2">
                            <!-- Cover Image -->
                            @if ($contribution->contribution_cover)
                                <!-- Display the contribution cover image if it exists -->
                                <div class="w-full h-auto md:max-h-96 select-none">
                                    <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                        alt="{{ $contribution->contribution_title }}"
                                        class="w-full h-full object-cover rounded-md">
                                </div>
                            @else
                                <!-- Display the default logo image if contribution_cover is null -->
                                <div class="w-full h-56 md:max-h-96 flex items-center justify-center">
                                    <!-- Match the same dimensions as the cover image container -->
                                    <div class="w-24 select-none">
                                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>
                            @endif

                            <!-- Additional Images -->
                            @if ($contribution->images->isNotEmpty())
                                <div class="mt-6">
                                    <h3 class="text-lg font-semibold mb-4">Additional Images</h3>
                                    <div class="grid grid-cols-3 gap-2">
                                        @foreach ($contribution->images->take(3) as $index => $image)
                                            <div class="h-48 overflow-hidden rounded-lg select-none relative cursor-pointer"
                                                onclick="openImageModal({{ $index }})">
                                                <img src="{{ asset('storage/contribution-images/' . $image->contribution_image_path) }}"
                                                    alt="Additional Image" class="w-full h-full object-cover">
                                                <!-- Show "+X" overlay for the third image if there are more than 3 images -->
                                                @if ($index === 2 && $contribution->images->count() > 3)
                                                    <div
                                                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                                        <span class="text-white text-2xl font-bold">
                                                            +{{ $contribution->images->count() - 3 }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Right Column: Text Content -->
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

                    <!-- Modal for displaying all images with Swiper.js -->
                    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 p-4"
                        onclick="closeImageModal()">
                        <div class="w-full h-full flex items-center justify-center" onclick="event.stopPropagation()">
                            <!-- Close button -->
                            <button onclick="closeImageModal()"
                                class="absolute top-4 right-4 text-white text-2xl bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75 z-50">
                                &times;
                            </button>

                            <!-- Swiper container -->
                            <div class="swiper-container w-full h-full">
                                <div class="swiper-wrapper">
                                    @foreach ($contribution->images as $image)
                                        <div class="swiper-slide flex items-center justify-center select-none">
                                            <img src="{{ asset('storage/contribution-images/' . $image->contribution_image_path) }}"
                                                alt="Additional Image" class="max-w-full max-h-full object-contain">
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Add navigation buttons -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>

                    <script>
                        let swiperInstance = null;

                        // Function to open the image modal
                        function openImageModal(index = 0) {
                            const modal = document.getElementById('imageModal');
                            if (modal) {
                                modal.classList.remove('hidden');
                                if (!swiperInstance) {
                                    swiperInstance = new Swiper('.swiper-container', {
                                        loop: true,
                                        initialSlide: index, // Start from the clicked image
                                        navigation: {
                                            nextEl: '.swiper-button-next',
                                            prevEl: '.swiper-button-prev',
                                        },
                                    });
                                } else {
                                    swiperInstance.slideTo(index); // Update the slide if Swiper is already initialized
                                }
                            }
                        }

                        // Function to close the image modal
                        function closeImageModal() {
                            const modal = document.getElementById('imageModal');
                            if (modal) {
                                modal.classList.add('hidden');
                            }
                        }

                        // Close modal when clicking outside the content
                        document.addEventListener('DOMContentLoaded', function() {
                            const modal = document.getElementById('imageModal');
                            if (modal) {
                                modal.addEventListener('click', function(event) {
                                    if (event.target === modal) {
                                        closeImageModal();
                                    }
                                });
                            }
                        });
                    </script>
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
