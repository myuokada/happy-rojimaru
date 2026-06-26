<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Like;
use App\Models\Post;

class LikeController extends Controller
{
    public function toggle()
    {
        $like = Like::where('user_id', Auth::id())
            ->where('post_id', $this->post->id)
            ->first();

        if ($like) {
            Like::where('user_id', Auth::id())
                ->where('post_id', $this->post->id)
                ->delete();

            $this->liked = false;
            $this->dispatch('unliked');
        } else {
            Like::create([
                'user_id' => Auth::id(),
                'post_id' => $this->post->id,
            ]);

            $this->liked = true;
            $this->dispatch('liked');
        }

        $this->likesCount = Like::where(
            'post_id',
            $this->post->id
        )->count();
    } // 👈 toggle関数はここで終わり

    // 💡 はみ出していたstoreとdestroyを、クラスの波カッコ「 } 」の内側に引っ越しさせました！
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
