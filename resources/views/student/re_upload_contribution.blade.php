<x-app-layout>
    <!-- Main Title Section -->
    <div class="bg-[#5A7BAF] text-white text-center py-16 px-4">
        <h1 class="text-2xl md:text-4xl max-w-md mx-auto font-semibold">Re-upload Your <br> Contribution</h1>
        <p class="text-sm md:text-lg mt-2 opacity-80">
            Your submission requires revision. Update your contribution and re-upload it.
        </p>
    </div>

    <!-- Notification Banner - Only shows when there's a contribution in Review status -->
    @if ($noti->exists())
        <div
            class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 flex flex-col mx-auto mt-6 max-w-4xl rounded">
            <div class="flex items-center">
                <span class="text-lg select-none">📢</span>
                <p class="ml-2 font-semibold">Notification:</p>
                <p class="ml-1">Your previous submission has been reviewed. Please update and re-upload your
                    contribution.</p>
            </div>
        </div>
    @endif

    <div class="mt-4 p-5 bg-white rounded-lg border border-gray-200 shadow-sm mx-auto max-w-4xl">
        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-yellow-500" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                    clip-rule="evenodd" />
            </svg>
            Contribution Feedbacks
        </h3>

        <div class="space-y-4">
            @if ($feedbacks->isNotEmpty())
                @foreach ($feedbacks as $feedback)
                    <div class="border border-gray-100 rounded-lg shadow-sm">
                        <!-- Contribution Info -->
                        <div class="bg-gray-50 px-4 py-3 border-b border-gray-100">
                            <h4 class="font-medium text-gray-700">
                                Submission: {{ $feedback->contribution->contribution_title ?? 'Untitled Contribution' }}
                            </h4>
                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Submitted on: {{ $feedback->contribution->submitted_date->format('M d, Y') }}
                                <span class="mx-2">•</span>
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium select-none
                                    {{ $feedback->contribution->contribution_status == 'Upload'
                                        ? 'bg-yellow-100 text-yellow-800'
                                        : ($feedback->contribution->contribution_status == 'Select'
                                            ? 'bg-blue-100 text-blue-800'
                                            : ($feedback->contribution->contribution_status == 'Review'
                                                ? 'bg-yellow-100 text-yellow-800'
                                                : ($feedback->contribution->contribution_status == 'Update'
                                                    ? 'bg-orange-100 text-orange-800'
                                                    : ($feedback->contribution->contribution_status == 'Reject'
                                                        ? 'bg-red-100 text-red-800'
                                                        : ($feedback->contribution->contribution_status == 'Publish'
                                                            ? 'bg-green-100 text-green-800'
                                                            : 'bg-gray-300'))))) }} ">
                                    {{ $feedback->contribution->contribution_status == 'Upload'
                                        ? 'Uploaded'
                                        : ($feedback->contribution->contribution_status == 'Select'
                                            ? 'Selected'
                                            : ($feedback->contribution->contribution_status == 'Review'
                                                ? 'Reviewed'
                                                : ($feedback->contribution->contribution_status == 'Update'
                                                    ? 'Updated'
                                                    : ($feedback->contribution->contribution_status == 'Reject'
                                                        ? 'Rejected'
                                                        : ($feedback->contribution->contribution_status == 'Publish'
                                                            ? 'Published'
                                                            : $feedback->contribution->contribution_status))))) }}
                                </span>
                            </div>
                        </div>

                        <!-- Feedback Content -->
                        <div class="p-4">
                            <div class="flex gap-4">
                                <!-- Reviewer Avatar -->
                                <div class="flex-shrink-0 select-none">
                                    @if ($feedback->user && $feedback->user->profile_image)
                                        <img src="{{ asset('storage/profile_images/' . $feedback->user->profile_image) }}"
                                            alt="Reviewer Profile"
                                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border-2 border-white shadow-sm">
                                    @else
                                        <div
                                            class="flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 text-blue-600 font-semibold shadow-sm">
                                            {{ strtoupper(substr($feedback->user->username ?? 'R', 0, 1)) }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Feedback Details -->
                                <div class="flex-1 min-w-0">
                                    <div
                                        class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 mb-1">
                                        <h4 class="font-semibold text-sm text-gray-800 truncate">
                                            {{ $feedback->user->username ?? 'Anonymous' }} <span class="text-gray-600">
                                                (Marketing Coordinator)
                                            </span>
                                        </h4>
                                        <div class="flex items-center text-xs text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $feedback->feedback_given_date->diffForHumans() }}
                                            @if ($feedback->created_at != $feedback->updated_at)
                                                <span class="ml-1 text-gray-400">(Edited)</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="prose prose-sm max-w-none text-sm text-gray-600">
                                        {!! nl2br(e($feedback->feedback)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination Links -->
                <div class="mt-4">
                    {{ $feedbacks->links() }}
                </div>
            @else
                <div class="text-center py-6 text-gray-500">
                    No feedback available yet.
                </div>
            @endif

        </div>
    </div>

    <div id="uploadHistory" class="mx-auto max-w-4xl my-6 bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-semibold">Your Upload History</h3>
        <p class="text-sm text-gray-600">Manage your past contributions. You can edit or delete any previous
            submissions.</p>

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

        @if ($contributions->count() > 0)
            <table class="w-full mt-4 border border-gray-300">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border p-3 text-left">Title</th>
                        <th class="border p-3 text-left">Category</th>
                        <th class="border p-3 text-left">Submission Date</th>
                        <th class="border p-3 text-left">Status</th>
                        <th class="border p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($contributions as $contribution)
                        <tr>
                            <td class="border p-3">{{ $contribution->contribution_title }}</td>
                            <td class="border p-3">{{ $contribution->category->contribution_category }}
                            </td>
                            <td class="border p-3">{{ $contribution->submitted_date->format('M d, Y') }}</td>
                            <td
                                class="border p-3 {{ $contribution->contribution_status === 'Publish' ? 'text-green-600' : 'text-yellow-500' }}">
                                {{ $contribution->contribution_status == 'Upload'
                                    ? 'Uploaded'
                                    : ($contribution->contribution_status == 'Select'
                                        ? 'Selected'
                                        : ($contribution->contribution_status == 'Update'
                                            ? 'Updated'
                                            : ($contribution->contribution_status == 'Reject'
                                                ? 'Rejected'
                                                : ($contribution->contribution_status == 'Review'
                                                    ? 'Reviewed'
                                                    : ($contribution->contribution_status == 'Publish'
                                                        ? 'Published'
                                                        : $contribution->contribution_status))))) }}
                            </td>
                            <td class="border p-3 select-none">
                                @if ($contribution->contribution_status !== 'Publish')
                                    @if (now() < \Carbon\Carbon::parse($contribution->intake->final_closure_date))
                                        <a href="{{ route('upload_contribution.edit', $contribution->contribution_id) }}"
                                            class="text-white px-4 py-[7.5px] rounded hover:opacity-80 underline"
                                            style="background-color: #1FE689;">
                                            Edit
                                        </a>
                                        <form
                                            action="{{ route('student.contributions.destroy', $contribution->contribution_id) }}"
                                            method="POST" class="inline ml-2"
                                            id="deleteForm{{ $contribution->contribution_id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="text-white px-4 py-1 rounded hover:opacity-80 underline"
                                                style="background-color: #E61F1F;"
                                                onclick="confirmDelete({{ $contribution->contribution_id }})">
                                                Delete
                                            </button>
                                        </form>
                                    @else
                                        <button
                                            class="text-white px-4 py-1 rounded cursor-not-allowed hover:opacity-80 underline bg-[#B5B8BF]">
                                            Submission Closed
                                        </button>
                                    @endif
                                @else
                                    <button
                                        class="text-white
                                            px-4 py-1 rounded cursor-not-allowed hover:opacity-80 underline bg-[#B5B8BF]"
                                        disabled>
                                        Locked
                                    </button>
                                @endif

                                <script>
                                    function confirmDelete(contributionId) {
                                        if (confirm('Are you sure you want to delete this contribution?')) {
                                            document.getElementById('deleteForm' + contributionId).submit();
                                        }
                                    }
                                </script>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="mt-4 p-4 bg-gray-100 rounded-lg text-center">
                <p class="text-gray-600">You haven't uploaded any contributions yet.</p>
            </div>
        @endif
    </div>
</x-app-layout>
