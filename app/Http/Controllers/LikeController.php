<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like) {
        $this->like = $like;
    }

    #store data for user_id and post_id
    public function store($post_id) {
        $this->like->user_id = Auth::user()->id;//logged in user are thr ones who will like a post
        $this->like->post_id  = $post_id;
        $this->like->save();

        return redirect()->back();
    }

    #unlike
    public function destroy($post_id) {
        $this->like
            ->where('user_id', Auth::user()->id)
            ->where('post_id', $post_id)
            ->delete();

            return redirect()->back();
    }
}
