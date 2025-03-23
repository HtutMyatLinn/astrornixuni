<x-app-layout>
    <div class="overflow-x-hidden w-full max-w-full">

        <!-- About Us Section -->
        <div
            class="container mx-auto px-3 sm:px-8 py-4 md:py-12 flex flex-col md:flex-row items-center md:items-start gap-3 md:gap-12">
            <!-- Image Section -->
            <div class="w-full md:w-1/2 sm:max-w-[90%] md:max-w-md flex justify-center select-none">
                <img src="{{ asset('images/img1.png') }}" alt="Graduation Celebration"
                    class="w-full h-full rounded-lg object-cover">
            </div>

            <!-- Text Section -->
            <div class="w-full font-poppins text-center md:text-left">
                <!-- About Us Section -->
                <h3
                    class="text-sm md:text-2xl font-semibold text-black mb-3 md:mb-6 flex items-center justify-center md:justify-start">
                    <span class="mr-1 md:mr-2">ABOUT US</span>
                    <span class="border-t border-black w-8 md:w-16"></span>
                </h3>
                <p class="text-xs md:text-lg text-black mb-3 md:mb-4 leading-tight md:leading-normal">
                    Founded in 2001, our organization started with a team of 10 dedicated individuals driven by a passion for innovation and excellence. From our early days, we focused on delivering quality solutions that meet the needs of our clients and community.
                    As we grew, our team expanded to 120 allowing us to take on larger projects and refine our processes. Each step of our journey has been shaped by hard work, collaboration, and a commitment to continuous improvement.
                    Today, we are proud of our progress and the strong relationships we’ve built along the way. Our journey reflects the dedication of our team and the trust of those we serve — and we look forward to achieving even greater milestones in the future.
                </p>

                <!-- Mission Section -->
                <h3 class="text-lg md:text-2xl font-semibold text-black mt-6 md:mt-8">Our Mission</h3>
                <p class="text-xs md:text-lg text-black mb-3 md:mb-4 leading-tight md:leading-normal">
                    Our goal is to empower students, educators, and researchers by providing a space where innovative
                    ideas, groundbreaking research, and intellectual discussions thrive. We believe in fostering a
                    culture of learning and knowledge-sharing to make a lasting impact.
                </p>

                <!-- Vision Section -->
                <h3 class="text-lg md:text-2xl font-semibold text-black mt-6 md:mt-8">Our Vision</h3>
                <p class="text-xs md:text-lg text-black leading-tight md:leading-normal">
                    To be the leading university publication that highlights academic achievements, promotes
                    interdisciplinary collaboration, and encourages critical thinking among students and scholars
                    worldwide.
                </p>
            </div>

        </div>

        <hr class="border-t border-black my-3 md:my-8 w-[85%] mx-auto border-opacity-20">

        <!-- Features Section -->
        <!-- Our Services Section -->
        <div class="text-center font-poppins py-4 md:py-12 w-full max-w-screen-lg mx-auto">
            <h2 class="text-sm md:text-3xl font-semibold text-black mb-3 md:mb-12">Our Services</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6 text-center font-poppins px-3">
                <div class="px-2">
                    <img src="{{ asset('images/fluent.png') }}" alt="Academic Excellence"
                        class="mx-auto mb-2 md:mb-4 w-7 md:w-12 select-none">
                    <h3 class="text-sm md:text-xl font-semibold text-black">Academic Excellence</h3>
                    <p class="text-gray-600 text-xs md:text-base">Showcasing top research and academic works</p>
                </div>
                <div class="px-2">
                    <img src="{{ asset('images/newspaper.png') }}" alt="Latest News"
                        class="mx-auto mb-2 md:mb-4 w-7 md:w-12 select-none">
                    <h3 class="text-sm md:text-xl font-semibold text-black">Latest News</h3>
                    <p class="text-gray-600 text-xs md:text-base">Bringing you the latest updates from the university</p>
                </div>
                <div class="px-2">
                    <img src="{{ asset('images/graduation.png') }}" alt="Student Engagement"
                        class="mx-auto mb-2 md:mb-4 w-7 md:w-12 select-none">
                    <h3 class="text-sm md:text-xl font-semibold text-black">Student Engagement</h3>
                    <p class="text-gray-600 text-xs md:text-base">Empowering student voices and contributions</p>
                </div>
            </div>
        </div>


        <!-- Our Staff Section -->
        <div class="text-center font-poppins py-4 md:py-12 w-full max-w-screen-lg mx-auto">
            <h2 class="text-sm md:text-3xl font-semibold text-black mb-3 md:mb-12">Our Staff</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-8 px-3">
                <div class="text-center">
                    <img src="{{ asset('images/i1.png') }}" alt="Jason Wan"
                        class="mx-auto rounded-full w-32 h-32 sm:w-44 sm:h-44 select-none">
                    <h3 class="text-sm md:text-xl font-semibold text-black mt-2 md:mt-4">Thomas (Founder)</h3><br>
                    <p class="text-gray-600 text-xs md:text-base">Oversees all editorial decisions, ensuring the magazine maintains its high standards and editorial voice.</p>
                </div>
                <div class="text-center">
                    <img src="{{ asset('images/i2.png') }}" alt="Jason Wan"
                        class="mx-auto rounded-full w-32 h-32 sm:w-44 sm:h-44 select-none">
                    <h3 class="text-sm md:text-xl font-semibold text-black mt-2 md:mt-4">David (Manager)</h3><br>
                    <p class="text-gray-600 text-xs md:text-base">Leads the content team, plans publication schedules, and ensures timely delivery of articles and features.</p>
                </div>
                <div class="text-center">
                    <img src="{{ asset('images/i3.png') }}" alt="Jason Wan"
                        class="mx-auto rounded-full w-32 h-32 sm:w-44 sm:h-44 select-none">
                    <h3 class="text-sm md:text-xl font-semibold text-black mt-2 md:mt-4">Richeal (Staff)</h3><br>
                    <p class="text-gray-600 text-xs md:text-base">Designs the visual identity of the magazine, from layouts to photography, ensuring a modern and engaging look.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
