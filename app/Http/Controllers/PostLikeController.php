<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\PostLiked;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostLikeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function store(Post $post)
    {
        // $post comes from the model binding.

        if($post->likedBy(auth()->user())) {
            return response(null, 409);
        }

        $post->likes()->create([
            'user_id' => auth()->user()->id
        ]);

        // using softDelete to only send email if the user didn't like the post before, so it doesn't spam.
        if (!$post->likes()->onlyTrashed()->where('user_id', auth()->user()->id)->count()) {
            // "to" can also be an email. Here will be email of the person who owns the post.
            Mail::to($post->user)->send(new PostLiked(auth()->user(), $post));
        }

        return back();
    }

    public function destroy(Post $post)
    {
        auth()->user()->likes()->where('post_id', $post->id)->delete();
        
        return back();
    }
}
