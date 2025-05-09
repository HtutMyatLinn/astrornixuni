<x-app-layout>
    <br>
    <div class="max-w-6xl w-full flex flex-col md:flex-row gap-6 mx-auto md:items-start items-center">
        <!-- Left Content Section -->
        <div class="w-full md:w-2/3 bg-white p-6 border-x-2 border-x-slate-100">
            <h1 class="text-2xl font-semibold text-start text-gray-900">{{ $contribution->contribution_title }}</h1>
            <p class="text-gray-600 text-sm text-start">
                By {{ $contribution->user->username }} |
                {{ $contribution->user->faculty->faculty }} |
                Published: {{ \Carbon\Carbon::parse($contribution->published_date)->format('F j, Y') }}
            </p>
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
            @if ($contribution->contribution_cover)
                <div class="mt-4 h-[480px] overflow-hidden rounded-lg select-none">
                    <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                        alt="{{ $contribution->contribution_title }}" class="h-full w-full object-cover">
                </div>
            @else
                <!-- Display the default logo image if contribution_cover is null -->
                <div class="flex h-full py-20 w-full items-center justify-center">
                    <div class="mt-4 h-[150px] overflow-hidden rounded-lg select-none">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            <!-- Display additional images if they exist -->
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

            <h2 class="text-xl font-bold mt-6 text-gray-900 text-start">{{ $contribution->contribution_title }}</h2>
            <div x-data="{ expanded: false }">
                <p class="mt-2 text-gray-700 text-start">
                    <span x-show="!expanded">
                        {!! nl2br(e(Str::limit($contribution->contribution_description, 350))) !!}
                    </span>
                    <span x-show="expanded">
                        {!! nl2br(e($contribution->contribution_description)) !!}
                    </span>
                </p>

                @if (strlen($contribution->contribution_description) > 350)
                    <button @click="expanded = !expanded" class="text-blue-500 hover:underline mt-2 flex justify-start">
                        <span x-show="!expanded">Read more</span>
                        <span x-show="expanded">Show less</span>
                    </button>
                @endif
            </div>

            @if ($contribution->contribution_file_path !== null)
                <a href="{{ asset('storage/contribution-documents/' . $contribution->contribution_file_path) }}"
                    class="text-blue-500 mt-4 inline-block font-medium">Download</a>
            @endif

            <!-- Comment form -->
            <form action="{{ route('comment.store') }}" method="POST">
                @csrf
                <h3 class="text-lg font-semibold mt-6 text-gray-900 text-start">Comments</h3>

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
                        }, 5000);
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
                @if (Auth::check())
                    <button type="submit"
                        class="mt-3 bg-[#5A7BAF] text-white w-full sm:w-auto px-6 py-2 rounded hover:bg-[#4A6A99] transition select-none">
                        Submit
                    </button>
                @else
                    <button type="button" disabled
                        class="mt-3 bg-[#5A7BAF] text-white w-full sm:w-auto px-6 py-2 rounded cursor-not-allowed opacity-50 select-none">
                        Submit
                    </button>
                @endif
            </form>
        </div>

        <!-- Right Sidebar (Trending Articles) -->
        <div class="sticky top-20 w-full md:w-1/3 flex flex-col items-center text-center md:text-left md:items-start">
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
    <div class="space-y-6 max-w-6xl mx-auto border-b-2 py-10 px-3">
        <h3 class="text-lg font-semibold text-gray-900">{{ $comments->count() }}
            {{ $comments->count() <= 1 ? 'Comment' : 'Comments' }}</h3>

        @if ($comments->count() > 0)
            @foreach ($comments as $comment)
                <div class="flex space-x-4">
                    @if ($comment->user && $comment->user->profile_image)
                        <img src="{{ asset('profile_images/' . $comment->user->profile_image) }}" alt="User Profile"
                            class="w-12 h-12 rounded-full select-none object-cover">
                    @else
                        <div class="flex items-center">
                            <p
                                class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                {{ $comment->user ? strtoupper($comment->user->username[0]) : '?' }}
                            </p>
                        </div>
                    @endif
                    <div class="w-full">
                        <div>
                            <div class="flex items-center gap-3">
                                <h4 class="font-semibold text-gray-800">{{ $comment->user->username }}</h4>
                                <div>
                                    <span class="text-xs text-gray-500">
                                        @if ($comment->created_at->diffInSeconds(now()) < 60)
                                            Just now
                                        @else
                                            {{ $comment->created_at->diffForHumans() }}
                                        @endif
                                    </span>
                                    @if ($comment->created_at != $comment->updated_at)
                                        <span class="text-sm text-gray-400">(Edited)</span>
                                    @endif
                                    </span>
                                </div>
                            </div>

                            <!-- Alpine.js for Read More Feature -->
                            <div x-data="{ expanded: false }">
                                <p class="text-gray-700 mt-2">
                                    <span x-show="!expanded">
                                        {{ Str::limit($comment->comment_text, 150) }}
                                    </span>
                                    <span x-show="expanded">
                                        {{ $comment->comment_text }}
                                    </span>
                                </p>
                                @if (strlen($comment->comment_text) > 150)
                                    <button @click="expanded = !expanded" class="text-gray-400 hover:underline">
                                        <span x-show="!expanded">Read more</span>
                                        <span x-show="expanded">Show less</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 mt-2 text-sm text-gray-500">
                            @if (Auth::check() && Auth::user()->user_id === $comment->user_id)
                                <div x-data="{ editing: false, commentText: '{{ $comment->comment_text }}' }" class="w-full">
                                    <!-- Textarea for editing -->
                                    <textarea x-show="editing" x-model="commentText" name="comment_text" class="w-full p-2 border rounded mt-2"></textarea>

                                    <!-- Buttons for Save & Cancel -->
                                    <div x-show="editing" class="mt-2 flex space-x-2">
                                        <button @click="editing = false"
                                            class="text-gray-500 hover:text-gray-700">Cancel</button>
                                        <button @click="updateComment({{ $comment->comment_id }}, commentText)"
                                            class="text-blue-500 hover:underline">Save</button>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <!-- Edit Button -->
                                        <button @click="editing = true" x-show="!editing"
                                            class="hover:text-blue-500">Edit</button>

                                        <!-- Delete Button (Hidden when editing) -->
                                        <form method="POST"
                                            action="{{ route('comments.destroy', $comment->comment_id) }}"
                                            class="delete-form" x-show="!editing">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="hover:text-red-500">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            <script>
                                function updateComment(commentId, newText) {
                                    fetch(`/comments/${commentId}`, {
                                            method: 'PATCH',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                                            },
                                            body: JSON.stringify({
                                                comment_text: newText
                                            })
                                        })
                                        .then(response => {
                                            if (response.ok) {
                                                window.location.reload(); // Redirect back without showing a message
                                            }
                                        })
                                        .catch(error => console.error('Error:', error));
                                }
                            </script>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-600 py-10 text-center">No comments found.</p>
        @endif

        <!-- Pagination -->
        @if ($comments->count() > 0)
            <div class="flex justify-end items-center gap-2 mt-6">
                {{ $comments->appends(request()->query())->links('pagination::tailwind') }}
            </div>
        @endif
    </div>

    <!-- Related Contributions Section -->
    <div class="max-w-6xl mx-auto px-3 sm:px-6 lg:px-8 pt-8 mb-10 py-10 flex flex-col gap-3 border-b-2">
        <div class="mb-5 sm:mb-16">
            <h1 class="text-2xl font-bold underline">Related Contributions</h1>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-1 sm:gap-5">
            @if ($contributions->count() > 0)
                @foreach ($contributions as $contribution)
                    <a href="{{ route('student.contribution-detail', $contribution) }}"
                        class="overflow-hidden flex flex-col items-center">
                        @if ($contribution->contribution_cover)
                            <div class="relative h-64 w-full overflow-hidden select-none">
                                <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                    alt="{{ $contribution->contribution_title }}"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105">
                            </div>
                        @else
                            <!-- Display the default logo image if contribution_cover is null -->
                            <div class="relative h-64 w-full overflow-hidden select-none">
                                <div class="flex h-full items-center justify-center">
                                    <div class="w-24 overflow-hidden rounded-lg select-none">
                                        <!-- Adjust width here (e.g., w-24) -->
                                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                            class="w-full h-full object-cover">
                                    </div>
                                </div>
                            </div>
                        @endif
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
