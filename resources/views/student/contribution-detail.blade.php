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
                {{ $contribution->view_count <= 1 ? 'view' : 'views' }}
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

            <!-- Comment form -->
            <form action="{{ route('comment.store') }}" method="POST">
                @csrf
                <h3 class="text-lg font-semibold mt-6 text-gray-900">Comments</h3>

                {{-- Message --}}
                @if (session('success'))
                    <div id="success-message"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-3 rounded relative"
                        role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>

                    <script>
                        setTimeout(() => {
                            document.getElementById('success-message').style.display = 'none';
                        }, 3000);
                    </script>
                @endif

                <div class="relative">
                    @if (Auth::check())
                        <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}">
                    @else
                        <p class="text-red-500 text-sm">You must be logged in to comment.</p>
                    @endif
                    <input type="hidden" name="contribution_id" value="{{ $contribution->contribution_id }}">
                    <textarea class="w-full p-3 border rounded-md mt-2 focus:ring-2 focus:ring-blue-500" name="comment_text"
                        placeholder="Leave a comment..."></textarea>
                    @error('comment_text')
                        <p class="absolute left-2 -bottom-1 bg-white text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <button type="submit"
                    class="mt-3 bg-[#5A7BAF] text-white px-6 py-2 rounded hover:bg-[#4A6A99] transition select-none">Submit</button>
            </form>
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

    {{-- Comment section --}}
    <div class="space-y-6 max-w-6xl mx-auto border-b-2 py-10">
        <h3 class="text-lg font-semibold text-gray-900">{{ $comments->count() }}
            {{ $comments->count() <= 1 ? 'Comment' : 'Comments' }}</h3>

        @if ($comments->count() > 0)
            @foreach ($comments as $comment)
                <div class="flex space-x-4">
                    @if ($comment->user->profile_image)
                        <img src="https://i.pravatar.cc/40?img=1" alt="User Avatar"
                            class="w-12 h-12 rounded-full select-none">
                    @else
                        <p
                            class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                            {{ strtoupper($comment->user->username[0]) }}
                        </p>
                    @endif
                    <div class="w-full">
                        <div>
                            <div class="flex items-center gap-3">
                                <h4 class="font-semibold text-gray-800">{{ $comment->user->username }}</h4>
                                <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 mt-2">{{ $comment->comment_text }}</p>
                        </div>
                        <div class="flex items-center space-x-2 mt-2 text-sm text-gray-500">
                            @if (Auth::check() && Auth::user()->user_id === $comment->user_id)
                                <button class="hover:text-blue-500">Edit</button>
                                <button class="hover:text-red-500">Delete</button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-600 py-10">No comments found.</p>
        @endif
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
    </div>
    <br>
</x-app-layout>
