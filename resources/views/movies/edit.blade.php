<x-layout>
    <x-slot:heading>
        Add movie
    </x-slot:heading>


    <form method="POST" action="/movies" class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow-md">
        @csrf
        <!-- Title Field -->
        <div class="mb-4">
            <label for="title" class="block text-gray-700 font-medium mb-2">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter the title" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('title')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description Field -->
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-medium mb-2">Description</label>
            <textarea id="description" name="description" rows="4" placeholder="Enter the description" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            @error('description')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Image Upload Field -->
        <div class="mb-4 border border-gray-300 rounded-lg p-2">
            <label for="image" class="block text-gray-700 font-medium mb-2">Image</label>
            <input type="file" id="image" name="image" class="block w-full text-gray-700 cursor-pointer file:cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-white file:bg-blue-500 hover:file:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            @error('image')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Submit
        </button>
    </form>

</x-layout>