<x-app-layout>
    <!-- Font Awesome CDN for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Hero Section (Top Cover Page) -->
    <div class="relative w-full h-[300px] md:h-[500px]">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ asset('images/cov3.jpeg') }}');">
            <div class="absolute inset-0 bg-black bg-opacity-20"></div> <!-- Overlay -->
        </div>

        <div class="relative z-10 flex flex-col justify-center h-full px-4 md:px-16 text-white text-center md:text-left">
            <h2 class="text-2xl md:text-4xl font-semibold mb-2 md:mb-4">Contact Us</h2>
            <p class="text-sm md:text-xl max-w-xs md:max-w-lg mx-auto md:mx-0">
                We'd love to hear from you. Reach out with any questions, feedback, or inquiries.
            </p>
        </div>

        <!-- Bottom Right Circular Image -->
        <div
            class="absolute bottom-[-60px] sm:bottom-[-70px] right-1/2 md:right-6 transform md:translate-x-0 translate-x-1/2 select-none">
            <img src="{{ asset('images/Ellipse2.png') }}" alt="Profile"
                class="w-32 h-32 sm:w-40 sm:h-40 rounded-full shadow-lg object-cover">
        </div>
    </div>

    <!-- Contact Section (Responsive Layout) -->
    <div class="w-full px-4 md:px-12 mt-10 py-8 md:py-12">
        <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
            <!-- Left Column: Contact Form -->
            <div class="bg-white p-4 md:p-8 rounded-lg shadow-md w-full">
                <h3 class="text-xl md:text-2xl font-semibold mb-3 md:mb-4">Submit an Inquiry</h3>
                <!-- Info Message Inside the Box -->
                <p class="text-gray-700 text-xs md:text-sm mb-3 md:mb-4">
                    Have a question or need assistance? Fill out the form below, and our support team will get back to
                    you within 24-48 hours.
                </p>

                @if (session('success'))
                    <div id="success-message"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>

                    <script>
                        setTimeout(() => {
                            document.getElementById('success-message').style.display = 'none';
                        }, 5000);
                    </script>
                @endif

                <form action="{{ route('inquiry.store') }}" method="POST" class="space-y-3 md:space-y-4">
                    @csrf

                    <!-- Hidden input for user_id -->
                    <input type="hidden" name="user_id" value="{{ auth()->id() }}">

                    @if (Auth::check())
                        <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}">
                    @else
                        <p class="text-red-500 text-sm">You must be logged in to message.</p>
                    @endif

                    <!-- Priority Level -->
                    <div class="relative">
                        <label class="block text-sm font-semibold">Priority Level</label>
                        <select name="priority_level"
                            class="w-full px-3 py-2 mt-1 border rounded-md focus:ring focus:ring-gray-300 text-sm md:text-base">
                            <option value="" {{ old('priority_level') == '' ? 'selected' : '' }}>Select priority
                                level</option>
                            <option value="low" {{ old('priority_level') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('priority_level') == 'medium' ? 'selected' : '' }}>Medium
                            </option>
                            <option value="high" {{ old('priority_level') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('priority_level')
                            <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Message -->
                    <div class="relative">
                        <label class="block text-sm font-semibold">Your Message</label>
                        <textarea name="inquiry" placeholder="Write your message here..."
                            class="w-full px-3 py-2 mt-1 border rounded-md focus:ring focus:ring-gray-300 h-24 md:h-32 text-sm md:text-base">{{ old('inquiry') }}</textarea>
                        @error('inquiry')
                            <p class="absolute left-2 -bottom-1 bg-white text-red-500 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Help Tip Inside Contact Form -->
                    <p class="text-gray-600 text-xs md:text-sm">
                        📌 **Tip:** Please provide as much detail as possible to help us resolve your inquiry
                        efficiently.
                    </p>

                    <!-- Submit Button -->
                    @if (Auth::check())
                        <button type="submit"
                            class="w-full bg-[#5A7BAF] text-white py-2 md:py-2.5 rounded-md hover:bg-[#4a6a9a] transition text-sm md:text-base select-none">
                            Submit your inquiry
                        </button>
                    @else
                        <button type="button" disabled
                            class="w-full bg-[#5A7BAF] text-white py-2 md:py-2.5 rounded-md text-sm md:text-base cursor-not-allowed opacity-50 select-none">
                            Submit your inquiry
                        </button>
                    @endif

                </form>
            </div>

            <!-- Right Column: Contact Info & Map -->
            <div class="flex flex-col space-y-4 md:space-y-6 w-full">

                <!-- Contact Information Card -->
                <div class="bg-white p-4 md:p-8 rounded-lg shadow-md w-full">
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 md:mb-4">Contact Information</h3>

                    <div class="space-y-3 md:space-y-4">
                        <p class="flex items-center text-sm md:text-base">
                            <img src="{{ asset('images/location.png') }}" class="w-5 h-5 md:w-6 md:h-6 select-none"
                                alt="Location">
                            <span class="ml-2">Taung Hlay Kar st, Pyin Oo Lwin, Myanmar</span>
                        </p>
                        <p class="flex items-center text-sm md:text-base">
                            <img src="{{ asset('images/phone.png') }}" class="w-5 h-5 md:w-6 md:h-6 select-none"
                                alt="Phone">
                            <span class="ml-2">+95963554322</span>
                        </p>
                        <p class="flex items-center text-sm md:text-base">
                            <img src="{{ asset('images/Message.png') }}" class="w-5 h-5 md:w-6 md:h-6 select-none"
                                alt="Email">
                            <span class="ml-2">astrornixuni27@gmail.com</span>
                        </p>
                        <p class="flex items-start text-sm md:text-base">
                            <img src="{{ asset('images/clock.png') }}" class="w-5 h-5 md:w-6 md:h-6 select-none"
                                alt="Clock">
                            <span class="ml-2">
                                <strong>Office Hours:</strong><br>
                                Monday - Friday: 9:00 AM - 5:00 PM<br>
                                Saturday - Sunday: Closed
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Google Map -->
                <div class="bg-white p-4 md:p-8 rounded-lg shadow-md w-full">
                    <h3 class="text-xl md:text-2xl font-semibold mb-3 md:mb-4">Our Location</h3>
                    <iframe class="w-full h-48 md:h-72 rounded-md"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1337.1271387891006!2d96.45299202258343!3d22.058375233718888!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30cb6dce604dd19f%3A0x78f9e343e467d34d!2zWlBBIFBvbCDhgKHhgK3hgJnhgLo!5e0!3m2!1sen!2smm!4v1741951503173!5m2!1sen!2smm"
                        allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full px-4 md:px-12 mt-10 py-8 md:py-12 bg-gray-50">
        <h2 class="text-2xl md:text-4xl font-semibold mb-8 text-center text-gray-800">Frequently Asked Questions</h2>

        <div class="max-w-4xl mx-auto divide-y divide-gray-200">
            <!-- FAQ Item 1 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(1)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        What makes your magazine unique compared to others?
                    </span>
                    <i id="icon1" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq1" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        Our magazine stands out by offering a perfect blend of in-depth, high-quality content across
                        diverse fields. We focus on delivering expert opinions, innovative trends, and real stories from
                        industry leaders, ensuring our readers receive both valuable knowledge and fresh perspectives
                        every issue. We're committed to exploring untold stories and presenting them in ways that
                        inspire, educate, and entertain.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(2)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        How do you choose the topics you cover in each issue?
                    </span>
                    <i id="icon2" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq2" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        We focus on what matters most to our audience—topics that drive conversation, spark curiosity,
                        and challenge the status quo. Our editorial team combines market research, feedback from our
                        loyal readers, and the latest trends in various industries to select timely, relevant, and
                        impactful subjects. We’re dedicated to bringing attention to emerging ideas and exploring the
                        depths of current events.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(3)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        How can I contribute to your magazine and be featured as a writer?
                    </span>
                    <i id="icon3" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq3" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        We’re always excited to discover fresh voices! If you have unique insights, stories, or
                        expertise, we welcome your submissions. To contribute, simply submit a pitch or a completed
                        article to our editorial team. We look for high-quality content that resonates with our
                        audience, whether it’s through storytelling, analysis, or creative ideas. We prioritize
                        authenticity, thought-provoking narratives, and original perspectives.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(4)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        What steps do you take to ensure the accuracy and credibility of your content?
                    </span>
                    <i id="icon4" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq4" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        Accuracy is a cornerstone of our publication. Each article goes through a rigorous fact-checking
                        process. We rely on expert sources, verified data, and multiple perspectives to ensure that
                        every piece we publish is not only engaging but also credible. Our editorial team works closely
                        with industry professionals to maintain the highest standards of journalism and integrity in our
                        content.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(5)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        How can I engage with the magazine outside of reading it?
                    </span>
                    <i id="icon5" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq5" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        We believe in fostering a community of passionate readers. You can engage with us through social
                        media platforms, join live webinars and discussions, participate in contests, or even become a
                        part of our writer’s network. We also encourage readers to leave feedback, share thoughts on
                        articles, and interact with fellow readers in our forums to create an open dialogue that extends
                        beyond the pages.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(6)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        What is the most important message your magazine aims to communicate?
                    </span>
                    <i id="icon6" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq6" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        Our core message is to inspire curiosity, provoke thought, and drive positive change. We want
                        our readers to walk away from each issue feeling empowered with knowledge, challenged to think
                        differently, and motivated to act. Whether it’s exploring new frontiers of innovation or
                        shedding light on social issues, our magazine aims to spark the conversations that lead to
                        growth, creativity, and progress.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(7)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        How do you support the community through your magazine?
                    </span>
                    <i id="icon7" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq7" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        We take our responsibility to the community seriously. Beyond delivering engaging content, we
                        spotlight local initiatives, support charity events, and promote sustainable practices. We use
                        our platform to amplify important social causes and collaborate with organizations working
                        toward positive change. Every subscription and engagement helps us fund and support these
                        community-driven efforts.
                    </div>
                </div>
            </div>

            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(8)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        What do you believe is the future of the magazine industry?
                    </span>
                    <i id="icon8" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq8" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        The future of magazines lies in adaptability and embracing digital transformation. While print
                        will always have its place, digital magazines provide an interactive, multimedia experience that
                        can reach global audiences instantaneously. Our focus is on creating content that’s dynamic,
                        immersive, and multi-platform. We aim to integrate augmented reality, video content, and
                        interactive features to create a more personalized and engaging experience for readers.
                    </div>
                </div>
            </div>

            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(9)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        Why should I subscribe to your magazine instead of reading free online content?
                    </span>
                    <i id="icon9" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq9" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        While free content can be accessible, it often lacks depth, accuracy, and quality. A
                        subscription to our magazine grants you exclusive access to premium content, expert analysis,
                        and curated stories that you won’t find elsewhere. We provide value that goes beyond just
                        information—offering carefully researched articles, creative designs, and thought-provoking
                        features that can’t be replicated by free sources. When you subscribe, you’re investing in
                        high-quality journalism and unique storytelling.
                    </div>
                </div>
            </div>

            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(10)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        What can I expect from the magazine over the next year?
                    </span>
                    <i id="icon10" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq10" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        Over the next year, expect to see a transformation in how we present content—more digital
                        interactivity, exclusive interviews with top innovators, and deeper dives into topics that
                        matter. We’re committed to bringing our readers closer to the cutting edge of various
                        industries, from tech and business to culture and the arts. We’re also planning special editions
                        and collaborations with thought leaders to enhance our editorial approach and keep you ahead of
                        the curve.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dropdown Toggle Script -->
    <script>
        function toggleFaq(faqId) {
            const faq = document.getElementById(`faq${faqId}`);
            const icon = document.getElementById(`icon${faqId}`);

            // Toggle the max-height to trigger the transition
            if (faq.style.maxHeight) {
                faq.style.maxHeight = null;
                icon.classList.replace('fa-minus', 'fa-plus');
                icon.classList.remove('rotate-180');
            } else {
                faq.style.maxHeight = faq.scrollHeight + 'px';
                icon.classList.replace('fa-plus', 'fa-minus');
                icon.classList.add('rotate-180');
            }

            // Close other open FAQs
            document.querySelectorAll('[id^="faq"]').forEach((item) => {
                if (item.id !== `faq${faqId}` && item.style.maxHeight) {
                    item.style.maxHeight = null;
                    const otherIcon = document.getElementById(item.id.replace('faq', 'icon'));
                    otherIcon.classList.replace('fa-minus', 'fa-plus');
                    otherIcon.classList.remove('rotate-180');
                }
            });
        }
    </script>
</x-app-layout>
