<x-app-layout>
    <div class="min-h-screen bg-[#5A7BAF]">
        <!-- Hero Section -->
        <div class="flex flex-col items-center justify-center px-4 py-20 text-center text-white">
            <h1 class="mb-4 text-2xl md:text-4xl font-bold">All Contributions</h1>
            <p class="mb-8 max-w-2xl text-sm md:text-lg text-gray-200">
                Explore the latest contributions from researchers, students and industry experts
            </p>

            <form method="GET" action="{{ route('contributions') }}" class="relative w-full max-w-2xl">
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search contributions..."
                        class="w-full rounded-lg bg-white py-3 pl-12 pr-4 text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <input type="hidden" name="contribution_category"
                    value="{{ request('contribution_category', 'all') }}">
            </form>
        </div>

        <div class="bg-gray-50 px-4 py-12 md:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <div class="grid gap-8 md:grid-cols-[250px,1fr]">
                    <!-- Filters Sidebar -->
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <div class="sticky top-20 space-y-6">
                            <h2 class="mb-6 text-lg font-semibold">Filters</h2>

                            <form method="GET" action="{{ route('contributions') }}">
                                <!-- Categories -->
                                <h3 class="mt-4 mb-3 text-sm font-medium">Categories</h3>
                                <div class="space-y-2">
                                    <label class="flex items-center">
                                        <input type="radio" name="contribution_category" value="all"
                                            class="h-4 w-4 border-gray-300"
                                            {{ request('contribution_category', 'all') == 'all' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm">All Categories</span>
                                    </label>

                                    @php
                                        $otherCategory = null;
                                    @endphp

                                    @foreach ($contribution_categories as $contribution_category)
                                        @if (strtolower($contribution_category->contribution_category) === 'others')
                                            @php $otherCategory = $contribution_category; @endphp
                                        @else
                                            <label class="flex items-center">
                                                <input type="radio" name="contribution_category"
                                                    value="{{ $contribution_category->contribution_category_id }}"
                                                    class="h-4 w-4 border-gray-300"
                                                    {{ request('contribution_category') == $contribution_category->contribution_category_id ? 'checked' : '' }}>
                                                <span
                                                    class="ml-2 text-sm">{{ $contribution_category->contribution_category }}</span>
                                            </label>
                                        @endif
                                    @endforeach

                                    @if ($otherCategory)
                                        <label class="flex items-center">
                                            <input type="radio" name="contribution_category"
                                                value="{{ $otherCategory->contribution_category_id }}"
                                                class="h-4 w-4 border-gray-300"
                                                {{ request('contribution_category') == $otherCategory->contribution_category_id ? 'checked' : '' }}>
                                            <span
                                                class="ml-2 text-sm">{{ $otherCategory->contribution_category }}</span>
                                        </label>
                                    @endif
                                </div>

                                <!-- Apply Filters Button -->
                                <button type="submit"
                                    class="mt-4 w-full rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700 select-none">
                                    Apply Filters
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Contributions Grid -->
                    <div>
                        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @if ($contributions->count() > 0)
                                @foreach ($contributions as $contribution)
                                    <a href="{{ route('student.contribution-detail', $contribution) }}"
                                        class="block overflow-hidden rounded-lg bg-white shadow-sm group">
                                        <div class="relative h-56 w-full overflow-hidden">
                                            @if ($contribution->contribution_cover)
                                                <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                                    alt="{{ $contribution->contribution_title }}"
                                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105 select-none">
                                            @else
                                                <div class="flex h-full w-full items-center justify-center">
                                                    <div class="w-24 select-none">
                                                        <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                                            class="w-full h-full object-cover">
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <h3 class="mb-2 text-lg font-semibold text-gray-800">
                                                {{ $contribution->contribution_title }}
                                            </h3>
                                            <p class="mb-3 text-sm text-gray-600 line-clamp-2">
                                                {{ $contribution->contribution_description }}
                                            </p>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <span class="mr-2">by {{ $contribution->user->username }}</span>
                                                <span
                                                    class="ml-auto text-xs text-gray-400">{{ $contribution->published_date->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @else
                                <div class="col-span-3 flex items-center justify-center py-32">
                                    <p class="text-lg text-gray-500">No contributions found.</p>
                                </div>
                            @endif
                        </div>

                        <!-- Pagination -->
                        @if ($contributions->isNotEmpty())
                            <div class="flex justify-end items-center gap-2 mt-6">
                                {{ $contributions->appends(request()->query())->links('pagination::tailwind') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
