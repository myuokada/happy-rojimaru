<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;

class LikeController extends Controller
{

    public function toggle($post_id)
    {
        $like = Like::where('user_id', Auth::id())
            ->where('post_id', $post_id)
            ->first();

        // すでにいいねしてる → 削除（解除）
        if ($like) {
            $like->delete();

            return response()->json([
                'liked' => false
            ]);
        }

        // まだいいねしてない → 作成
        Like::create([
            'user_id' => Auth::id(),
            'post_id' => $post_id,
        ]);

        return response()->json([
            'liked' => true
        ]);

    }
    public function store($id)
{
    Like::create([
        'user_id' => Auth::id(),
        'post_id' => $id
    ]);

    return back();
}

public function destroy($id)
{
    Like::where('user_id', Auth::id())
        ->where('post_id', $id)
        ->delete();

    return back();
}
}
