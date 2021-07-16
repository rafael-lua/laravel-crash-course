<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::get(); // eloquent returns a laravel collection of all posts

        return view('posts.index', [
            'posts' => $posts
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
}
