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

    <!-- Upload History Table -->
    <div id="uploadHistory" class="mx-auto max-w-4xl mt-6 bg-white shadow-sm rounded-lg p-6">
        <h3 class="text-lg font-semibold">Your Upload History</h3>
        <p class="text-sm text-gray-600">Manage your past contributions. You can edit or delete any previous
            submissions.</p>
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
                <tr>
                    <td class="border p-3">AI in Education</td>
                    <td class="border p-3">Research Paper</td>
                    <td class="border p-3">Jan 10, 2024</td>
                    <td class="border p-3 text-yellow-500">Pending Revision</td>
                    <td class="border p-3">
                        <button class="text-white px-4 py-1 rounded hover:opacity-80 underline"
                            style="background-color: #1FE689;" onclick="showReUploadSection()">Edit</button>
                        <button class="text-white px-4 py-1 rounded hover:opacity-80 underline  ml-2"
                            style="background-color: #E61F1F;">Delete</button>

                    </td>
                </tr>
                <tr>
                    <td class="border p-3">Blockchain in Business</td>
                    <td class="border p-3">Article</td>
                    <td class="border p-3">Dec 5, 2023</td>
                    <td class="border p-3 text-green-600">Published</td>
                    <td class="border p-3">
                        <button
                            class="text-white px-4 py-1 rounded cursor-not-allowed hover:opacity-80 underline block mx-auto"
                            style="background-color: #B5B8BF;" disabled>
                            Lock
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

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
