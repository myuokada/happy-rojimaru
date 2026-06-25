<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = ['image', 'description', 'user_id', ];

    #A post belongs to a user
    #To get the owner of the post
    #1-many (inverse)
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }

    #To get the categories under a post
    public function categoryPost(){
        return $this->hasMany(CategoryPost::class);
    }

    #1-to-many
    #A post can have many comments
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    #1-many To get the lies of a post
    public function likes() {
        return $this->hasMany(Like::class);
    }

    #Return TRUE if the AUTH user already liked the post
    public function isLiked() {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
        // $this->like - refers to all likes of the post. from that result,we are going to search for the user id of the Auth user. If it exits, it will return TRUE
    }

    //投稿がたくさんお気に入りされる
    public function bookmarks() {
    return $this->hasMany(Bookmark::class);
    }
}
