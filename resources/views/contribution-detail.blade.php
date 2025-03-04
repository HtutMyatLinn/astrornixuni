<x-app-layout>
    <br>
    <div class="max-w-6xl w-full flex flex-col md:flex-row gap-6 mx-auto md:items-start items-center text-center md:text-left">
        <!-- Left Content Section -->
        <div class="w-full md:w-2/3 bg-white p-6 rounded-xl shadow-md">
            <h1 class="text-2xl font-semibold text-gray-900">Secret Woman Business</h1>
            <p class="text-gray-600 text-sm">By John Doe | Faculty of Business | Published: Jan 15, 2025</p>

            <div class="mt-4">
                <img src="{{ asset('images/reimg.png') }}" alt="Business Book" class="w-full rounded-lg">
            </div>

            <h2 class="text-xl font-bold mt-6 text-gray-900">The Secret of Business</h2>
            <p class="mt-2 text-gray-700 font-medium">
                <strong>Business books provide insights into market trends, leadership strategies, and financial management to help individuals and organizations succeed.</strong>
            </p>
            <p class="mt-2 text-gray-700">
                Many business books are based on real-world case studies, allowing readers to learn from successful companies and entrepreneurs.
            </p>
            <p class="mt-2 text-gray-700">
                A well-structured business book covers essential topics like marketing, investment, negotiation, and behavior to develop a strong foundation in business management.
            </p>

            <a href="#" class="text-blue-500 mt-4 inline-block font-medium">Read more</a>

            <!-- Comment Section -->
            <h3 class="text-lg font-semibold mt-6 text-gray-900">Comments</h3>
            <textarea class="w-full p-3 border rounded-md mt-2 focus:ring-2 focus:ring-blue-500" placeholder="Leave a comment..."></textarea>
            <button class="mt-3 bg-[#5A7BAF] text-white px-6 py-2 rounded hover:bg-[#4A6A99] transition">Submit</button>
        </div>

        <!-- Right Sidebar (Trending Articles) -->
        <div class="w-full md:w-1/3 flex flex-col items-center md:items-start">
            <h3 class="text-lg font-semibold text-gray-900 underline">Trending Articles</h3>
            <div class="mt-4">
                <h4 class="text-md font-semibold text-gray-900">Future of Quantum Computing</h4>
                <p class="text-sm text-gray-500">By xxxxx</p>
                <a href="#" class="text-blue-500 text-sm font-medium">Read more</a>
            </div>
            <div class="mt-4">
                <h4 class="text-md font-semibold text-gray-900">Future of Quantum Computing</h4>
                <p class="text-sm text-gray-500">By xxxxx</p>
                <a href="#" class="text-blue-500 text-sm font-medium">Read more</a>
            </div>
            <div class="p-4 flex flex-col items-center mt-6">
                <img src="{{ asset('images/math.png') }}" alt="Mathematics Book" class="w-32 h-auto">
                <p class="text-sm text-gray-600 mt-2 text-center">Mathematics books cover essential topics like algebra, calculus.</p>
            </div>
        </div>
    </div>
    <br><br>
    <!-- Related Contributions Section -->
    <div class="max-w-6xl w-full mt-6 mx-auto text-center">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4 underline text-left">Related Contributions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <div class="text-center">
                <img src="{{ asset('images/math.png') }}" alt="Mathematics Book" class="w-24 h-auto mx-auto">
                <p class="text-gray-700 mt-2 text-center">Mathematics Class XII</p>
            </div>
            <div class="text-center">
                <img src="{{ asset('images/math.png') }}" alt="International Relations" class="w-24 h-auto mx-auto">
                <p class="text-gray-700 mt-2 text-center">International Relations</p>
            </div>
            <div class="text-center">
                <img src="{{ asset('images/math.png') }}" alt="Medical Surgical Nursing" class="w-24 h-auto mx-auto">
                <p class="text-gray-700 mt-2 text-center">Adult Medical Surgical Nursing</p>
            </div>
            <div class="text-center">
                <img src="{{ asset('images/math.png') }}" alt="Mathematics Book" class="w-24 h-auto mx-auto">
                <p class="text-gray-700 mt-2 text-center">Mathematics Class XII</p>
            </div>
        </div>
    </div>
    <br>
</x-app-layout>
