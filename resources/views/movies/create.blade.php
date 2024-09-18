<x-layout>
    <x-slot:heading>
        Add Movie
    </x-slot:heading>

    <form method="POST" action="{{ route('movies.store') }}" enctype="multipart/form-data" class="max-w-lg mx-auto bg-gray-800 p-6 rounded-lg shadow-md text-white">
        @csrf

        <!-- Title Field -->
        <div class="mb-4">
            <label for="title" class="block text-gray-300 font-medium mb-2">Title</label>
            <input type="text" id="title" name="title" placeholder="Enter the title" 
                   class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
            <x-form-error name="title" />
        </div>

        <!-- Description Field -->
        <div class="mb-4">
            <label for="description" class="block text-gray-300 font-medium mb-2">Description</label>
            <textarea id="description" name="description" rows="4" placeholder="Enter the description" 
                      class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
            <x-form-error name="description" />
        </div>

        <!-- Image Upload Field -->
        <div class="mb-4 border border-gray-600 rounded-lg p-2 bg-gray-700">
            <label for="image" class="block text-gray-300 font-medium mb-2">Image</label>
            <input type="file" id="image" name="image" 
                   class="block w-full text-gray-300 cursor-pointer file:cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-white file:bg-purple-600 hover:file:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
            <x-form-error name="image" />
        </div>

        <!-- Categories Field with multiple selection -->
        <div class="mb-4">
            <label for="categories" class="block text-gray-300 font-medium mb-2">Categories</label>
            <select name="categories[]" id="categories" multiple 
                    class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-form-error name="categories" />
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
            Submit
        </button>
    </form>
</x-layout>
