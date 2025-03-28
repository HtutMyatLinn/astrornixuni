<x-app-layout>
    <!-- Main Title Section -->
    <div class="bg-[#5A7BAF] text-white text-center py-16 px-4">
        <h1 class="text-2xl md:text-4xl max-w-md mx-auto font-semibold">Re-upload Your <br> Contribution</h1>
        <p class="text-sm md:text-lg mt-2 opacity-80">
            Your submission requires revision. Update your contribution and re-upload it.
        </p>
    </div>

    <!-- Notification Banner -->
    <div
        class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-4 py-3 flex items-center mx-auto mt-6 max-w-4xl rounded">
        <span class="text-lg">📢</span>
        <p class="ml-2 font-semibold">Notification:</p>
        <p class="ml-1">Your previous submission has been reviewed. Please update and re-upload your contribution.</p>
    </div>

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
                                        <button class="text-white px-4 py-1 rounded hover:opacity-80 underline"
                                            style="background-color: #1FE689;"
                                            onclick="showReUploadSection({{ $contribution->contribution_id }})">
                                            Edit
                                        </button>
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

    <script>
        function showReUploadSection(contributionId) {
            // You can implement this function to show a modal or redirect
            // For example:
            window.location.href = `/contributions/${contributionId}/edit`;
        }
    </script>

    <!-- Re-Upload Contribution Section (Initially Hidden) -->
    <div id="reUploadSection" class="hidden mx-auto max-w-4xl mt-6 bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-semibold">Re-Upload Your Contribution</h3>
        <p class="text-sm text-gray-600">These are the files from your last submission. You can delete them and upload
            new ones.</p>

        <!-- Current Submission Files -->
        <div class="mt-4">
            <div class="flex justify-between items-center border p-3 rounded bg-gray-100">
                <span>Cover Image: ai_research.jpg</span>
                <button
                    class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600"style="background-color: #E61F1F;">Delete</button>
            </div>
            <div class="flex justify-between items-center border p-3 rounded bg-gray-100 mt-2">
                <span>Document: ai_research_paper.docx</span>
                <button
                    class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600"style="background-color: #E61F1F;">Delete</button>
            </div>
            <h4 class="mt-4 font-semibold">Additional Images</h4>
            <div class="flex justify-between items-center border p-3 rounded bg-gray-100 mt-2">
                <span>Image 1: research_diagram.jpg</span>
                <button
                    class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600"style="background-color: #E61F1F;">Delete</button>
            </div>
            <div class="flex justify-between items-center border p-3 rounded bg-gray-100 mt-2">
                <span>Image 2: data_chart.png</span>
                <button
                    class="bg-red-500 text-white px-4 py-1 rounded hover:bg-red-600"style="background-color: #E61F1F;">Delete</button>
            </div>
        </div>

        <!-- Upload New Files -->
        <h3 class="mt-6 text-lg font-semibold">Upload New Files</h3>
        <div class="mt-4">
            <label class="block font-medium">Cover Image (High-Quality JPG/PNG)</label>
            <input type="file" class="w-full border p-2 rounded mt-1">
            <label class="block font-medium mt-4">Additional Images (Up to 3) - JPG/PNG</label>
            <input type="file" class="w-full border p-2 rounded mt-1">
            <label class="block font-medium mt-4">Upload Word Document (.docx)</label>
            <input type="file" class="w-full border p-2 rounded mt-1">
        </div>
        <div class="mt-6">
            <button class="bg-[#5A7BAF] text-white w-full py-3 rounded hover:bg-[#3A5B8F]">
                Re-Upload Contribution
            </button>
        </div>
    </div>
    <br>
    <script>
        function showReUploadSection() {
            document.getElementById("reUploadSection").classList.remove("hidden");
        }
    </script>
</x-app-layout>
