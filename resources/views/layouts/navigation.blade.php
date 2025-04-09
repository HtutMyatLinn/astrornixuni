<?php
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
?>

<nav x-data="{ open: false, isSticky: false }" x-on:scroll.window="isSticky = window.scrollY > 80" :class="{ 'shadow-sm': isSticky }"
    class="transition-all duration-500 bg-white border-b sticky top-0 border-gray-100 z-50 min-w-[420px]">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-[74px]">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a
                        href="{{ Auth::check() ? (Auth::user()->role === 'Student' ? route('student.dashboard') : url('/')) : url('/') }}">
                        <x-logo />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="Auth::check() && Auth::user()->role ? (Auth::user()->role->role === 'Student' ? route('student.dashboard') : url('/')) : url('/')" :active="request()->routeIs('student.dashboard') || request()->is('/')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contributions')" :active="request()->routeIs('contributions')">
                        {{ __('Contributions') }}
                    </x-nav-link>
                    <x-nav-link :href="route('faculty')" :active="request()->routeIs('faculty')">
                        {{ __('Faculty') }}
                    </x-nav-link>

                    <x-nav-link :href="route('aboutus')" :active="request()->routeIs('aboutus')">
                        {{ __('About') }}
                    </x-nav-link>
                    <x-nav-link :href="route('contactus')" :active="request()->routeIs('contactus')">
                        {{ __('Contact') }}
                    </x-nav-link>
                </div>


            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @if (Auth::check() && Auth::user()->role && Auth::user()->role->role === 'Student')
                    <a href="{{ route('upload_contribution.index') }}"
                        class="leading-4 font-medium text-blue-800 hover:text-blue-900 border-l-2 py-2 pl-4 transition-colors duration-200">
                        Contribute your article
                    </a>
                @endif

                <x-dropdown align="right">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @if (Auth::check())
                                <div class="truncate max-w-[100px]">{{ Auth::user()->username }}</div>
                            @else
                                <div
                                    class="border-2 border-slate-600 rounded-full p-1 w-7 h-7 flex items-center justify-center">
                                    <i class="ri-user-fill text-slate-600 text-xl"></i>
                                </div>
                            @endif
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        {{-- Profile --}}
                        <div class="flex items-center gap-3 p-2">
                            @if (Auth::check())
                                @if (Auth::user()->profile_image)
                                    <img id="profilePreview"
                                        class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base object-cover"
                                        src="{{ asset('profile_images/' . Auth::user()->profile_image) }}"
                                        alt="Profile">
                                @else
                                    <p
                                        class="m-0 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base object-cover">
                                        {{ strtoupper(Auth::user()->username[0]) }}
                                    </p>
                                @endif
                            @else
                                <div class="w-10 h-10 sm:w-12 sm:h-12 select-none">
                                    <img src="{{ asset('images/guest.jpg') }}" alt="Guest Profile"
                                        class="w-full h-full rounded-full object-cover">
                                </div>
                            @endif
                            <div class="flex-1 min-w-0 text-wrap">
                                @if (Auth::check())
                                    <p class="text-wrap">Welcome, {{ Auth::user()->username }}</p>
                                @else
                                    <p class="text-xs sm:text-sm text-gray-500 w-44 text-wrap" title="Guest">
                                        Register to get access to all features
                                    </p>
                                @endif
                            </div>
                        </div>
                        @if (Auth::check())
                            <div class="px-4">
                                <p class="text-xs sm:text-sm text-gray-600 text-nowrap"
                                    title="{{ Auth::user()->email }}">
                                    {{ Auth::user()->email }}
                                </p>
                                <p class="text-xs text-gray-500 text-nowrap">
                                    Last login date -
                                    {{ Auth::user()->last_login_date ? Auth::user()->last_login_date->format('d-m-Y h:i A') : 'Never' }}
                                </p>
                            </div>

                            @if (Auth::check() && Auth::user()->role && Auth::user()->role->role === 'Student')
                                <x-dropdown-link :href="route('student.re_upload_contribution')" class="flex gap-2 items-center">
                                    <i class="ri-file-history-line text-xl"></i>
                                    {{ __('Contribution History') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('profile.edit')" class="flex gap-2 items-center">
                                <i class="ri-user-3-line text-xl"></i>
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" class="flex gap-2 items-center"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <i class="ri-logout-box-r-line text-xl"></i>
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('register')" class="flex gap-2 items-center">
                                <i class="ri-user-add-line text-xl"></i>
                                {{ __('Register') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('login')" class="flex gap-2 items-center">
                                <i class="ri-user-3-line text-xl"></i>
                                {{ __('Log In') }}
                            </x-dropdown-link>
                        @endif
                    </x-slot>
                </x-dropdown>

                <!-- Add this to your CSS -->
                <style>
                    [x-cloak] {
                        display: none !important;
                    }
                </style>

                <!-- Notification Icon with Counter -->
                <div class="relative" x-data="{ notiOpen: false }" x-init="notiOpen = false">
                    <button @click="notiOpen = !notiOpen"
                        class="relative p-1 rounded-full text-gray-500 hover:text-gray-600 focus:outline-none">
                        <i class="ri-notification-3-line text-xl cursor-pointer"></i>
                        @if (Auth::check())
                            @php
                                $feedbacks = DB::table('feedbacks')
                                    ->join(
                                        'contributions',
                                        'feedbacks.contribution_id',
                                        '=',
                                        'contributions.contribution_id',
                                    )
                                    ->where('contributions.user_id', Auth::id())
                                    ->where('feedbacks.user_id', '!=', Auth::id())
                                    ->where('contributions.contribution_status', 'Review')
                                    ->get();

                                $totalCount = $feedbacks->count();
                                $passwordExpired = now()->gt(Auth::user()->password_expired_date);
                                $passwordAboutToExpire =
                                    now()->diffInDays(Auth::user()->password_expired_date) <= 7 && !$passwordExpired;

                                if ($passwordExpired) {
                                    $totalCount++;
                                }
                                if ($passwordAboutToExpire) {
                                    $totalCount++;
                                }
                            @endphp

                            <span x-data="{
                                unreadCount: {{ $totalCount }},
                                init() {
                                    // Initialize by checking localStorage for viewed notifications
                                    @foreach ($feedbacks as $feedback)
                        if(localStorage.getItem('viewedFeedback_{{ $feedback->feedback_id }}') === 'true') {
                            this.unreadCount--;
                        } @endforeach
                                    if (localStorage.getItem('viewedPasswordExpired') === 'true') {
                                        this.unreadCount--;
                                    }
                                    if (localStorage.getItem('viewedPasswordAboutToExpire') === 'true') {
                                        this.unreadCount--;
                                    }
                                }
                            }" x-show="unreadCount > 0" x-cloak
                                class="absolute -top-1 -right-1 flex h-4 w-4 notification-badge">
                                <span
                                    class="absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span
                                    class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-white text-xs items-center justify-center"
                                    x-text="unreadCount"></span>
                            </span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="notiOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        @click.away="notiOpen = false" x-cloak
                        class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50 max-h-96 overflow-y-auto scrollbar">

                        <div class="px-4 py-3">
                            <p class="text-sm font-semibold text-gray-900">Notifications</p>
                        </div>

                        <div class="py-1" id="notification-container">
                            @if (Auth::check())
                                <!-- Password About to Expire Notification -->
                                @php
                                    $daysUntilExpiration = now()->diffInDays(Auth::user()->password_expired_date);
                                @endphp
                                @if ($daysUntilExpiration <= 7 && !now()->gt(Auth::user()->password_expired_date))
                                    <a href="{{ route('profile.edit') }}" x-data="{
                                        isNew: localStorage.getItem('viewedPasswordAboutToExpire') !== 'true',
                                        init() {
                                            if (!this.isNew) {
                                                this.$el.remove();
                                                this.checkEmptyState();
                                            }
                                        },
                                        markAsViewed() {
                                            if (this.isNew) {
                                                localStorage.setItem('viewedPasswordAboutToExpire', 'true');
                                                this.isNew = false;
                                    
                                                // Update the counter
                                                const badge = document.querySelector('.notification-badge span:last-child');
                                                if (badge) {
                                                    const currentCount = parseInt(badge.textContent);
                                                    if (currentCount > 1) {
                                                        badge.textContent = currentCount - 1;
                                                    } else {
                                                        badge.closest('.notification-badge').remove();
                                                    }
                                                }
                                    
                                                // Remove this notification from the list
                                                this.$el.remove();
                                                this.checkEmptyState();
                                            }
                                        },
                                        checkEmptyState() {
                                            const container = document.getElementById('notification-container');
                                            const notifications = container.querySelectorAll('a:not(.empty-state)');
                                            if (notifications.length === 0) {
                                                if (!container.querySelector('.empty-state')) {
                                                    const emptyState = document.createElement('div');
                                                    emptyState.className = 'px-4 py-3 text-center text-sm text-gray-500 empty-state';
                                                    emptyState.textContent = 'No notifications available';
                                                    container.appendChild(emptyState);
                                                }
                                            }
                                        }
                                    }"
                                        @click="markAsViewed()" x-show="isNew"
                                        class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-150 notification-item">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 pt-0.5">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-yellow-100 flex items-center justify-center">
                                                    <i class="ri-alarm-line text-yellow-500"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    Password Expiring Soon
                                                </p>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    Your password will expire in {{ ceil($daysUntilExpiration) }}
                                                    {{ Str::plural('day', ceil($daysUntilExpiration)) }}
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Expires on
                                                    {{ Auth::user()->password_expired_date }}
                                                </p>
                                            </div>
                                            <span x-show="isNew" class="ml-2 w-2 h-2 rounded-full bg-yellow-500"></span>
                                        </div>
                                    </a>
                                @endif

                                <!-- Password Expired Notification -->
                                @if (now()->gt(Auth::user()->password_expired_date))
                                    <a href="{{ route('profile.edit') }}" x-data="{
                                        isNew: localStorage.getItem('viewedPasswordExpired') !== 'true',
                                        init() {
                                            if (!this.isNew) {
                                                this.$el.remove();
                                                this.checkEmptyState();
                                            }
                                        },
                                        markAsViewed() {
                                            if (this.isNew) {
                                                localStorage.setItem('viewedPasswordExpired', 'true');
                                                this.isNew = false;
                                    
                                                // Update the counter
                                                const badge = document.querySelector('.notification-badge span:last-child');
                                                if (badge) {
                                                    const currentCount = parseInt(badge.textContent);
                                                    if (currentCount > 1) {
                                                        badge.textContent = currentCount - 1;
                                                    } else {
                                                        badge.closest('.notification-badge').remove();
                                                    }
                                                }
                                    
                                                // Remove this notification from the list
                                                this.$el.remove();
                                                this.checkEmptyState();
                                            }
                                        },
                                        checkEmptyState() {
                                            const container = document.getElementById('notification-container');
                                            const notifications = container.querySelectorAll('a:not(.empty-state)');
                                            if (notifications.length === 0) {
                                                if (!container.querySelector('.empty-state')) {
                                                    const emptyState = document.createElement('div');
                                                    emptyState.className = 'px-4 py-3 text-center text-sm text-gray-500 empty-state';
                                                    emptyState.textContent = 'No notifications available';
                                                    container.appendChild(emptyState);
                                                }
                                            }
                                        }
                                    }"
                                        @click="markAsViewed()" x-show="isNew"
                                        class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-150 notification-item">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0 pt-0.5">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center">
                                                    <i class="ri-alarm-warning-fill text-red-500"></i>
                                                </div>
                                            </div>
                                            <div class="ml-3 flex-1">
                                                <p class="text-sm font-medium text-gray-900">
                                                    Password Expired
                                                </p>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    Your password expired on
                                                    {{ Auth::user()->password_expired_date }}
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    Please change your password immediately
                                                </p>
                                            </div>
                                            <span x-show="isNew" class="ml-2 w-2 h-2 rounded-full bg-red-500"></span>
                                        </div>
                                    </a>
                                @endif

                                <!-- Existing Feedback Notifications -->
                                @php
                                    $feedbacks = DB::table('feedbacks')
                                        ->join(
                                            'contributions',
                                            'feedbacks.contribution_id',
                                            '=',
                                            'contributions.contribution_id',
                                        )
                                        ->join('users', 'feedbacks.user_id', '=', 'users.user_id')
                                        ->where('contributions.user_id', Auth::id())
                                        ->where('feedbacks.user_id', '!=', Auth::id())
                                        ->where('contributions.contribution_status', 'Review')
                                        ->orderBy('feedbacks.feedback_given_date', 'desc')
                                        ->select(
                                            'feedbacks.*',
                                            'users.username as feedback_giver',
                                            'contributions.contribution_title as contribution_title',
                                        )
                                        ->get();
                                @endphp

                                @if ($feedbacks->count() > 0)
                                    @foreach ($feedbacks as $feedback)
                                        <a href="{{ route('upload_contribution.edit', $feedback->contribution_id) }}"
                                            x-data="{
                                                feedbackId: {{ $feedback->feedback_id }},
                                                isNew: localStorage.getItem('viewedFeedback_{{ $feedback->feedback_id }}') !== 'true',
                                                init() {
                                                    if (!this.isNew) {
                                                        this.$el.remove();
                                                        this.checkEmptyState();
                                                    }
                                                },
                                                markAsViewed() {
                                                    if (this.isNew) {
                                                        localStorage.setItem('viewedFeedback_' + this.feedbackId, 'true');
                                                        this.isNew = false;
                                            
                                                        const badge = document.querySelector('.notification-badge span:last-child');
                                                        if (badge) {
                                                            const currentCount = parseInt(badge.textContent);
                                                            if (currentCount > 1) {
                                                                badge.textContent = currentCount - 1;
                                                            } else {
                                                                badge.closest('.notification-badge').remove();
                                                            }
                                                        }
                                            
                                                        this.$el.remove();
                                                        this.checkEmptyState();
                                                    }
                                                },
                                                checkEmptyState() {
                                                    const container = document.getElementById('notification-container');
                                                    const notifications = container.querySelectorAll('a:not(.empty-state)');
                                                    if (notifications.length === 0) {
                                                        if (!container.querySelector('.empty-state')) {
                                                            const emptyState = document.createElement('div');
                                                            emptyState.className = 'px-4 py-3 text-center text-sm text-gray-500 empty-state';
                                                            emptyState.textContent = 'No notifications available';
                                                            container.appendChild(emptyState);
                                                        }
                                                    }
                                                }
                                            }" @click="markAsViewed()" x-show="isNew"
                                            class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-150 notification-item">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 pt-0.5">
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <i class="ri-feedback-fill text-blue-500"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        Feedback on
                                                        "{{ Str::limit($feedback->contribution_title, 20) }}"
                                                    </p>
                                                    <p class="text-sm text-gray-500 mt-1">
                                                        {{ Str::limit($feedback->feedback, 50) }}
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        {{ \Carbon\Carbon::parse($feedback->feedback_given_date)->diffForHumans() }}
                                                        by {{ $feedback->feedback_giver }}
                                                    </p>
                                                </div>
                                                <span x-show="isNew"
                                                    class="ml-2 w-2 h-2 rounded-full bg-blue-500"></span>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif

                                @if ($feedbacks->count() == 0 && !now()->gt(Auth::user()->password_expired_date) && $daysUntilExpiration > 7)
                                    <div class="px-4 py-3 text-center text-sm text-gray-500 empty-state">
                                        No notifications available
                                    </div>
                                @endif
                            @else
                                <div class="px-4 py-3 text-center text-sm text-gray-500">
                                    Please login to view notifications
                                </div>
                            @endif
                        </div>

                        @if (Auth::check() &&
                                ($feedbacks->count() > 0 || now()->gt(Auth::user()->password_expired_date) || $daysUntilExpiration <= 7))
                            <div class="px-4 py-2 text-center view-all-link" x-data="{
                                viewAll() {
                                    // Mark all as viewed when clicking 'View all'
                                    @foreach ($feedbacks as $feedback)
                        localStorage.setItem('viewedFeedback_{{ $feedback->feedback_id }}', 'true'); @endforeach
                                    localStorage.setItem('viewedPasswordExpired', 'true');
                                    localStorage.setItem('viewedPasswordAboutToExpire', 'true');
                            
                                    // Remove the badge
                                    const badge = document.querySelector('.notification-badge');
                                    if (badge) {
                                        badge.remove();
                                    }
                            
                                    // Remove all notifications from the list
                                    const notificationItems = document.querySelectorAll('.notification-item');
                                    notificationItems.forEach(item => item.remove());
                            
                                    // Show empty state
                                    const container = document.getElementById('notification-container');
                                    const emptyState = document.createElement('div');
                                    emptyState.className = 'px-4 py-3 text-center text-sm text-gray-500 empty-state';
                                    emptyState.textContent = 'No notifications available';
                                    container.appendChild(emptyState);
                            
                                    // Remove the 'View all' link
                                    this.$el.remove();
                            
                                    // Close the dropdown after a short delay
                                    setTimeout(() => { notiOpen = false; }, 300);
                                }
                            }">
                                <a href="{{ route('contributions') }}" @click.prevent="viewAll()"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                    View all notifications
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <!-- Notification Icon with Counter -->
                <div class="relative" x-data="{ notiOpen: false }" x-init="notiOpen = false">
                    <button @click="notiOpen = !notiOpen"
                        class="relative p-1 rounded-full text-gray-500 hover:text-gray-600 focus:outline-none">
                        <i class="ri-notification-3-line text-xl cursor-pointer"></i>
                        @if (Auth::check())
                            @php
                                $feedbacks = DB::table('feedbacks')
                                    ->join(
                                        'contributions',
                                        'feedbacks.contribution_id',
                                        '=',
                                        'contributions.contribution_id',
                                    )
                                    ->where('contributions.user_id', Auth::id())
                                    ->where('feedbacks.user_id', '!=', Auth::id())
                                    ->get();

                                $totalCount = $feedbacks->count();
                            @endphp

                            <span x-data="{
                                unreadCount: {{ $totalCount }},
                                init() {
                                    // Initialize by checking localStorage for viewed notifications
                                    @foreach ($feedbacks as $feedback)
                        if(localStorage.getItem('viewedFeedback_{{ $feedback->feedback_id }}') === 'true') {
                            this.unreadCount--;
                        } @endforeach
                                }
                            }" x-show="unreadCount > 0" x-cloak
                                class="absolute -top-1 -right-1 flex h-4 w-4 notification-badge">
                                <span
                                    class="absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                <span
                                    class="relative inline-flex rounded-full h-4 w-4 bg-red-500 text-white text-xs items-center justify-center"
                                    x-text="unreadCount"></span>
                            </span>
                        @endif
                    </button>

                    <!-- Notification Dropdown -->
                    <div x-show="notiOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                        @click.away="notiOpen = false" x-cloak
                        class="origin-top-right absolute -right-10 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50 max-h-96 overflow-y-auto scrollbar">

                        <div class="px-4 py-3">
                            <p class="text-sm font-semibold text-gray-900">Notifications</p>
                        </div>

                        <div class="py-1" id="notification-container">
                            @if (Auth::check())
                                @php
                                    $feedbacks = DB::table('feedbacks')
                                        ->join(
                                            'contributions',
                                            'feedbacks.contribution_id',
                                            '=',
                                            'contributions.contribution_id',
                                        )
                                        ->join('users', 'feedbacks.user_id', '=', 'users.user_id')
                                        ->where('contributions.user_id', Auth::id())
                                        ->where('feedbacks.user_id', '!=', Auth::id())
                                        ->orderBy('feedbacks.feedback_given_date', 'desc')
                                        ->select(
                                            'feedbacks.*',
                                            'users.username as feedback_giver',
                                            'contributions.contribution_title as contribution_title',
                                        )
                                        ->get();

                                    // Filter out viewed notifications on the client side using Alpine

                                @endphp

                                @if ($feedbacks->count() > 0)
                                    @foreach ($feedbacks as $feedback)
                                        <a href="{{ route('student.contribution-detail', $feedback->contribution_id) }}"
                                            x-data="{
                                                feedbackId: {{ $feedback->feedback_id }},
                                                isNew: localStorage.getItem('viewedFeedback_{{ $feedback->feedback_id }}') !== 'true',
                                                init() {
                                                    // Hide if already viewed
                                                    if (!this.isNew) {
                                                        this.$el.remove();
                                                        this.checkEmptyState();
                                                    }
                                                },
                                                markAsViewed() {
                                                    if (this.isNew) {
                                                        localStorage.setItem('viewedFeedback_' + this.feedbackId, 'true');
                                                        this.isNew = false;
                                            
                                                        // Update the counter
                                                        const badge = document.querySelector('.notification-badge span:last-child');
                                                        if (badge) {
                                                            const currentCount = parseInt(badge.textContent);
                                                            if (currentCount > 1) {
                                                                badge.textContent = currentCount - 1;
                                                            } else {
                                                                badge.closest('.notification-badge').remove();
                                                            }
                                                        }
                                            
                                                        // Remove this notification from the list
                                                        this.$el.remove();
                                                        this.checkEmptyState();
                                                    }
                                                },
                                                checkEmptyState() {
                                                    // If no more notifications, show empty state
                                                    if (document.querySelectorAll('#notification-container a').length === 0) {
                                                        const container = document.getElementById('notification-container');
                                                        // Check if empty state already exists
                                                        if (!container.querySelector('.empty-state')) {
                                                            const emptyState = document.createElement('div');
                                                            emptyState.className = 'px-4 py-3 text-center text-sm text-gray-500 empty-state';
                                                            emptyState.textContent = 'No notifications available';
                                                            container.appendChild(emptyState);
                                            
                                                            // Hide the 'View all' link
                                                            const viewAllLink = document.querySelector('.view-all-link');
                                                            if (viewAllLink) {
                                                                viewAllLink.remove();
                                                            }
                                                        }
                                                    }
                                                }
                                            }" @click="markAsViewed()" x-show="isNew"
                                            class="block px-4 py-3 hover:bg-gray-50 transition-colors duration-150 notification-item">
                                            <div class="flex items-start">
                                                <div class="flex-shrink-0 pt-0.5">
                                                    <div
                                                        class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                        <i class="ri-feedback-fill text-blue-500"></i>
                                                    </div>
                                                </div>
                                                <div class="ml-3 flex-1">
                                                    <p class="text-sm font-medium text-gray-900">
                                                        Feedback on
                                                        "{{ Str::limit($feedback->contribution_title, 20) }}"
                                                    </p>
                                                    <p class="text-sm text-gray-500 mt-1">
                                                        {{ Str::limit($feedback->feedback, 50) }}
                                                    </p>
                                                    <p class="text-xs text-gray-400 mt-1">
                                                        {{ \Carbon\Carbon::parse($feedback->feedback_given_date)->diffForHumans() }}
                                                        by {{ $feedback->feedback_giver }}
                                                    </p>
                                                </div>
                                                <span x-show="isNew"
                                                    class="ml-2 w-2 h-2 rounded-full bg-blue-500"></span>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <div class="px-4 py-3 text-center text-sm text-gray-500 empty-state">
                                        No notifications available
                                    </div>
                                @endif
                            @else
                                <div class="px-4 py-3 text-center text-sm text-gray-500">
                                    Please login to view notifications
                                </div>
                            @endif
                        </div>

                        @if (Auth::check() && $feedbacks->count() > 0)
                            <div class="px-4 py-2 text-center view-all-link" x-data="{
                                viewAll() {
                                    // Mark all as viewed when clicking 'View all'
                                    @foreach ($feedbacks as $feedback)
                        localStorage.setItem('viewedFeedback_{{ $feedback->feedback_id }}', 'true'); @endforeach
                                    // Remove the badge
                                    const badge = document.querySelector('.notification-badge');
                                    if (badge) {
                                        badge.remove();
                                    }
                                    // Remove all notifications from the list
                                    const notificationItems = document.querySelectorAll('.notification-item');
                                    notificationItems.forEach(item => item.remove());
                            
                                    // Show empty state
                                    const container = document.getElementById('notification-container');
                                    const emptyState = document.createElement('div');
                                    emptyState.className = 'px-4 py-3 text-center text-sm text-gray-500 empty-state';
                                    emptyState.textContent = 'No notifications available';
                                    container.appendChild(emptyState);
                            
                                    // Remove the 'View all' link
                                    this.$el.remove();
                            
                                    // Close the dropdown after a short delay
                                    setTimeout(() => { notiOpen = false; }, 300);
                                }
                            }">
                                <a href="{{ route('contributions') }}" @click.prevent="viewAll()"
                                    class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                    View all notifications
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('/')" :active="request()->routeIs('/')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contributions')" :active="request()->routeIs('contributions')">
                {{ __('Contributions') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('faculty')" :active="request()->routeIs('faculty')">
                {{ __('Faculty') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('aboutus')" :active="request()->routeIs('aboutus')">
                {{ __('About') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('contactus')" :active="request()->routeIs('contactus')">
                {{ __('Contact') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-2">
                @if (Auth::check())
                    @if (Auth::check())
                        @if (Auth::user()->profile_image)
                            <img id="profilePreview"
                                class="m-0 w-14 h-14 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base object-cover"
                                src="{{ asset('profile_images/' . Auth::user()->profile_image) }}" alt="Profile">
                        @else
                            <p
                                class="m-0 w-14 h-14 rounded-full bg-blue-100 text-blue-500 uppercase font-semibold flex items-center justify-center select-none text-sm sm:text-base object-cover">
                                {{ strtoupper(Auth::user()->username[0]) }}
                            </p>
                        @endif
                    @else
                        <div class="w-14 h-14 select-none">
                            <img src="{{ asset('images/guest.jpg') }}" alt="Guest Profile"
                                class="w-full h-full rounded-full object-cover">
                        </div>
                    @endif
                    <div class="flex flex-col">
                        <div>
                            <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <p class="text-xs text-gray-500 text-nowrap">
                            Last login date -
                            {{ Auth::user()->last_login_date ? Auth::user()->last_login_date->format('d-m-Y h:i A') : 'Never' }}
                        </p>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <div class="w-14 h-14 select-none">
                            <img src="{{ asset('images/guest.jpg') }}" alt="Guest Profile"
                                class="w-full h-full rounded-full object-cover">
                        </div>
                        <p class="text-xs sm:text-sm text-gray-500 w-44 text-wrap" title="Guest">
                            Register to get access to all features
                        </p>
                    </div>
                @endif
            </div>

            @if (Auth::check())
                <div class="mt-3 space-y-1">
                    @if (Auth::check() && Auth::user()->role && Auth::user()->role->role === 'Student')
                        <a href="{{ route('upload_contribution.index') }}"
                            class="leading-4 font-medium text-blue-800 hover:text-blue-900 border-l-2 mt-3 ps-3 pe-4 py-3 transition-colors duration-200">
                            Contribute your article
                        </a>
                    @endif
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>
                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                    this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                </div>
            @endif

        </div>
    </div>
</nav>
