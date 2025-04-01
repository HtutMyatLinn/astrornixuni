<x-app-layout>
    <!-- Main Title Section -->
    <div class="bg-[#5A7BAF] text-white text-center py-16 px-4">
        <h1 class="text-2xl md:text-4xl max-w-md mx-auto font-semibold">Re-upload Your <br> Contribution</h1>
        <p class="text-sm md:text-lg mt-2 opacity-80">
            Your submission requires revision. Update your contribution and re-upload it.
        </p>
    </div>

    <!-- Notification Banner -->
    @if (auth()->user()->contributions()->where('contribution_status', 'Update')->exists())
        <div
            class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 flex items-center mx-auto mt-6 max-w-4xl rounded">
            <span class="text-lg">📢</span>
            <p class="ml-2 font-semibold">Notification:</p>
            <p class="ml-1">Your previous submission has been reviewed. Please update and re-upload your contribution.
            </p>
        </div>
    @endif

    <div id="uploadHistory" class="mx-auto max-w-4xl mt-6 bg-white shadow-sm rounded-lg p-6">
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
                                                : ($contribution->contribution_status == 'Publish'
                                                    ? 'Published'
                                                    : $contribution->contribution_status)))) }}
                            </td>
                            <td class="border p-3 select-none">
                                @if ($contribution->contribution_status !== 'Publish')
                                    @if (now() < \Carbon\Carbon::parse($contribution->intake->final_closure_date))
                                        <a href="{{ route('upload_contribution.edit', $contribution->contribution_id) }}"
                                            class="text-white px-4 py-1 rounded hover:opacity-80 underline"
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
