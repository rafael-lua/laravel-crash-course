@props(['post' => $post])

<div class="mb-4">
    {{-- since we not doing something with the relationship, we just want the properties, we don't use user as function. --}}
    <a href="{{ route('users.posts', $post->user) }}" class="font-bold">{{ $post->user->name }}</a>
    <span class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>
    {{-- behind scenes, created_at/updated_at dates are not actually strings, but a carbon object, that is a library for manipualting date and time. --}}

    <p class="mb-2">{{ $post->body }}</p>


    <div class="flex items-center">

        {{-- @if ($post->ownedBy(auth()->user())) --}}
        @can('delete', $post)
            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="mr-1">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500">Delete</button>
            </form>
        @endcan
        {{-- @endif --}}

        @auth()
            @if (!$post->likedBy(auth()->user()))
                {{-- using csrf protection so posts can't be liked or unliked by some kind of attack --}}
                <form action="{{ route('posts.likes', $post) }}" method="POST" class="mr-1">
                    @csrf
                    <button type="submit" class="text-blue-500">Like</button>
                </form>
            @else
                <form action="{{ route('posts.likes', $post) }}" method="POST" class="mr-1">
                    @csrf
                    @method('DELETE') {{-- laravel method spoofing --}}
                    <button type="submit" class="text-blue-500">Unlike</button>
                </form>
            @endif
        @endauth

        <span>{{ $post->likes->count() }} {{ Str::plural('like', $post->likes->count()) }}</span>
    </div>
</div>
