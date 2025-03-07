<x-app-layout>
    <section class="bg-[#5A7BAF] text-white py-12 text-center"> <!-- Increased height slightly -->
        <h1 class="text-3xl font-bold">Why Update Your <br> Profile</h1>
        <p class="mt-1 text-lg">
            Keeping your profile updated ensures that your contributions are credited,<br> properly,
            and your information remains up to date in the university <br> magazine.
        </p>
    </section>

    <div class="py-0 bg-white {{ request()->routeIs('profile') ? '' : 'bg-gray-100' }} -mt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 mt-0">
                @include('profile.partials.update-student-profile')
            </div>
        </div>
    </div>
</x-app-layout>
