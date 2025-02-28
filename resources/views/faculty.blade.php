<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-[#5A7BAF] text-white text-center py-16 px-4">
        <h1 class="text-2xl md:text-4xl max-w-md mx-auto font-semibold">Faculty of Computer Science</h1>
        <p class="text-sm md:text-lg mt-2 opacity-80">
            Discover the latest research and contributions from our faculty members.
        </p>
    </div>

    <!-- About the Faculty Section -->
    <div class="container mx-auto px-4 sm:px-6 md:px-12 py-12">
        <div class="flex flex-col md:flex-row items-center gap-6 md:gap-12">
            <!-- Text Content -->
            <div class="w-full md:w-1/2">
                <h2 class="text-lg md:text-2xl font-semibold text-black mb-3">About the Faculty</h2>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed">
                    The Faculty of Computer Science is committed to advancing knowledge in
                    artificial intelligence, cybersecurity, and software engineering. Our faculty
                    members are engaged in groundbreaking research and industry collaborations.
                </p>
            </div>

            <!-- Image -->
            <div class="w-full md:w-1/2">
                <img src="{{ asset('images/f1.png') }}" alt="Faculty Research"
                    class="w-full sm:w-3/4 h-auto object-cover mx-auto">
            </div>
        </div>
    </div>

    <!-- Recent Faculty Contributions Section -->
    <div class="container mx-auto px-4 sm:px-6 md:px-12 py-16 text-center bg-white">
        <h2 class="text-xl md:text-3xl font-semibold mb-2">Recent Faculty Contributions</h2>

        <!-- Additional Text -->
        <p class="text-sm md:text-base text-gray-600 mb-6">
            Explore research, publications, and projects from our faculty members shaping innovation and knowledge.
        </p>

        <!-- Search Bar -->
        <div class="max-w-lg mx-auto mb-10 relative">
            <input type="text" placeholder="Search Contributions..."
                class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-gray-300 text-sm md:text-base pl-10 transition duration-300 ease-in-out">
            <img src="{{ asset('images/group.png') }}" alt="Search Icon"
                class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 transition-all duration-300 ease-in-out">
        </div>
    </div>
    <div class="container mx-auto px-4 sm:px-6 md:px-12 text-center py-0 md:py-12">
        <!-- First Contribution on Top (Image Left and Text Right) -->
        <div class="flex flex-col md:flex-row items-center gap-8 my-12">
            <!-- Adjusted Image Width and margin-left to move the image 50px to the right -->
            <div class="w-full md:w-3/4 md:ml-[82px] mx-auto md:mx-0">
                <img src="{{ asset('images/cy1.png') }}" alt="Safe Trip" class="w-full h-auto object-cover">
            </div>
            <div class="text-left w-full md:w-1/2 mt-4">
                <a href="#" class="text-lg md:text-2xl font-semibold text-black hover:underline">Safe Trip</a>
                <p class="text-base md:text-3xl text-gray-700">Do your exercise properly</p>
                <p class="text-sm text-gray-500 mt-1">by <strong>Jonathan Shaw</strong></p>
            </div>
        </div>

        <!-- Separate Section for the Next Four Contributions -->
        <div class="py-12">
            <h2 class="text-xl md:text-2xl font-semibold mb-6 text-center">Other Contributions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                @foreach ([['img' => 'cy2.png', 'alt' => 'Ivy Athletes', 'title' => 'Why Ivy Athletes Score in Careers', 'desc' => 'How does undergraduate participation in varsity sports enhance career success?'], ['img' => 'news.png', 'alt' => 'Medical Research', 'title' => 'Enhancing Critical Care Through Medical Research', 'desc' => 'How does undergraduate participation in varsity sports enhance career success?'], ['img' => 'com.png', 'alt' => 'Tech Innovations', 'title' => 'Tech Innovations in AI', 'desc' => 'Exploring the latest advancements in artificial intelligence research.'], ['img' => 'cs.png', 'alt' => 'Cybersecurity', 'title' => 'Cybersecurity Trends', 'desc' => 'How modern cybersecurity techniques are shaping the digital world.']] as $card)
                    <div class="flex flex-col items-center">
                        <div class="w-full">
                            <img src="{{ asset('images/' . $card['img']) }}" alt="{{ $card['alt'] }}"
                                class="w-full h-auto object-cover">
                        </div>
                        <div class="text-start w-full mt-3">
                            <a href="#"
                                class="text-md md:text-lg font-semibold text-black hover:underline">{{ $card['title'] }}
                                →</a>
                            <p class="text-sm md:text-md text-gray-700 mt-1">{{ $card['desc'] }}</p>
                            <p class="text-sm text-gray-500 mt-1">by <strong>Jonathan Shaw</strong></p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Load More Button (Aligned to the left) -->
        <div class="text-left mb-8">
            <button
                class="bg-[#5A7BAF] text-white py-2 px-4 rounded-md shadow-md hover:bg-blue-600 transition duration-300 ease-in-out">
                Load more Contributions
            </button>
        </div>
    </div>

</x-app-layout>
