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

            <!-- Edit User Data Screen -->
            <div class="m-5 p-8 bg-white shadow-lg rounded-lg mt-8">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h1 class="text-3xl font-bold mb-1">Edit</h1>
                        <h2 class="text-3xl font-bold">User Data</h2>
                    </div>
                    @if ($user->status == 1)
                        <span class="px-10 py-1 rounded-lg bg-[#CAF4E0] text-green-800">Active</span>
                    @else
                        <span class="px-10 py-1 rounded-lg bg-[#FAAFBD] text-red-800">Inactive</span>
                    @endif
                </div>

                <div class="flex flex-col sm:flex-row gap-8">
                    {{-- Profile --}}
                    @if (Auth::check())
                        @if ($user->profile_image)
                            @php
                                $publicPath = 'profile_images/' . $user->profile_image;
                                $storagePath = 'storage/profile_images/' . $user->profile_image;
                            @endphp

                            @if (file_exists(public_path($publicPath)))
                                <img id="profilePreview"
                                    class="m-0 w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-2xl sm:text-3xl"
                                    src="{{ asset($publicPath) }}" alt="Profile">
                            @elseif (file_exists(public_path($storagePath)))
                                <img id="profilePreview"
                                    class="m-0 w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-2xl sm:text-3xl"
                                    src="{{ asset($storagePath) }}" alt="Profile">
                            @else
                                <p
                                    class="m-0 w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-2xl sm:text-3xl">
                                    {{ strtoupper($user->username[0]) }}
                                </p>
                            @endif
                        @else
                            <p
                                class="m-0 w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-2xl sm:text-3xl">
                                {{ strtoupper($user->username[0]) }}
                            </p>
                        @endif
                    @else
                        <div class="w-24 h-24 select-none">
                            <img src="{{ asset('images/guest.jpg') }}" alt="Guest Profile"
                                class="w-full h-full rounded-full object-cover">
                        </div>
                    @endif

                    <form action="{{ route('admin.update-user-data', $user->user_id) }}" class="space-y-6 flex-1"
                        method="POST">
                        @csrf

                        <h3 class="text-2xl font-bold mb-6">Personal Information</h3>

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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label class="block text-sm font-medium mb-2">First Name</label>
                                <input type="text" name="first_name"
                                    value="{{ old('first_name', $user->first_name) }}"
                                    class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10">
                                @error('first_name')
                                    <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="relative">
                                <label class="block text-sm font-medium mb-2">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $user->last_name) }}"
                                    class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10">
                                @error('last_name')
                                    <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative">
                                <label class="block text-sm font-medium mb-2">User Name</label>
                                <input type="text" name="username" value="{{ old('username', $user->username) }}"
                                    class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10">
                                @error('username')
                                    <p class="absolute left-2 -bottom-2 bg-white text-red-500 text-sm">{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Email</label>
                                <input type="email" value="{{ $user->email }}"
                                    class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10"
                                    disabled>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-2">Password</label>
                            <input type="password" value="********" disabled
                                class="w-full p-3 rounded-md border border-gray-200 bg-gray-50">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2">Role</label>
                                <div class="relative">
                                    <select
                                        class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10"
                                        name="role_id">
                                        <option value="">Choose Role</option>
                                        @if ($roles->isEmpty())
                                            <option disabled>No data found</option>
                                        @else
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->role_id }}"
                                                    {{ $role->role_id == optional($user->role)->role_id ? 'selected' : '' }}>
                                                    {{ $role->role }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Faculty</label>
                                <div class="relative">
                                    <select
                                        class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10"
                                        name="faculty_id">
                                        <option value="">Choose Faculty</option>
                                        @if ($faculties->isEmpty())
                                            <option disabled>No data found</option>
                                        @else
                                            @foreach ($faculties as $faculty)
                                                <option value="{{ $faculty->faculty_id }}"
                                                    {{ $faculty->faculty_id == optional($user->faculty)->faculty_id ? 'selected' : '' }}>
                                                    {{ $faculty->faculty }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium mb-2">Status</label>
                                <div class="relative">
                                    <select
                                        class="mt-1 w-full px-4 py-2 border border-slate-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-400 focus:outline-none pr-10"
                                        name="status">
                                        <option value="" disabled>Choose Status</option>
                                        <option value="1"
                                            {{ isset($user) && $user->status == 1 ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="0"
                                            {{ isset($user) && $user->status == 0 ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-end mt-8 gap-4 select-none">
                            <a href="javascript:history.back()"
                                class="px-8 py-2.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800 inline-block">
                                Back
                            </a>
                            <button type="submit"
                                class="px-8 py-2.5 bg-gray-900 text-white rounded-lg hover:bg-gray-800">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Sidebar Toggle -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>

</html>
