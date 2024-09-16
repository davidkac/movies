<x-layout>
    <x-slot:heading>
        Home Page
    </x-slot:heading>

    @auth
    <h1>
    {{ auth()->user()->name }}
    </h1>
    @endauth
</x-layout>