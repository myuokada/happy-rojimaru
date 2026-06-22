<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // 1-to-many inverse
    // get the info of the user commented
    public function user() {
        return $this->belongsTo(User::class)->withTrashed();
    }
}
