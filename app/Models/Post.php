<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'body'
    ];

    public function likedBy(User $user)
    {
        // remember: "likes" is collection and contains is a laravel method in it
        return $this->likes->contains('user_id', $user->id);
    }

    /* Moved to PostPolicy, so it is handled by the laravel's authorization */
    // public function ownedBy(User $user)
    // {
    //     return $user->id === $this->user_id;
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
