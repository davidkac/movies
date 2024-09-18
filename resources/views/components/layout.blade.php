<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>My Website</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500"
                                alt="Your Company">
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <x-nav-link href="/top-rated-movies" :active="request()->is('/top-rated-movies')">Top Rated Movies</x-nav-link>
                                <x-nav-link href="/movies" :active="request()->is('movies')">Movies</x-nav-link>
                                @auth
                                <x-nav-link href="/favorites" :active="request()->is('favorites')">Favorites</x-nav-link>
                                @endauth
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            @guest
                            <x-nav-link href="/login/create" :active="request()->is('login/create')">Log In</x-nav-link>
                            <x-nav-link href="/register/create"
                                :active="request()->is('register/create')">Register</x-nav-link>
                            @endguest
                            @auth
                            <form method="POST" action="/logout">
                                @csrf
                                <x-button>Log Out</x-button>
                            </form>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Izmenjena pozadina header-a -->
        <header class="bg-gradient-to-r from-gray-800 via-purple-800 to-gray-900 shadow text-white">
            <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 sm:flex sm:justify-between">
                <h1 class="text-3xl font-bold tracking-tight">{{ $heading }}</h1>
                @auth
                <a href="{{ route('movies.create') }}"
                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:focus:border-blue-700 dark:active:bg-gray-700 dark:active:text-gray-300">Create
                    Movie</a>
                @endauth
            </div>
        </header>

        <!-- Izmenjena pozadina main-a -->
        <main class="bg-gray-900 text-white">
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>

</html>
