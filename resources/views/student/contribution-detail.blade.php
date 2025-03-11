<x-app-layout>
    <br>
    <div
        class="max-w-6xl w-full flex flex-col md:flex-row gap-6 mx-auto md:items-start items-center text-center md:text-left">
        <!-- Left Content Section -->
        <div class="w-full md:w-2/3 bg-white p-6 border-x-2 border-x-slate-100">
            <h1 class="text-2xl font-semibold text-gray-900">{{ $contribution->contribution_title }}</h1>
            <p class="text-gray-600 text-sm">By {{ $contribution->user->username }} |
                {{ $contribution->user->faculty->faculty }} | Published:
                {{ $contribution->created_at->diffForHumans() }}</p>
            <p class="flex items-center text-sm text-gray-600 mt-2">
                <i class="ri-group-line text-gray-500 mr-2"></i>
                <span class="font-medium mr-1">{{ $contribution->view_count }}</span>
                {{ $contribution->view_count === 1 ? 'view' : 'views' }}
                <span>
                    <i
                        class="ri-fire-line {{ $contribution->view_count >= 1000
                            ? 'text-red-500'
                            : ($contribution->view_count >= 500
                                ? 'text-orange-500'
                                : ($contribution->view_count >= 100
                                    ? 'text-yellow-500'
                                    : 'text-gray-500')) }}"></i>
                </span>
            </p>
            <!-- Fixed Image Container -->
            <div class="mt-4 h-[480px] overflow-hidden rounded-lg select-none">
                <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                    alt="{{ $contribution->contribution_title }}" class="h-full w-full object-cover">
            </div>

            <h2 class="text-xl font-bold mt-6 text-gray-900">{{ $contribution->contribution_title }}</h2>
            <p class="mt-2 text-gray-700">
                {!! nl2br(e($contribution->contribution_description)) !!}
            </p>

            <a href="{{ asset('storage/contribution-documents/' . $contribution->contribution_file_path) }}"
                class="text-blue-500 mt-4 inline-block font-medium">Read
                more</a>

            <!-- Comment Section -->
            <h3 class="text-lg font-semibold mt-6 text-gray-900">Comments</h3>
            <textarea class="w-full p-3 border rounded-md mt-2 focus:ring-2 focus:ring-blue-500" placeholder="Leave a comment..."></textarea>
            <button class="mt-3 bg-[#5A7BAF] text-white px-6 py-2 rounded hover:bg-[#4A6A99] transition">Submit</button>
        </div>

        <!-- Right Sidebar (Trending Articles) -->
        <div class="sticky top-20 w-full md:w-1/3 flex flex-col items-center md:items-start">
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Trending Articles</h3>
            <div class="bg-white w-full px-3">
                @foreach ($trendingContributions as $trending)
                    <div class="my-4">
                        <h4 class="text-md font-semibold text-gray-900">{{ $trending->contribution_title }}</h4>
                        <p class="text-sm text-gray-500">By {{ $trending->user->username }}</p>
                        <a href="{{ route('student.contribution-detail', $trending) }}"
                            class="text-blue-500 text-sm font-medium">Read more</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="space-y-6 max-w-6xl mx-auto border-b-2 py-10">
        <h3 class="text-lg font-semibold text-gray-900">2 Comments</h3>
        <!-- Single Comment -->
        <div class="flex space-x-4">
            <img src="https://i.pravatar.cc/40?img=1" alt="User Avatar" class="w-12 h-12 rounded-full">
            <div class="w-full">
                <div>
                    <div class="flex items-center gap-3">
                        <h4 class="font-semibold text-gray-800">John Doe</h4>
                        <span class="text-xs text-gray-500">2 hours ago</span>
                    </div>
                    <p class="text-gray-700 mt-2">This is a sample comment with some text content.</p>
                </div>
                <div class="flex items-center space-x-2 mt-2 text-sm text-gray-500">
                    <button class="hover:text-blue-500">Edit</button>
                    <button class="hover:text-red-500">Delete</button>
                </div>
            </div>
        </div>
        <div class="flex space-x-4">
            <img src="https://i.pravatar.cc/40?img=1" alt="User Avatar" class="w-12 h-12 rounded-full">
            <div class="w-full">
                <div>
                    <div class="flex items-center gap-3">
                        <h4 class="font-semibold text-gray-800">John Doe</h4>
                        <span class="text-xs text-gray-500">2 hours ago</span>
                    </div>
                    <p class="text-gray-700 mt-2">This is a sample comment with some text content.</p>
                </div>
                <div class="flex items-center space-x-2 mt-2 text-sm text-gray-500">
                    <button class="hover:text-blue-500">Edit</button>
                    <button class="hover:text-red-500">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Contributions Section -->
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 pt-8 mb-10 py-10 flex flex-col gap-3 border-b-2">
        <div class="mb-5 sm:mb-16">
            <h1 class="text-2xl font-bold underline">Related Contributions</h1>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-1 sm:gap-5">
            @if ($contributions->count() > 0)
                @foreach ($contributions as $contribution)
                    <a href="{{ route('student.contribution-detail', $contribution) }}"
                        class="overflow-hidden flex flex-col items-center">
                        <div class="relative h-64 w-full overflow-hidden">
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
    </div>
    <br>
</x-app-layout>
