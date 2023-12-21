<x-guest-layout>



    <div class="text-center">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $article->title }}
        </h2>
    </div>

    <p class="mt-2">
        @foreach ($article->categories as $category)
            <span class="inline-block bg-gray-500 text-white px-2 py-1 rounded-full text-xs mr-2">{{ $category->name }}</span>
        @endforeach
    </p>

    <div class="text-gray-500 text-sm">
        <br>
        Publié le {{ $article->created_at->format('d/m/Y') }} par <a href="{{ route('public.index', $article->user->id) }}">{{ $article->user->name }}</a>
    </div>

    <div>
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <p class="text-gray-700 dark:text-gray-300">{{ $article->content }}</p>
        </div>
    </div>


    @auth
        <div class="shadow-lg p-6 bg-gray-200 rounded">
            @foreach ($article->comments as $comment)
                <div class="bg-gray-100 p-4 my-4 rounded-md">
                    <p class="text-gray-700 text-sm">{{ $comment->content }}</p>
                    <div class="mt-2 flex items-center">
                        <span class="text-gray-500 text-xs">{{ $comment->user->name }}</span>
                        <span class="text-gray-500 text-xs ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            @endforeach

            <form action="{{ route('comments.store', ['article' => $article->id]) }}" method="post" class="mt-6">
                @csrf
                <input type="hidden" name="article" value="{{ $article->id }}">

                <div class="mb-4">
                    <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Ajouter un commentaire:</label>
                    <textarea name="content" id="content" rows="3" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600">Envoyer</button>
            </form>
        </div>
    @endauth

</x-guest-layout>
