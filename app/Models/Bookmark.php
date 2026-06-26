<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    use HasFactory;

    // ['user_id', 'post_id'];共有するよー
    protected $fillable = ['user_id', 'post_id'];

    //誰(user)のお気に入りか
    public function user() {
        return $this->belongsTo(User::class);
    }

    //このお気に入りはどのpostか
    public function post() {
        return $this->belongsTo(Post::class);
    }
}
