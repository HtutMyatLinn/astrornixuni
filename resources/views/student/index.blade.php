<x-app-layout>
    <div class="flex flex-col sm:flex-row justify-center items-center gap-6 px-6 bg-gray-100 rounded-lg shadow-md">
        <!-- Title Section -->
        <div class="text-left text-xl font-semibold bg-[#283B63] text-white p-4 pr-6">
            <p>17th</p>
            <p>Best</p>
            <p>Articles</p>
        </div>

        <!-- Image Swiper Section -->
        <div class="w-[400px] md:w-[600px] lg:w-[700px] h-[350px] md:h-[450px] lg:h-[500px] select-none">
            <div class="swiper mySwiper w-full h-full">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{ asset('images/history.jpeg') }}" alt="Book Cover 1"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/magazine2.jpg') }}" alt="Book Cover 3"
                            class="w-full h-full object-cover object-bottom">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ asset('images/collection-newspapers.webp') }}" alt="Book Cover 2"
                            class="w-full h-full object-cover">
                    </div>
                </div>
                <!-- Pagination & Navigation -->
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <!-- View Button -->
        <div class="flex items-center px-6 py-3">
            <a href="{{ route('contributions') }}"
                class="font-semibold underline underline-offset-4 transition duration-300">
                View
            </a>
            <i class="ri-arrow-right-long-line"></i>
        </div>
    </div>

    <!-- Include SwiperJS JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

    <div class="px-3 sm:px-6 bg-white min-w-[350px]">
        {{-- Hero --}}
        <div class="max-w-5xl mx-auto grid grid-cols-1 sm:grid-cols-2 py-10 px-3">
            <div class="text-5xl font-light pb-5 sm:pb-0">
                <p>Empowering</p>
                <p>Minds, Inspiring Futures</p>
            </div>
            <div class="text-2xl leading-relaxed text-gray-800">
                <p>Our university fosters a dynamic learning environment where creativity, critical thinking, and
                    collaboration thrive. Whether through <span class="italic">academics</span>, extracurricular
                    activities, or global partnerships, we strive to shape future leaders who will make a positive
                    impact on society.</p>
            </div>
        </div>

        {{-- Top Contributions --}}
        <div class="flex justify-center border-b-2">
            <div class="max-w-5xl w-full mx-auto">
                <h2
                    class="text-3xl font-semibold text-center underline underline-offset-8 decoration-1 decoration-gray-500">
                    Top
                    Contributions
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 py-24">
                    <!-- Large Image -->
                    @if ($trendingContributions->count() > 0)
                        <a href="{{ route('student.contribution-detail', $trendingContributions[0]->contribution_id) }}"
                            class="relative col-span-1">
                            <img src="{{ asset('storage/contribution-images/' . $trendingContributions[0]->contribution_cover) }}"
                                class="w-full h-full object-cover select-none"
                                alt="{{ $trendingContributions[0]->contribution_title }}">
                            <div
                                class="absolute bottom-0 left-0 text-white p-4 bg-gradient-to-t from-gray-500 via-transparent to-transparent w-full">
                                <span
                                    class="bg-[#5A7BAF] text-white px-2 py-1 text-sm">{{ $trendingContributions[0]->category->contribution_category }}</span>
                                <p class="text-sm mt-2">
                                    {{ Str::limit($trendingContributions[0]->contribution_description, 100) }}
                                </p>
                            </div>
                        </a>
                    @endif

                    <!-- Right Grid -->
                    <div class="grid grid-cols-2">
                        <!-- Medium Image -->
                        @if ($trendingContributions->count() > 1)
                            <a href="{{ route('student.contribution-detail', $trendingContributions[1]->contribution_id) }}"
                                class="relative col-span-2 md:col-span-2">
                                <img src="{{ asset('storage/contribution-images/' . $trendingContributions[1]->contribution_cover) }}"
                                    class="w-full h-full object-cover select-none"
                                    alt="{{ $trendingContributions[1]->contribution_title }}">
                                <div
                                    class="absolute bottom-0 left-0 text-white p-4 bg-gradient-to-t from-gray-500 via-transparent to-transparent w-full">
                                    <span class="bg-[#5A7BAF] text-white px-2 py-1 text-sm">
                                        {{ $trendingContributions[1]->category->contribution_category }}
                                    </span>
                                    <p class="text-sm mt-2">
                                        {{ Str::limit($trendingContributions[1]->contribution_description, 100) }}
                                    </p>
                                </div>
                            </a>
                        @endif

                        <!-- Two Smaller Images -->
                        @foreach ($trendingContributions->skip(2)->take(2) as $contribution)
                            <a href="{{ route('student.contribution-detail', $contribution) }}"
                                class="relative col-span-1">
                                <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                    class="w-full h-full object-cover select-none"
                                    alt="{{ $contribution->contribution_title }}">
                                <div
                                    class="absolute bottom-0 left-0 text-white p-4 bg-gradient-to-t from-gray-500 via-transparent to-transparent w-full">
                                    <span
                                        class="bg-[#5A7BAF] text-white px-2 py-1 text-sm">{{ $contribution->category->contribution_category }}</span>
                                    <p class="text-sm mt-2">
                                        {{ Str::limit($contribution->contribution_description, 50) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Magazine --}}
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 pt-8 py-14 flex flex-col gap-3">
            <div class="uppercase mb-5 sm:mb-16">
                <h1 class="text-2xl font-bold">The Magazine</h1>
                <p class="text-gary-600">Contribution</p>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-1 sm:gap-5">
                @if ($contributions->count() > 0)
                    @foreach ($contributions as $contribution)
                        <a href="{{ route('student.contribution-detail', $contribution) }}"
                            class="overflow-hidden flex flex-col items-center">
                            <div class="relative h-64 w-full overflow-hidden select-none">
                                <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                    alt="{{ $contribution->contribution_title }}"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                            <p class="text-sm text-gray-600 mt-3">{{ $contribution->contribution_title }}</p>
                        </a>
                    @endforeach
                @else
                    <p>No contributions found.</p>
                @endif
            </div>
            <a href="{{ route('contributions') }}" class="text-blue-600 underline underline-offset-2 mt-1">Read all
                Contributions</a>
        </div>
    </div>
</x-app-layout>
