<x-layout>
    <x-slot:heading>
        Edit Movie
    </x-slot:heading>

    <form method="POST" action="{{ route('movies.update', $movie->id) }}" enctype="multipart/form-data" class="max-w-lg mx-auto bg-gray-800 p-6 rounded-lg shadow-md text-white">
        @csrf
        @method('PUT')

        <!-- Title Field -->
        <div class="mb-4">
            <label for="title" class="block text-gray-300 font-medium mb-2">Title</label>
            <input type="text" id="title" name="title" value="{{ old('title', $movie->title) }}" 
                   class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
            @error('title')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Description Field -->
        <div class="mb-4">
            <label for="description" class="block text-gray-300 font-medium mb-2">Description</label>
            <textarea id="description" name="description" rows="4" 
                      class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">{{ old('description', $movie->description) }}</textarea>
            @error('description')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current Image Display -->
        <div class="mb-4">
            <label class="block text-gray-300 font-medium mb-2">Current Image</label>
            <img src="{{ filter_var($movie->image, FILTER_VALIDATE_URL) ? $movie->image : asset('storage/' . $movie->image) }}" 
                 alt="{{ $movie->title }}" 
                 class="rounded-md w-[150px] h-[225px] object-cover">
        </div>

        <!-- Image Upload Field -->
        <div class="mb-4 border border-gray-600 rounded-lg p-2 bg-gray-700">
            <label for="image" class="block text-gray-300 font-medium mb-2">Change Image</label>
            <input type="file" id="image" name="image" class="block w-full text-gray-300 cursor-pointer file:cursor-pointer file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-white file:bg-purple-600 hover:file:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500">
            @error('image')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Categories Field -->
        <div class="mb-4">
            <label for="categories" class="block text-gray-300 font-medium mb-2">Categories</label>
            <select name="categories[]" id="categories" multiple class="w-full px-4 py-2 border border-gray-600 rounded-lg bg-gray-700 text-white focus:outline-none focus:ring-2 focus:ring-purple-500">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, $movie->categories->pluck('id')->toArray()) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('categories')
            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-purple-500">
            Update
        </button>
    </form>
</x-layout>
