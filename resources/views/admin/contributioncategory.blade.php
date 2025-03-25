<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>

    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-w-[420px]">
    <!-- Main Container -->
    <div class="flex min-h-screen relative">
        <!-- Sidebar Toggle Button (Mobile) -->
        <button id="sidebarToggle"
            class="lg:hidden fixed bottom-4 right-4 z-50 bg-blue-600 text-white p-3 rounded-full shadow-lg">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="w-64 fixed inset-y-0 left-0 transform transition-transform duration-300 z-40 -translate-x-full lg:translate-x-0">
            @include('admin.sidebar')
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden lg:ml-64">
            @include('admin.header')

            <div class="p-8 bg-white m-5 shadow-lg">
                <h1 class="text-2xl font-bold mb-6">List of Contribution Types</h1>
                <h2 class=" text-lg font-semibold text-gray-400 mb-4">
                    Total - {{ $contribution_categories->count() }}
                </h2>

                <!-- Tabs -->
                <div class="flex gap-8 border-b mb-6 overflow-x-auto whitespace-nowrap">
                    <a href="{{ route('roles.index') }}" class="px-1 py-4 text-gray-600 hover:text-gray-900">
                        Role Management
                    </a>
                    <a href="{{ route('contribution-category.index') }}"
                        class="px-1 py-4 hover:text-gray-900 text-[#4353E1] border-b-4 border-[#4353E1]">
                        Contribution Category Management
                    </a>
                    <a href="{{ route('faculty.index') }}" class="px-1 py-4 text-gray-600 hover:text-gray-900">
                        Faculty Management
                    </a>
                </div>

                {{-- Add Contribution Type Button --}}
                <div class="flex justify-end my-4">
                    <button onclick="openModal()"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 select-none">
                        Add Contribution Category
                    </button>
                </div>

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

                <!-- Search and Filters -->
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between mb-8">
                    <div class="relative max-w-[400px]">
                        <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                        <form method="GET" action="{{ route('admin.contribution_categories.search') }}">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
                                class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                        </form>
                    </div>

                    <div class="flex gap-4">
                        <!-- Sort Dropdown -->
                        <form method="GET" action="{{ route('contribution-category.index') }}">
                            <select name="sort" onchange="this.form.submit()"
                                class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First
                                </option>
                                <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First
                                </option>
                            </select>
                        </form>

                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-[#F9F8F8]">
                                <tr>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Contribution
                                        Category
                                    </th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Added Date</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Updated Date</th>
                                    <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @if ($contribution_categories->isNotEmpty())
                                    @foreach ($contribution_categories as $contribution_category)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ $contribution_category->contribution_category }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ optional($contribution_category->created_at)->format('M d, Y') ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 text-gray-600">
                                                {{ optional($contribution_category->updated_at)->format('M d, Y') ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4">
                                                <button
                                                    onclick="openEditModal('{{ $contribution_category->contribution_category_id }}', '{{ $contribution_category->contribution_category }}')"
                                                    class="text-blue-600 hover:text-blue-700">
                                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                        <path d="m15 5 4 4" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-24 text-gray-600 text-center" colspan="4">
                                            No contribution categories found.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                @if ($contribution_categories->isNotEmpty())
                    <div class="flex justify-end items-center gap-2 mt-6">
                        {{ $contribution_categories->appends(request()->query())->links('pagination::tailwind') }}
                    </div>
                @endif
            </div>

            <!-- Add New Role Modal -->
            <div class="flex justify-center items-center mt-24 w-full">
                <!-- Modal -->
                <div id="contributionCategoryModal"
                    class="fixed inset-0 z-50 flex items-center justify-center opacity-0 invisible p-2 -translate-y-5 transition-all duration-300">
                    <div class="max-w-md w-full bg-white p-8 rounded-md shadow-lg relative">
                        <button onclick="closeModal()" class="absolute top-2 right-2 text-black">
                            ✖
                        </button>

                        <h1 class="text-2xl font-bold text-center mb-6">
                            Add <span class="border-b-2 border-blue-600">New</span> Contribution Category
                        </h1>

                        <form action="{{ route('contribution-category.store') }}" method="POST">
                            @csrf

                            <!-- Contribution Category Input -->
                            <div class="mb-4 relative">
                                <label class="block text-sm font-medium mb-2">Contribution Category :</label>
                                <input type="text" name="contribution_category"
                                    value="{{ old('contribution_category') }}"
                                    placeholder="Enter contribution category..."
                                    class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg
                focus:outline-none focus:ring-2 focus:ring-blue-500 @error('contribution_category') border-red-500 @enderror">

                                @error('contribution_category')
                                    <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                                        {{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Save Button -->
                            <div class="flex justify-center">
                                <button type="submit"
                                    class="px-12 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 select-none">
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Edit Contribution Category Modal -->
            <div id="editContributionCategoryModal"
                class="fixed inset-0 z-50 flex items-center justify-center opacity-0 invisible p-2 -translate-y-5 transition-all duration-300">
                <div class="max-w-md w-full bg-white p-8 rounded-md shadow-lg relative">
                    <button onclick="closeEditModal()" class="absolute top-2 right-2 text-black">✖</button>

                    <h1 class="text-2xl font-bold text-center mb-6">
                        Edit <span class="border-b-2 border-blue-600">Contribution Category</span>
                    </h1>

                    <form id="editContributionCategoryForm" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Hidden ID Input -->
                        <input type="hidden" id="editContributionCategoryId" name="contribution_category_id"
                            value="{{ old('contribution_category_id') }}">

                        <!-- Role Name Input -->
                        <div class="mb-4 relative">
                            <label class="block text-sm font-medium mb-2">Role Name :</label>
                            <input type="text" id="editContributionCategory" name="edit_contribution_category"
                                value="{{ old('edit_contribution_category') }}"
                                placeholder="Enter contribution category..."
                                class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('edit_contribution_category')
                                <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                                    {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-center">
                            <button type="submit"
                                class="px-12 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800 select-none">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- JavaScript for Modal -->
            <script>
                // Open contribution category modal
                function openModal() {
                    darkOverlay2.classList.remove('opacity-0', 'invisible');
                    darkOverlay2.classList.add('opacity-100');
                    document.getElementById('contributionCategoryModal').classList.remove('opacity-0', 'invisible',
                        '-translate-y-5');
                }

                // Close contribution category modal
                function closeModal() {
                    darkOverlay2.classList.add('opacity-0', 'invisible');
                    darkOverlay2.classList.remove('opacity-100');
                    document.getElementById('contributionCategoryModal').classList.add('opacity-0', 'invisible', '-translate-y-5');

                    // Reset validation messages
                    document.querySelectorAll("#contributionCategoryModal p.text-red-500").forEach(el => el.remove());
                    document.querySelectorAll("#contributionCategoryModal input").forEach(el => el.classList.remove(
                        "border-red-500"));
                }


                // Keep modal open if validation errors exist
                window.onload = function() {
                    @if ($errors->has('contribution_category'))
                        openModal();
                    @endif

                    @if ($errors->has('edit_contribution_category'))
                        openEditModal("{{ old('contribution_category_id') }}", "{{ old('edit_contribution_category') }}");
                    @endif
                };

                // Open edit contribution category modal
                function openEditModal(contribution_category_id, contribution_category) {
                    // Populate the modal fields with the selected role's data
                    document.getElementById('editContributionCategoryId').value = contribution_category_id;
                    document.getElementById('editContributionCategory').value = contribution_category;

                    // Set form action dynamically
                    document.getElementById('editContributionCategoryForm').action =
                        `/data-management/contribution-category/${contribution_category_id}`;

                    // Open the modal
                    darkOverlay2.classList.remove('opacity-0', 'invisible');
                    darkOverlay2.classList.add('opacity-100');
                    document.getElementById('editContributionCategoryModal').classList.remove('opacity-0', 'invisible',
                        '-translate-y-5');
                }

                // Close edit contribution category modal
                function closeEditModal() {
                    darkOverlay2.classList.add('opacity-0', 'invisible');
                    darkOverlay2.classList.remove('opacity-100');
                    document.getElementById('editContributionCategoryModal').classList.add('opacity-0', 'invisible',
                        '-translate-y-5');

                    // Reset validation messages
                    document.querySelectorAll("#editContributionCategoryModal p.text-red-500").forEach(el => el.remove());
                    document.querySelectorAll("#editContributionCategoryModal input").forEach(el => el.classList.remove(
                        "border-red-500"));

                    // Clear input fields
                    document.getElementById("editContributionCategoryId").value = "";
                    document.getElementById("editContributionCategory").value = "";
                }
            </script>
        </div>

        <!-- Dark Overlay -->
        <div id="darkOverlay2"
            class="fixed inset-0 bg-black bg-opacity-50 opacity-0 invisible  z-40 transition-opacity duration-300">
        </div>

        <!-- JavaScript for Sidebar Toggle -->
        <script>
            document.getElementById('sidebarToggle').addEventListener('click', function() {
                document.getElementById('sidebar').classList.toggle('translate-x-full');
            });
        </script>
</body>

</html>
