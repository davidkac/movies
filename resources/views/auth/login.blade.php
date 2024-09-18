<x-layout>
    <x-slot:heading>
        Login Page
    </x-slot:heading>

    <div class="flex min-h-screen items-start justify-center px-6 py-12 lg:px-8 bg-gray-900">
        <div class="sm:mx-auto sm:w-full sm:max-w-md bg-gray-800 p-6 rounded-lg shadow-md text-white">
            <img class="mx-auto h-10 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600" alt="Your Company">
            <h2 class="mt-6 text-center text-2xl font-bold tracking-tight">Log In</h2>

            <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-300">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required
                        class="block w-full rounded-md bg-gray-700 text-white border-0 py-2 pl-3 ring-1 ring-gray-600 focus:ring-2 focus:ring-indigo-500">
                </div>
                <x-form-error name="email" />


                <div>
                    <label for="password" class="block text-sm font-medium text-gray-300">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="block w-full rounded-md bg-gray-700 text-white border-0 py-2 pl-3 ring-1 ring-gray-600 focus:ring-2 focus:ring-indigo-500">
                </div>
                <x-form-error name="password" />


                <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Log In
                </button>
            </form>
        </div>
    </div>
</x-layout>