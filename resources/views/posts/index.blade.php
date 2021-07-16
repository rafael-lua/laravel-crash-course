@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12 bg-white p-6 rounded-lg">
            <form action="{{ route('posts') }}" method="post" class="mb-4">
                @csrf
                <div class="mb-4">
                    <label for="body" class="sr-only">Body</label>
                    <textarea name="body" id="body" cols="30" rows="4"
                        class="bg-gray-100 border-2 w-full p-4 rounded-lg @error('body') border-red-500 @enderror"
                        placeholder="Post something!"></textarea>

                    @error('body')
                        <div class="text-red-500 mt-2 text-sm">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded font-medium">Post</button>
                </div>
            </form>

            {{-- laravel collections offer a count method --}}
            @if ($posts->count())
                @foreach ($posts as $post)
                    <div class="mb-4">
                        {{-- since we not doing something with the relationship, we just want the properties, we don't use user as function. --}}
                        <a href="" class="font-bold">{{ $post->user->name }}</a> <span
                            class="text-gray-600 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                        {{-- behind scenes, created_at/updated_at dates are not actually strings, but a carbon object, that is a library for manipualting date and time. --}}

                        <p class="mb-2">{{ $post->body }}</p>


                        <div class="flex items-center">
                            <form action="{{ route('posts.destroy', $post) }}" method="POST" class="mr-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>

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
                @endforeach

                {{ $posts->links() }}

            @else
                <p>There are no posts to show!</p>
            @endif
        </div>
    </div>
@endsection
