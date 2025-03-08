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
            <!-- here to add content -->
            <main class="flex-1 bg-[#F1F5F9] p-4 sm:p-5">
                <div class="space-y-2 mb-4">
                    <div class="p-8 bg-white  shadow-lg">
                        <!-- Header -->
                        <div
                            class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 sm:gap-0 mb-4">
                            <h1 class="text-2xl font-bold">List of Academic Years
                                </h1>

                            <button onclick="openModal()"
                                class="px-8 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Add Academic Year
                            </button>
                        </div>
                        <h2 class=" text-lg font-semibold text-gray-400 mb-4">
                               Total - {{ $academic_years->count() }}
                                </h2>

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
                        <div class="flex flex-col md:flex-row gap-4 md:gap-0 justify-between mb-8">
                            <div class="relative max-w-[400px]">
                                <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8" />
                                    <path d="m21 21-4.3-4.3" />
                                </svg>
                                <form method="GET" action="{{ route('admin.academic-years.search') }}">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search..."
                                        class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                                </form>
                            </div>

                            <div class="flex gap-4">
                                <!-- sort select-->
                                <form method="GET" action="{{ route('academic-years.index') }}">
                                    <select name="sort" onchange="this.form.submit()"
                                        class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest
                                            First</option>
                                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest
                                            First</option>
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
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Academic
                                                Year</th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Added Date
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Updated
                                                Date
                                            </th>
                                            <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Action
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @if ($academic_years->isNotEmpty())
                                            @foreach ($academic_years as $academic_year)
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 text-gray-600">
                                                        {{ $academic_year->academic_year }}
                                                    </td>
                                                    <td class="px-6 py-4 text-gray-600">
                                                        {{ optional($academic_year->created_at)->format('M d, Y') ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4 text-gray-600">
                                                        {{ optional($academic_year->updated_at)->format('M d, Y') ?? 'N/A' }}
                                                    </td>
                                                    <td class="px-6 py-4">
                                                        <button
                                                            onclick="openEditModal('{{ $academic_year->academic_year_id }}', '{{ $academic_year->academic_year }}')"
                                                            class="text-blue-600 hover:text-blue-700">
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path
                                                                    d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                                <path d="m15 5 4 4" />
                                                            </svg>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-6 py-24 text-gray-600 text-center" colspan="5">
                                                    No academic years found.
                                                </td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Pagination -->
                        @if ($academic_years->isNotEmpty())
                            <div class="flex justify-end items-center gap-2 mt-6">
                                {{ $academic_years->appends(request()->query())->links('pagination::tailwind') }}
                            </div>
                        @endif
                    </div>

                    <!-- Add New Academic Year Modal -->
                    <div class="flex justify-center items-center mt-24 w-full">
                        <!-- Modal -->
                        <div id="academicYearModal"
                            class="fixed inset-0 z-50 flex items-center justify-center opacity-0 invisible p-2 -translate-y-5 transition-all duration-300">
                            <div class="max-w-md w-full bg-white p-8 rounded-md shadow-lg relative">
                                <button onclick="closeModal()" class="absolute top-2 right-2 text-black">
                                    ✖
                                </button>

                                <h1 class="text-2xl font-bold text-center mb-6">
                                    Add <span class="border-b-2 border-blue-600">New</span> Academic Year
                                </h1>

                                <form action="{{ route('academic-years.store') }}" method="POST">
                                    @csrf

                                    <!-- Academic Year Input -->
                                    <div class="mb-4 relative">
                                        <label class="block text-sm font-medium mb-2">Academic Year :</label>
                                        <input type="text" name="academic_year" value="{{ old('academic_year') }}"
                                            placeholder="Enter academic year..."
                                            class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg
                                            focus:outline-none focus:ring-2 focus:ring-blue-500 @error('academic_year') border-red-500 @enderror">

                                        @error('academic_year')
                                            <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                                                {{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Save Button -->
                                    <div class="flex justify-center">
                                        <button type="submit"
                                            class="px-12 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800">
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Academic Year Modal -->
                    <div id="editAcademicYearModal"
                        class="fixed inset-0 z-50 flex items-center justify-center opacity-0 invisible p-2 -translate-y-5 transition-all duration-300">
                        <div class="max-w-md w-full bg-white p-8 rounded-md shadow-lg relative">
                            <button onclick="closeEditModal()" class="absolute top-2 right-2 text-black">✖</button>

                            <h1 class="text-2xl font-bold text-center mb-6">
                                Edit <span class="border-b-2 border-blue-600">Academic Year</span>
                            </h1>

                            <form id="editAcademicYearForm" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Hidden ID Input -->
                                <input type="hidden" id="editAcademicYearId" name="academic_year_id">

                                <!-- Academic Year Input -->
                                <div class="mb-4 relative">
                                    <label class="block text-sm font-medium mb-2">Academic Year :</label>
                                    <input type="text" id="editAcademicYear" name="edit_academic_year"
                                        value="{{ old('edit_academic_year') }}" placeholder="Enter academic year..."
                                        class="w-full px-4 py-2.5 bg-gray-100 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @error('edit_academic_year')
                                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                                            {{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Save Button -->
                                <div class="flex justify-center">
                                    <button type="submit"
                                        class="px-12 py-2 bg-gray-900 text-white rounded-lg hover:bg-gray-800">
                                        Update
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900 py-4">Manage Intake & Closure Date</h1>

                    <div>
                        <!-- Intake -->
                        <div class="bg-white rounded-xl shadow-lg p-8 mb-10">
                            <h1 class="text-2xl md:text-xl font-bold text-gray-900 mb-8">Academic Year & Intake
                                Management</h1>

                            @if (session('intake_success'))
                                <div id="intake-success-message"
                                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 my-3 rounded relative"
                                    role="alert">
                                    <span class="block sm:inline">{{ session('intake_success') }}</span>
                                </div>

                                <script>
                                    setTimeout(() => {
                                        document.getElementById('intake-success-message').style.display = 'none';
                                    }, 3000);
                                </script>
                            @endif

                            <form action="{{ route('admin.intakes') }}" method="POST"
                                class="grid md:grid-cols-2 gap-x-8 gap-y-6">
                                @csrf

                                <div class="space-y-2 relative">
                                    <label class="block text-start font-bold text-gray-900">Academic Year</label>
                                    <select name="academic_year_select"
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 text-gray-500 focus:ring-2 focus:ring-gray-200 @error('academic_year_select') border-red-500 @enderror">
                                        <option value=""
                                            {{ old('academic_year_select') == '' ? 'selected' : '' }}>Select academic
                                            year . . .</option>
                                        @if ($academic_years->isEmpty())
                                            <option disabled>No data found</option>
                                        @else
                                            @foreach ($academic_years as $academic_year)
                                                <option value="{{ $academic_year->academic_year_id }}"
                                                    {{ old('academic_year_select') == $academic_year->academic_year_id ? 'selected' : '' }}>
                                                    {{ $academic_year->academic_year }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('academic_year_select')
                                        <p class="text-red-500 text-sm mt-1">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <div class="space-y-2 relative">
                                    <label class="block text-start font-bold text-gray-900">Intake</label>
                                    <input type="text" name="intake" value="{{ old('intake') }}"
                                        placeholder="Enter intake . . ."
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 text-gray-500 focus:ring-2 focus:ring-gray-200 @error('intake') border-red-500 @enderror">
                                    @error('intake')
                                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                                            {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2 relative">
                                    <label class="block text-start font-bold text-gray-900">Closure Date</label>
                                    <input type="date" id="closure_date" name="closure_date"
                                        value="{{ old('closure_date') }}" placeholder="Enter closure date . . ."
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 text-gray-500 focus:ring-2 focus:ring-gray-200 @error('closure_date') border-red-500 @enderror">
                                    @error('closure_date')
                                        <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm mt-1">
                                            {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="space-y-2">
                                    <label class="block text-start font-bold text-gray-900">Final Closure Date</label>
                                    <input type="date" id="final_closure_date" disabled name="final_closure_date"
                                        value="{{ old('final_closure_date') }}"
                                        placeholder="Enter final closure date . . ."
                                        class="w-full px-4 py-3 rounded-lg bg-gray-100 border border-gray-300 text-gray-500 focus:ring-2 focus:ring-gray-200">
                                </div>

                                <div class="md:col-span-2 flex justify-end mt-4">
                                    <button type="submit"
                                        class="px-8 py-3 bg-gray-900 text-white rounded-lg hover:bg-gray-800 transition-colors">
                                        Submit
                                    </button>
                                </div>
                            </form>

                            <script>
                                document.getElementById('closure_date').addEventListener('change', function() {
                                    const closureDate = this.value; // Get the selected closure date
                                    if (closureDate) {
                                        // Parse the closure date and add 14 days
                                        const finalClosureDate = new Date(closureDate);
                                        finalClosureDate.setDate(finalClosureDate.getDate() + 14);

                                        // Format the final closure date as YYYY-MM-DD
                                        const formattedDate = finalClosureDate.toISOString().split('T')[0];

                                        // Set the value of the final_closure_date field
                                        document.getElementById('final_closure_date').value = formattedDate;
                                    } else {
                                        // Clear the final_closure_date field if no closure date is selected
                                        document.getElementById('final_closure_date').value = '';
                                    }
                                });
                            </script>
                        </div>
                        <div class="p-8 bg-white shadow-lg">
                            <!-- Header -->
                            <h1 class="text-2xl font-bold mb-4">List of Overall Information
                                </h1>

                                <h2 class=" text-lg font-semibold text-gray-400 mb-4">
                                   Total - {{ $intakes->count() }}</h2>

                            <!-- Search and Filters -->
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-0 justify-between mb-8">
                                <div class="relative max-w-[400px]">
                                    <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                    <form method="GET" action="{{ route('admin.intakes.search') }}">
    <div class="relative w-full md:w-[300px] lg:w-[400px]">
        <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
            stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round">
            <circle cx="11" cy="11" r="8" />
            <path d="m21 21-4.3-4.3" />
        </svg>
        <input type="text" name="academic_year" value="{{ request('academic_year') }}"
            placeholder="Search by Academic Year..."
            class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
    </div>
</form>

                                </div>

                                <div class="flex gap-4">
                                    <!-- Filter Dropdown -->
                                    <form method="GET" action="{{ route('academic-years.index') }}">
    <select name="sort_final_closure_date" onchange="this.form.submit()"
        class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
        <option value="asc" {{ request('sort_final_closure_date') == 'asc' ? 'selected' : '' }}>
            Earlier Final Closure Date
        </option>
        <option value="desc" {{ request('sort_final_closure_date') == 'desc' ? 'selected' : '' }}>
            Later Final Closure Date
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
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Academic
                                                    Year</th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Intake
                                                </th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Submission
                                                    Closure Date</th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Final
                                                    Closure Date</th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Status
                                                </th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @if ($intakes->isNotEmpty())
                                                @foreach ($intakes as $intake)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-6 py-4 text-gray-600">
                                                            {{ $intake->academicYear->academic_year }}
                                                        </td>
                                                        <td class="px-6 py-4 text-gray-600">
                                                            {{ $intake->intake }}
                                                        </td>
                                                        <td class="px-6 py-4 text-gray-600">
                                                            {{ $intake->closure_date ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-6 py-4 text-gray-600">
                                                            {{ $intake->final_closure_date ?? 'N/A' }}
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            @if ($intake->status == 'active')
                                                                <span
                                                                    class="px-3 py-1 rounded-full text-sm bg-[#CAF4E0] text-green-800">Active</span>
                                                            @else
                                                                <span
                                                                    class="px-3 py-1 rounded-full text-sm bg-[#FAAFBD] text-red-800">Inactive</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            {{-- <button
                                                            onclick="openEditModal('{{ $intake->intake_id }}', '{{ $intake->intake }}')"
                                                            class="text-blue-600 hover:text-blue-700">
                                                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path
                                                                    d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z" />
                                                                <path d="m15 5 4 4" />
                                                            </svg>
                                                        </button> --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-24 text-gray-600 text-center" colspan="5">
                                                        No information found.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <!-- Pagination -->
                            @if ($intakes->isNotEmpty())
                                <div class="flex justify-end items-center gap-2 mt-6">
                                    {{ $intakes->links('pagination::tailwind') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Dark Overlay -->
    <div id="darkOverlay2"
        class="fixed inset-0 bg-black bg-opacity-50 opacity-0 invisible  z-40 transition-opacity duration-300">
    </div>

    <!-- JavaScript for Modal -->
    <script>
        // Open academic year modal
        function openModal() {
            darkOverlay2.classList.remove('opacity-0', 'invisible');
            darkOverlay2.classList.add('opacity-100');
            document.getElementById('academicYearModal').classList.remove('opacity-0', 'invisible', '-translate-y-5');
        }

        // Close academic year modal
        function closeModal() {
            darkOverlay2.classList.add('opacity-0', 'invisible');
            darkOverlay2.classList.remove('opacity-100');
            document.getElementById('academicYearModal').classList.add('opacity-0', 'invisible', '-translate-y-5');
        }

        // Keep modal open if validation errors exist
        window.onload = function() {
            @if ($errors->any())
                openModal();
            @endif
        };

        // Open edit academic year modal
        function openEditModal(academicYearId, academicYear) {
            // Populate modal fields with selected academic year's data
            document.getElementById('editAcademicYearId').value = academicYearId;
            document.getElementById('editAcademicYear').value = academicYear;

            // Set form action dynamically
            document.getElementById('editAcademicYearForm').action = `/admin/academic-years/${academicYearId}`;

            // Open modal
            darkOverlay2.classList.remove('opacity-0', 'invisible');
            darkOverlay2.classList.add('opacity-100');
            document.getElementById('editAcademicYearModal').classList.remove('opacity-0', 'invisible', '-translate-y-5');
        }

        // Close edit academic year modal
        function closeEditModal() {
            darkOverlay2.classList.add('opacity-0', 'invisible');
            darkOverlay2.classList.remove('opacity-100');
            document.getElementById('editAcademicYearModal').classList.add('opacity-0', 'invisible', '-translate-y-5');
        }
    </script>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('translate-x-full');
        });
    </script>


</body>

</html>
