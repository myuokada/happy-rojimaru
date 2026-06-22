<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Follow;
use Illuminate\Support\Facades\Redirect;
use PHPUnit\Framework\MockObject\ReturnValueNotConfiguredException;

class FollowController extends Controller
{
    private $follow;

    public function __construct(Follow $follow) {
        $this->follow = $follow;
    }

    // public function store($user_id) {

    // $this->follow->follower_id = Auth::user()->id;
    // $this->follow->following_id = $user_id;
    // $this->follow->save();

    // return redirect()->back();
    // }

    public function store($user_id) {
    $this->follow->create([
        'follower_id'  => Auth::user()->id,
        'following_id' => $user_id
    ]);

    return redirect()->back();
}

    #unfollow user
    public function destroy($user_id) {
        $this->follow
        ->where('follower_id', Auth::user()->id)
        ->where('following_id', $user_id)
        ->delete();

        return Redirect()->back();
    }


}
