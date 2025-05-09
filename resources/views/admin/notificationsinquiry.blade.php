<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Load Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.10.3/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.css"
        integrity="sha512-kJlvECunwXftkPwyvHbclArO8wszgBGisiLeuDFwNM8ws+wKIw0sv1os3ClWZOcrEB2eRXULYUsm8OVRGJKwGA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            <main class="flex-1 overflow-y-auto bg-[#F1F5F9] p-4 sm:p-5">

                <div class="space-y-4 mb-4">
                    <h1 class=" text-xl sm:text-2xl font-bold text-gray-900">System Notifications & Alerts</h1>
                    <h2 class="text-sm sm:text-lg text-gray-500">Summary of Alerts</h2>
                    <div>
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-10">
                            <!-- Total Students Card -->
                            <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] rounded-lg p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                    <img class="w-5 h-5" src="{{ asset('images/totalstudents.png') }}" alt="">
                                </div>

                                <!-- Stats Container with Flexbox -->
                                <div class="flex items-end justify-between">
                                    <!-- Numbers -->
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold">{{ $total_students->count() }}</h2>
                                        <p class="text-xl text-gray-400">Total Students</p>
                                    </div>

                                    <!-- Percentage -->
                                    <div class="flex items-center gap-1">
                                        @if ($student_percentage_change > 0)
                                            <span
                                                class="text-emerald-500 text-xl font-medium">{{ $student_percentage_change }}%
                                                ↑</span>
                                        @elseif ($student_percentage_change < 0)
                                            <span
                                                class="text-red-500 text-xl font-medium">{{ abs($student_percentage_change) }}%
                                                ↓</span>
                                        @else
                                            <span class="text-gray-500 text-xl font-medium">0%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!-- Total submissions Card -->
                            <div class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] rounded-lg p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                    <img class="w-5 h-5" src="{{ asset('images/totalsubmissions.png') }}"
                                        alt="">
                                </div>

                                <!-- Stats Container with Flexbox -->
                                <div class="flex items-end justify-between">
                                    <!-- Numbers -->
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold">{{ $inquiries_count->count() }}</h2>
                                        <p class="text-xl text-gray-400">New Inquiries</p>
                                    </div>
                                </div>
                            </div>
                            <!-- Total Pending Contributions Card -->
                            <div
                                class="bg-white shadow-[0px_14px_5px_-12px_#4353E1] rounded-lg col-span-0 sm:col-span-2 lg:col-span-1 p-6 w-full">
                                <!-- Avatar Circle -->
                                <div
                                    class="w-14 h-14 bg-[#A2A2A225] rounded-full flex items-center justify-center mb-6 select-none">
                                    <img class="w-5 h-5" src="{{ asset('images/totaluser.png') }}" alt="">
                                </div>

                                <!-- Stats Container with Flexbox -->
                                <div class="flex items-end justify-between">
                                    <!-- Numbers -->
                                    <div class="space-y-1">
                                        <h2 class="text-3xl font-bold">{{ $unassigned_users->count() }}</h2>
                                        <p class="text-xl text-gray-400">Unassigned Users</p>
                                    </div>

                                    <!-- Percentage -->
                                    <div class="flex items-center gap-1">
                                        @if ($unassigned_user_percentage_change > 0)
                                            <span
                                                class="text-emerald-500 text-xl font-medium">{{ $unassigned_user_percentage_change }}%
                                                ↑</span>
                                        @elseif ($unassigned_user_percentage_change < 0)
                                            <span
                                                class="text-red-500 text-xl font-medium">{{ abs($unassigned_user_percentage_change) }}%
                                                ↓</span>
                                        @else
                                            <span class="text-gray-500 text-xl font-medium">0%</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                        <h2 class="text-sm sm:text-lg text-gray-500 mb-10">All System Notifications</h2>
                        <div class="p-8 bg-white  shadow-lg">
                            <!-- Header -->
                            <h1 class="text-2xl font-bold mb-6">List of Notifications</h1>
                            <h2 class=" text-lg font-semibold text-gray-400 mb-4">
                                Total - {{ $inquiries->count() }}
                            </h2>

                            <!-- Tabs -->
                            <div class="flex gap-8 border-b mb-6">
                                <a href="{{ route('admin.notifications.inquiry') }}"
                                    class="px-1 py-4  hover:text-gray-900 text-[#4353E1] border-b-4 border-[#4353E1]">
                                    Inquiry
                                </a>
                                <a href="{{ route('admin.notifications.password-reset') }}"
                                    class="px-1 py-4 text-gray-600 hover:text-gray-900">
                                    Password Reset
                                </a>
                                <a href="{{ route('admin.notifications.unregister-user') }}"
                                    class="px-1 py-4 text-gray-600 hover:text-gray-900">
                                    Unassigned User
                                </a>
                            </div>


                            <form method="GET" action="{{ route('admin.notifications.inquiry') }}">
                                <div class="flex flex-col md:flex-row gap-4 md:gap-0 justify-between mb-8">
                                    <!-- Search Input -->
                                    <div class="relative max-w-[400px]">
                                        <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8" />
                                            <path d="m21 21-4.3-4.3" />
                                        </svg>
                                        <input type="text" name="search" value="{{ request('search') }}"
                                            placeholder="Search..."
                                            class="w-full pl-12 pr-4 py-2.5 rounded-lg bg-gray-100 border border-gray-300 focus:ring-2 focus:ring-blue-500" />
                                    </div>

                                    <div class="flex flex-wrap gap-4">
                                        <!-- Filter Option -->
                                        <select name="filter" onchange="this.form.submit()"
                                            class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                            <option value="">All</option>
                                            <option value="Pending"
                                                {{ request('filter') == 'Pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option value="Resolved"
                                                {{ request('filter') == 'Resolved' ? 'selected' : '' }}>
                                                Resolved
                                            </option>
                                        </select>

                                        <!-- Sort Option -->
                                        <select name="sort" onchange="this.form.submit()"
                                            class="pl-3 pr-10 py-2.5 rounded-lg bg-[#F1F5F9] border border-gray-300">
                                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>
                                                Newest
                                            </option>
                                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>
                                                Oldest
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </form>

                            <!-- Table -->
                            <div class="bg-white rounded-lg overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full">
                                        <thead class="bg-[#F9F8F8]">
                                            <tr>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">User
                                                </th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Message</th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">Date
                                                    & Time</th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Status</th>
                                                <th class="text-left px-6 py-4 text-sm font-medium text-gray-500">
                                                    Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100">
                                            @if ($inquiries->isNotEmpty())
                                                @foreach ($inquiries as $inquiry)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-6 py-4">
                                                            <div class="flex items-center gap-3">
                                                                <p
                                                                    class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base">
                                                                    {{ strtoupper($inquiry->user->username[0]) }}
                                                                </p>
                                                                <div>
                                                                    <div class="font-medium">
                                                                        {{ $inquiry->user->first_name . ' ' . $inquiry->user->last_name }}
                                                                    </div>
                                                                    <div class="text-sm text-gray-500">
                                                                        {{ $inquiry->user->email }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-6 py-4 text-gray-600">
                                                            {{ Str::limit($inquiry->inquiry, 50, '...') }}
                                                        </td>
                                                        <td class="px-6 py-4 text-gray-600">
                                                            {{ optional($inquiry->created_at)->format('M d, Y') ?? 'N/A' }}
                                                            <p class="text-gray-400">
                                                                {{ optional($inquiry->created_at)->format('h:i A') }}
                                                            </p>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            @if ($inquiry->inquiry_status == 'Pending')
                                                                <span
                                                                    class="px-3 py-1 rounded-full text-sm bg-[#FAAFBD] text-red-800">Pending</span>
                                                            @else
                                                                <span
                                                                    class="px-3 py-1 rounded-full text-sm bg-[#CAF4E0] text-green-800">Resolved</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 text-[#2F64AA] font-light">
                                                            <button type="button"
                                                                class="hover:underline view-inquiry-btn"
                                                                data-id="{{ $inquiry->inquiry_id }}"
                                                                data-user="{{ $inquiry->user->first_name }} {{ $inquiry->user->last_name }}"
                                                                data-email="{{ $inquiry->user->email }}"
                                                                data-priority="{{ $inquiry->priority_level }}"
                                                                data-inquiry="{{ $inquiry->inquiry }}"
                                                                data-date="{{ $inquiry->created_at->format('M d, Y h:i A') }}"
                                                                data-status="{{ $inquiry->inquiry_status }}">
                                                                <i class="ri-eye-line text-xl"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-24 text-gray-600 text-center" colspan="5">
                                                        No inquiries found.
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>

                                    <!-- Pagination -->
                                    @if ($inquiries->isNotEmpty())
                                        <div class="flex justify-end items-center gap-2 mt-6">
                                            {{ $inquiries->appends(request()->query())->links('pagination::tailwind') }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Dark Overlay for Inquiry Modal -->
                            <div id="darkOverlay"
                                class="fixed inset-0 z-40 bg-black bg-opacity-50 opacity-0 invisible transition-opacity duration-300">
                            </div>

                            <!-- Modal -->
                            <div id="inquiryModal"
                                class="fixed inset-0 z-50 flex items-center justify-center opacity-0 invisible p-2 -translate-y-5 transition-all duration-300">
                                <div class="max-w-xl w-full bg-white p-8 rounded-md shadow-lg relative">
                                    <!-- Close Button -->
                                    <button onclick="closeInquiryModal()" class="absolute top-2 right-2 text-black">
                                        ✖
                                    </button>

                                    <!-- Modal Title -->
                                    <h1 class="text-2xl font-bold text-center mb-6">
                                        Inquiry <span class="border-b-2 border-blue-600">Detail</span>
                                    </h1>

                                    <!-- Hidden Input for Inquiry ID -->
                                    <input type="hidden" id="inquiry_id" name="id" value="">

                                    <!-- Inquiry Details -->
                                    <div class="space-y-4 max-h-[60vh] overflow-y-auto">
                                        <div class="flex justify-between items-center">
                                            <!-- Sender Name -->
                                            <p class="text-sm text-gray-500">
                                                <span class="text-gray-800 font-semibold text-base">Sender:</span>
                                                <span id="modalUser" class="block mt-1 text-gray-800"></span>
                                                <span id="modalEmail" class="block mt-1"></span>
                                            </p>
                                            <!-- Date & Time -->
                                            <p class="text-sm text-gray-500">
                                                <span class="text-gray-800 font-semibold text-base">Date & Time:</span>
                                                <span id="modalDate" class="block mt-1"></span>
                                            </p>
                                        </div>

                                        <!-- Priority Level -->
                                        <p class="text-sm text-gray-500">
                                            <span class="text-gray-800 font-semibold text-base">Priority Level:</span>
                                            <span id="modalPriorityLevel" class="block mt-1"></span>
                                        </p>

                                        <!-- Status -->
                                        <p class="text-sm text-gray-500">
                                            <span class="text-gray-800 font-semibold text-base">Status:</span>
                                            <span id="modalStatus" class="block mt-1"></span>
                                        </p>

                                        <!-- Message Content -->
                                        <div class="text-sm text-gray-500">
                                            <span class="text-gray-800 font-semibold text-base">Message Content:</span>
                                            <textarea id="modalInquiry" cols="30" rows="5" class="mt-1 w-full bg-gray-50 p-2 rounded-lg" disabled></textarea>
                                        </div>

                                        <!-- Response Input -->
                                        <div class="text-sm text-gray-500">
                                            <span class="text-gray-800 font-semibold text-base">Your Response:</span>
                                            <textarea id="responseText" name="response" cols="30" rows="5"
                                                class="mt-1 w-full bg-gray-50 p-2 rounded-lg border border-gray-300" required></textarea>
                                        </div>
                                    </div>

                                    <!-- Response Button -->
                                    <div class="flex justify-end mt-6">
                                        <!-- Form for Updating Inquiry -->
                                        <form id="updateInquiryForm" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" id="responseContent" name="response_content">
                                            <button type="button" id="closeButton" onclick="closeInquiryModal()"
                                                class="mr-2 px-6 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                                                Close
                                            </button>
                                            <button type="button" id="responseButton"
                                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                                Send Response
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <script>
                                // Get references to the dark overlay and inquiry modal
                                const darkOverlay = document.getElementById('darkOverlay');
                                const inquiryModal = document.getElementById('inquiryModal');
                                let currentResponseButton = null;

                                // Function to open the inquiry modal
                                function openInquiryModal(data) {
                                    // Populate modal content
                                    document.getElementById('inquiry_id').value = data.id;
                                    document.getElementById('modalUser').textContent = data.user;
                                    document.getElementById('modalEmail').textContent = data.email;
                                    document.getElementById('modalPriorityLevel').textContent = data.priority;
                                    document.getElementById('modalInquiry').textContent = data.inquiry;
                                    document.getElementById('modalDate').textContent = data.date;
                                    document.getElementById('modalStatus').textContent = data.status;
                                    document.getElementById('responseText').value = ''; // Clear previous response

                                    // Set the form action dynamically
                                    const updateForm = document.getElementById('updateInquiryForm');
                                    updateForm.action = `/admin/notifications/inquiry/${data.id}`;

                                    // Update the button based on inquiry status
                                    const responseButton = document.getElementById('responseButton');

                                    if (data.status === 'Resolved') {
                                        responseButton.textContent = 'Already Resolved';
                                        responseButton.classList.add('bg-gray-400', 'cursor-not-allowed');
                                        responseButton.disabled = true;
                                        document.getElementById('responseText').disabled = true;
                                    } else {
                                        responseButton.textContent = 'Send Response';
                                        responseButton.classList.remove('bg-gray-400', 'cursor-not-allowed');
                                        responseButton.classList.add('bg-blue-600', 'hover:bg-blue-700');
                                        responseButton.disabled = false;
                                        document.getElementById('responseText').disabled = false;
                                    }

                                    // Remove previous event listeners to avoid duplicates
                                    if (currentResponseButton) {
                                        currentResponseButton.replaceWith(currentResponseButton.cloneNode(true));
                                    }
                                    currentResponseButton = document.getElementById('responseButton');

                                    // Add new event listener
                                    currentResponseButton.addEventListener('click', async () => {
                                        const responseText = document.getElementById('responseText').value.trim();
                                        if (!responseText) {
                                            alert('Please enter your response before sending.');
                                            return;
                                        }

                                        // Store response in hidden field
                                        document.getElementById('responseContent').value = responseText;

                                        // Show loading state with spinner
                                        const originalButtonHTML = currentResponseButton.innerHTML;
                                        currentResponseButton.disabled = true;
                                        currentResponseButton.innerHTML = `
                                            <span class="inline-flex items-center">
                                                Sending...
                                                <svg class="animate-spin -mr-1 ml-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                </svg>
                                            </span>
                                        `;

                                        try {
                                            // Submit the form via AJAX
                                            const response = await fetch(updateForm.action, {
                                                method: 'POST',
                                                headers: {
                                                    'Content-Type': 'application/json',
                                                    'Accept': 'application/json',
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                    'X-HTTP-Method-Override': 'PUT'
                                                },
                                                body: JSON.stringify({
                                                    _method: 'PUT',
                                                    response_content: responseText
                                                })
                                            });

                                            const result = await response.json();

                                            if (result.success) {
                                                // Close modal on success
                                                closeInquiryModal();
                                                // Show success message or refresh the page
                                                window.location.reload();
                                            } else {
                                                alert(result.message || 'Failed to send response');
                                                currentResponseButton.disabled = false;
                                                currentResponseButton.innerHTML = originalButtonHTML;
                                            }
                                        } catch (error) {
                                            console.error('Error:', error);
                                            alert('An error occurred while sending the response');
                                            currentResponseButton.disabled = false;
                                            currentResponseButton.innerHTML = originalButtonHTML;
                                        }
                                    });

                                    // Show the modal
                                    darkOverlay.classList.remove('opacity-0', 'invisible');
                                    darkOverlay.classList.add('opacity-100');
                                    inquiryModal.classList.remove('opacity-0', 'invisible', '-translate-y-5');
                                    inquiryModal.classList.add('opacity-100', 'visible', 'translate-y-0');
                                }

                                // Function to close the inquiry modal
                                function closeInquiryModal() {
                                    // Hide the dark overlay and modal
                                    darkOverlay.classList.add('opacity-0', 'invisible');
                                    darkOverlay.classList.remove('opacity-100');
                                    inquiryModal.classList.add('opacity-0', 'invisible', '-translate-y-5');
                                    inquiryModal.classList.remove('opacity-100', 'visible', 'translate-y-0');
                                }

                                // Add event listeners to all view buttons
                                document.addEventListener('DOMContentLoaded', function() {
                                    const viewButtons = document.querySelectorAll('.view-inquiry-btn');

                                    viewButtons.forEach(button => {
                                        button.addEventListener('click', function() {
                                            const data = {
                                                id: this.getAttribute('data-id'),
                                                user: this.getAttribute('data-user'),
                                                email: this.getAttribute('data-email'),
                                                priority: this.getAttribute('data-priority'),
                                                inquiry: this.getAttribute('data-inquiry'),
                                                date: this.getAttribute('data-date'),
                                                status: this.getAttribute('data-status')
                                            };
                                            openInquiryModal(data);
                                        });
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('translate-x-full');
        });
    </script>
</body>

</html>
