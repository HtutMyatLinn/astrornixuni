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
                        How can I contact support?
                    </span>
                    <i id="icon1" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq1" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        You can contact support through the inquiry form on the contact page, or by emailing us at
                        <strong class="text-blue-600">astrornixuni27@gmail.com</strong>.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(2)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        What are your office hours?
                    </span>
                    <i id="icon2" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq2" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        Our office hours are Monday to Friday from 9:00 AM to 5:00 PM. We are closed on weekends.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(3)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        Can I reach you outside office hours?
                    </span>
                    <i id="icon3" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq3" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        While our office is closed on weekends, you can still send inquiries via the contact form, and
                        our team will get back to you within 24-48 hours.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(4)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        Do you offer 24/7 customer support?
                    </span>
                    <i id="icon4" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq4" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        We do not offer 24/7 support, but our team works diligently to respond to inquiries within 24-48
                        hours.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 5 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(5)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        What is the best way to provide feedback?
                    </span>
                    <i id="icon5" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq5" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        We welcome feedback through our contact form or by emailing us directly at
                        <strong class="text-blue-600">astrornixuni27@gmail.com</strong>.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 6 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(6)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        How long does it take to respond to inquiries?
                    </span>
                    <i id="icon6" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq6" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        We aim to respond to all inquiries within 24-48 hours, depending on the complexity of the
                        request.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 7 -->
            <div class="py-5">
                <button class="w-full text-left flex items-center justify-between focus:outline-none group"
                    onclick="toggleFaq(7)">
                    <span class="text-lg md:text-xl font-medium text-gray-800 transition-colors duration-200">
                        Do you have a physical store?
                    </span>
                    <i id="icon7" class="fas fa-plus text-gray-400 transition-all duration-300"></i>
                </button>
                <div id="faq7" class="overflow-hidden transition-all duration-300 ease-in-out max-h-0">
                    <div class="text-gray-600 mt-3">
                        No, we do not have a physical store at the moment. However, you can reach us online through
                        our contact form or via email.
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
