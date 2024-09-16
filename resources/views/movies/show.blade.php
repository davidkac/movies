<x-layout>
    <x-slot:heading>
        Movie details
    </x-slot:heading>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <!-- Display movie image -->
        <div class="mb-6">
            <img src="{{ filter_var($movies->image, FILTER_VALIDATE_URL) ? $movies->image : asset('storage/' . $movies->image) }}" alt="{{ $movies->title }}" class="rounded-xl w-full h-auto">
        </div>

        <!-- Display title, creator, and description -->
        <div class="mb-4">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Title: {{ $movies->title }}</h1>
            <p class="text-md font-semibold text-gray-700"><strong>Creator</strong>: {{ $movies->user->name }}</p>
            <p class="mt-4 text-gray-600"><strong>Description</strong>: {{ $movies->description }}</p>
        </div>

        <!-- Comments section -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-3">{{ $commentsCount }} Comments</h2>
            <div class="mt-3">
                <form action="{{ route('comment.store', $movies->id) }}" method="POST" class="flex flex-col gap-2">
                    @csrf
                    <textarea
                        name="content"
                        rows="1"
                        placeholder="Add a public comment..."
                        class="border-b border-gray-300 p-1 focus:outline-none focus:border-blue-400 resize-none h-8"
                        style="box-shadow: none; min-height: 36px;"
                    ></textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="text-gray-500 hover:text-gray-700">Cancel</button>
                        <button 
                            type="submit" 
                            class="bg-blue-500 text-white py-1 px-4 rounded-lg hover:bg-blue-600 disabled:bg-gray-300 disabled:cursor-not-allowed" 
                            @guest disabled @endguest
                        >
                            Comment
                        </button>
                    </div>
                </form>
                <div class="mt-8">
                    @forelse($movies->comments as $comment)
                        <div class="bg-gray-100 p-4 rounded-lg mb-4">
                            <p class="text-sm text-gray-700"><strong>User:</strong> {{ $comment->user->name }}</p>
                            <p class="text-xs text-gray-500 mt-2">{{ $comment->content }}</p>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No comments yet. Be the first to comment!</p>
                    @endforelse
                </div>
            </div>
        </div>
</x-layout>
