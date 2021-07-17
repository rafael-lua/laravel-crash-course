@extends('layouts.app')

@section('content')
    <div class="flex justify-center">
        <div class="w-8/12">
            <div class="p-6">
                <h1 class="text-2xl font-medium mb-1">{{ $user->name }}</h1>
                <p>Posted: {{ $posts->count() }} {{ Str::plural('post', $posts->count()) }} and received
                    {{ $user->receivedLikes->count() }} {{ Str::plural('like', $user->receivedLikes->count()) }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg">
                @if ($posts->count())
                    @foreach ($posts as $post)
                        {{-- x-NameOfComponent --}}
                        <x-post :post="$post" :showButton="true" />
                    @endforeach

                    {{ $posts->links() }}

                @else
                    <p>There are no posts to show!</p>
                @endif
            </div>
        </div>
    </div>
@endsection
