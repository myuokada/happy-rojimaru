<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    // 💡 お気に入り保存する処理
    public function store($post_id) {
        Bookmark::create([
            'user_id' => Auth::id(),
            'post_id' => $post_id,
        ]);

        return redirect()->back();
    }

    // 💡 お気に入りを解除する処理
    public function destroy($post_id) {
        $bookmark = Bookmark::where('user_id', Auth::id())->where('post_id', $post_id)->first();

        if ($bookmark) {
            $bookmark->delete();
        }

        return redirect()->back();
    }
}
