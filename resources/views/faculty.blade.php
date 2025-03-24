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
        <div class="flex justify-start mb-6">
            <form id="faculty-form" class="w-full sm:w-1/4">
                <h2 class="text-lg md:text-xl font-semibold text-left">Filter by Faculty</h2>
                <select id="faculty_filter" class="mt-2 px-4 py-2 border border-gray-300 rounded-md w-full">
                    <option value="all">All Faculty</option>
                    @foreach ($faculties as $faculty)
                    <option value="{{ $faculty->faculty_id }}">{{ $faculty->faculty }}</option>
                    @endforeach
                </select>
            </form>
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5" id="contributions-list">
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
                <div class="flex h-60 sm:h-full w-full items-center justify-center bg-white">
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
                    <p class="text-sm text-gray-500 mt-1">by <strong>{{ $contribution->user->first_name }}
                        </strong></p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</x-app-layout>

<script>
    // Event listener for Faculty filter change
    document.getElementById('faculty_filter').addEventListener('change', function() {
        var facultyId = this.value;

        // Make AJAX request to filter contributions by selected faculty
        fetch(`/faculty/filter/${facultyId}`, { // Notice how the faculty_id is added to the URL path
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                let contributionsList = document.getElementById('contributions-list');
                contributionsList.innerHTML = ''; // Clear current contributions

                // Dynamically populate contributions list
                if (data.contributions.length === 0) {
                    contributionsList.innerHTML = '<p>No contributions found for the selected faculty.</p>';
                }

                data.contributions.forEach(contribution => {
                    let div = document.createElement('div');
                    div.classList.add('flex', 'flex-col', 'items-center');

                    let imgDiv = document.createElement('div');
                    imgDiv.classList.add('w-full');
                    let img = document.createElement('img');

                    if (contribution.contribution_cover) {
                        img.src = `/storage/contribution-images/${contribution.contribution_cover}`;
                    } else {
                        img.src = `/images/default_image.png`; // Default image if no cover
                    }

                    img.alt = contribution.contribution_title;
                    img.classList.add('w-full', 'h-auto', 'object-cover');
                    imgDiv.appendChild(img);

                    let textDiv = document.createElement('div');
                    textDiv.classList.add('text-start', 'w-full', 'mt-3');
                    let titleLink = document.createElement('a');
                    titleLink.href = `/student/contribution-detail/${contribution.contribution_id}`;
                    titleLink.classList.add('text-md', 'md:text-lg', 'font-semibold', 'text-black', 'group-hover:underline');
                    titleLink.textContent = `${contribution.contribution_title} →`;
                    let description = document.createElement('p');
                    description.classList.add('text-sm', 'md:text-md', 'text-gray-700', 'mt-1');
                    description.textContent = contribution.contribution_description;
                    let author = document.createElement('p');
                    author.classList.add('text-sm', 'text-gray-500', 'mt-1');
                    author.innerHTML =
                        `by <strong>${contribution.user.first_name} </strong>`;

                    textDiv.appendChild(titleLink);
                    textDiv.appendChild(description);
                    textDiv.appendChild(author);

                    div.appendChild(imgDiv);
                    div.appendChild(textDiv);

                    contributionsList.appendChild(div);
                });
            })
            .catch(error => console.error('Error fetching filtered contributions:', error));
    });
</script>
