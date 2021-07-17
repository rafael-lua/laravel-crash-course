<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // $posts = Post::get(); // eloquent returns a laravel collection of all posts
        
        // $posts = Post::paginate(25); // The paginate will only return this number of items from the database, so in case of millions, would save a lot of memory/time.
        
        // This is with eager loading to help mitigate N+1 problems (can check queries count with laravel debugbar)
        // "with" receives the relationships from the model, so it eager loads data from them before iterating through
        // $posts = Post::with(['user', 'likes'])->paginate(25);

        // "latest" is a shortcut for "orderBy('created_at', 'desc')"
        $posts = Post::latest()->with(['user', 'likes'])->paginate(25);

        return view('posts.index', [
            'posts' => $posts
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show', [
            'post' => $post
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        // auth()->user()->posts // Without being a function, return a COLLECTION (eloquent) of posts models. Use as function to chain into other methods.
        auth()->user()->posts()->create([
            // user_id is AUTOMATICALLY done by laravel by the "posts" relationship from eloquent.  
            'body' => $request->body
        ]); // The array could also just be $request->only('body') instead!

        return back();
    }

    public function destroy(Post $post)
    {   
        // This can be better made using the laravel's authorization
        // if (!$post->ownedBy(auth()->user())) {
        //     // handle unauthorization here
        // }
        
        // The user is already passed in by default, so you only need to pass the post.
        $this->authorize('delete', $post);

        $post->delete();

        return back();
    }
}
