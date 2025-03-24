<x-app-layout>
    <!-- Hero Section -->
    <div class="bg-[#5A7BAF] text-white text-center py-16 px-4">
        <h1 class="text-2xl md:text-4xl max-w-md mx-auto font-semibold">Astrornix University</h1>
        <p class="text-sm md:text-lg mt-2 opacity-80">
            Discover the latest research and contributions from our faculty members.
        </p>
    </div>

    <!-- About the Faculty Section -->
    <div class="container mx-auto px-4 sm:px-6 md:px-12 py-12">
        <div class="flex flex-col md:flex-row items-center gap-6 md:gap-12">
            <!-- Text Content -->
            <div class="w-full md:w-1/2">
                <h2 class="text-lg md:text-2xl font-semibold text-black mb-3">About the Faculty</h2>
                <p class="text-sm md:text-base text-gray-700 leading-relaxed">
                    Lorem, ipsum dolor sit amet consectetur adipisicing elit. Excepturi, hic! Ex dolores quibusdam
                    expedita quasi asperiores consequuntur dolorem, pariatur deserunt aliquam, accusantium alias
                    laboriosam error ratione aut dignissimos consectetur soluta!
                </p>
            </div>

            <!-- Image -->
            <div class="w-full md:w-1/2 select-none">
                <img src="{{ asset('images/f1.png') }}" alt="Faculty Research"
                    class="w-full sm:w-3/4 h-auto object-cover mx-auto">
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 md:px-12 text-center py-0 md:py-12">
        <!-- Faculty Filter Dropdown Section -->
        <div class="flex mb-6 gap-4 flex-wrap">
            <!-- Search Form -->
            <form id="search-form" class="w-full sm:w-1/4" method="GET" action="{{ route('faculty') }}">
                <h2 class="text-lg md:text-xl font-semibold text-left">Search</h2>
                <input type="text" name="search" placeholder="Search contributions..."
                    class="mt-2 px-4 py-2 border border-gray-300 rounded-md w-full" value="{{ request('search') }}">
            </form>

            <!-- Filter by Faculty -->
            <form id="faculty-form" class="w-full sm:w-1/4" method="GET" action="{{ route('faculty') }}">
                <h2 class="text-lg md:text-xl font-semibold text-left">Filter by Faculty</h2>
                <select id="faculty_filter" name="faculty_filter"
                    class="mt-2 px-4 py-2 border border-gray-300 rounded-md w-full" onchange="this.form.submit()">
                    <option value="all" {{ request('faculty_filter', 'all') == 'all' ? 'selected' : '' }}>All Faculty
                    </option>
                    @foreach ($faculties as $faculty)
                        <option value="{{ $faculty->faculty_id }}"
                            {{ request('faculty_filter') == $faculty->faculty_id ? 'selected' : '' }}>
                            {{ $faculty->faculty }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5" id="contributions-list">
            @if ($contributions->count() > 0)
                @foreach ($contributions as $contribution)
                    <a href="{{ route('student.contribution-detail', $contribution) }}"
                        class="flex flex-col items-center group">
                        @if ($contribution->contribution_cover)
                            <!-- Display the contribution cover image if it exists -->
                            <div class="w-full select-none">
                                <img src="{{ asset('storage/contribution-images/' . $contribution->contribution_cover) }}"
                                    alt="{{ $contribution->contribution_title }}" class="w-full h-auto object-cover">
                            </div>
                        @else
                            <!-- Display the default logo image if contribution_cover is null -->
                            <div class="flex h-60 sm:h-[306px] w-full items-center justify-center bg-white">
                                <div class="w-24 select-none">
                                    <img src="{{ asset('images/logo.png') }}" alt="Logo"
                                        class="w-full h-full object-cover">
                                </div>
                            </div>
                        @endif
                        <div class="text-start w-full mt-3">
                            <p class="text-md md:text-lg font-semibold text-black group-hover:underline">
                                {{ $contribution->contribution_title }} →
                            </p>
                            <p class="text-sm md:text-md text-gray-700 mt-1 line-clamp-2">
                                {{ $contribution->contribution_description }}
                            </p>
                            <p class="text-sm text-gray-500 mt-1">by
                                <strong>{{ $contribution->user->first_name }}</strong>
                            </p>
                        </div>
                    </a>
                @endforeach
            @else
                <div class="col-span-3 flex items-center justify-center py-32">
                    <p class="text-lg text-gray-500">No contributions found.</p>
                </div>
            @endif
        </div>

        <!-- Pagination Links -->
        <div class="mt-4">
            {{ $contributions->appends(request()->query())->links() }}
        </div>
    </div>
</x-app-layout>

<script>
    document.getElementById('faculty_filter').addEventListener('change', function() {
        const facultyId = this.value;
        const form = document.getElementById('faculty-form');

        fetch(`${form.action}?faculty_filter=${facultyId}`)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                document.getElementById('contributions-list').innerHTML =
                    doc.getElementById('contributions-list').innerHTML;
            });
    });
</script>
