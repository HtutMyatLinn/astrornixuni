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
            @include('marketingcoordinator.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            @include('marketingcoordinator.header')
            <!-- here to add content -->
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <div class="space-y-4 mb-4">
                    <h1 class=" text-xl sm:text-4xl font-bold text-gray-900">Contribution Details & Approval</h1>

                    <div class="p-8 bg-white rounded-lg shadow-sm my-8">
                        <h1 class="text-4xl font-bold mb-2">Contribution Detail</h1>
                        <div class="border-b-4 border-blue-600 w-32 mb-8"></div>

                        <div class="space-y-6">
                            <!-- Details Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-[auto_1fr] gap-x-10 gap-y-4">
                                <!-- Title -->
                                <div class="font-semibold text-xl">Title</div>
                                <div class="text-xl">{{ $contribution->contribution_title }}</div>

                                <!-- Submitted By -->
                                <div class="font-semibold text-xl">Submitted By</div>
                                <div class="text-xl">{{ $contribution->user->first_name }}
                                    {{ $contribution->user->last_name }}</div>

                                <!-- Submission Date -->
                                <div class="font-semibold text-xl">Submission Date</div>
                                <div class="text-xl">{{ $contribution->submitted_date->format('M d, Y') }}</div>

                                <!-- Contribution Cover -->
                                <div class="font-semibold text-xl">Contribution Cover</div>
                                <div class="text-xl select-none">
                                    @if ($contribution->contribution_cover)
                                        <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                            alt="Cover Image" class="h-48 object-cover rounded-lg">
                                    @else
                                        <!-- Display the default logo image if contribution_cover is null -->
                                        <div class="flex h-full w-full">
                                            <div class="w-24 select-none">
                                                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Additional Images -->
                                <div class="font-semibold text-xl">Additional Images</div>
                                <div class="text-xl">
                                    @if ($contribution->images->isNotEmpty())
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
                                    @else
                                        <span class="text-gray-500">No additional images</span>
                                    @endif
                                </div>

                                <!-- Contribution File -->
                                <div class="font-semibold text-xl">Contribution File</div>
                                <div class="text-xl">
                                    @if (
                                        $contribution->contribution_file_path &&
                                            file_exists(public_path('storage/contribution-documents/' . $contribution->contribution_file_path)))
                                        <a href="{{ asset('storage/contribution-documents/' . $contribution->contribution_file_path) }}"
                                            class="text-blue-600 hover:underline">Download File</a>
                                    @else
                                        <span class="text-gray-500">No file available</span>
                                    @endif
                                </div>

                                <!-- Contribution Category -->
                                <div class="font-semibold text-xl">Contribution Category</div>
                                <div class="text-xl">{{ $contribution->category->contribution_category }}</div>

                                <!-- Status -->
                                <div class="font-semibold text-xl">Status</div>
                                <div class="text-xl flex items-center">
                                    @if ($contribution->contribution_status == 'Upload')
                                        <span class="w-4 h-4 bg-yellow-400 rounded-full mr-3"></span>
                                    @elseif($contribution->contribution_status == 'Reject')
                                        <span class="w-4 h-4 bg-red-400 rounded-full mr-3"></span>
                                    @elseif($contribution->contribution_status == 'Update')
                                        <span class="w-4 h-4 bg-blue-400 rounded-full mr-3"></span>
                                    @elseif($contribution->contribution_status == 'Select')
                                        <span class="w-4 h-4 bg-green-400 rounded-full mr-3"></span>
                                    @elseif($contribution->contribution_status == 'Publish')
                                        <span class="w-4 h-4 bg-purple-400 rounded-full mr-3"></span>
                                    @endif
                                    {{ $contribution->contribution_status == 'Upload'
                                        ? 'Uploaded'
                                        : ($contribution->contribution_status == 'Select'
                                            ? 'Selected'
                                            : ($contribution->contribution_status == 'Update'
                                                ? 'Updated'
                                                : ($contribution->contribution_status == 'Reject'
                                                    ? 'Rejected'
                                                    : ($contribution->contribution_status == 'Publish'
                                                        ? 'Published'
                                                        : $contribution->contribution_status)))) }}
                                </div>
                            </div>

                            <!-- Modal for displaying all images with Swiper.js -->
                            <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 p-4"
                                onclick="closeImageModal()">
                                <div class="w-full h-full flex items-center justify-center"
                                    onclick="event.stopPropagation()">
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
                                                        alt="Additional Image"
                                                        class="max-w-full max-h-full object-contain">
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

                            <!-- Approval Options -->
                            <div class="mt-12">
                                <h2 class="text-3xl font-bold mb-8">Approval Options</h2>
                                <form
                                    action="{{ route('marketingcoordinator.submission-management.update-status', $contribution->contribution_id) }}"
                                    method="POST" class="flex flex-wrap gap-4 select-none">
                                    @csrf
                                    <button type="submit" name="status" value="Select"
                                        class="bg-green-400 hover:bg-green-500 text-black px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Select
                                    </button>
                                    <button type="submit" name="status" value="Reject"
                                        class="bg-red-400 hover:bg-red-500 text-black px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Reject
                                    </button>
                                    <button type="submit" name="status" value="Upload"
                                        class="bg-blue-300 hover:bg-blue-400 text-black px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Give Feedback
                                    </button>
                                    <a href="{{ route('marketingcoordinator.submission-management') }}"
                                        class="bg-black text-white px-8 py-3 rounded-md text-lg font-semibold transition-colors">
                                        Back
                                    </a>
                                </form>
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
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>

</html>
