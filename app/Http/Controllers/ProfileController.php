<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Bookmark; //myu追加

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    #get specific user
    public function show($id) {
        $user = $this->user->findOrFail($id);

        // myu→このプロフィール画面の主（$id）がお気に入りしたレコードを最新順で全部取ってくる
        $saved_posts = Bookmark::where('user_id', $id)->latest()->get();

        return view('users.profile.show')
            ->with('user', $user)
            ->with('saved_posts', $saved_posts);
    }

    #edit specific user
    public function edit() {
        $user = $this->user->findOrFail(Auth::user()->id);//logged in users are the one whi do the action to edit
        return view('users.profile.edit')->with('user',$user);
    }

    #update profile user
    public function update(Request $request) {
        $request->validate([
            'name'          => 'required|min:1|max:50',
            'email'         => 'required|email|max:50|unique:users,email,' . Auth::user()->id,//unique, table, column, PK value
            'image'         => 'mimes:jpeg,jpg,png,gif|max:1048',
            'introduction'  => 'max:100',
        ]);

        $user                = $this->user->findOrFail(Auth::user()->id);
        $user->name          = $request->name;
        $user->email         = $request->email;
        $user->introduction  = $request->introduction;

        if($request->avatar){
            $user->avatar = 'data:image/' . $request->avatar->extension() . ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $user->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function followers($id) {
        $user = $this->user->findOrFail($id);
        return view('users.profile.followers')->with('user', $user);
    }

     public function following($id) {
        $user = $this->user->with('following.following')->findOrFail($id);
        return view('users.profile.following')->with('user', $user);
    }

    public function likes(Request $request, $id) {
        $user = $this->user->findOrFail($id);
        $postIds = $user->posts()->pluck('id');

        $all_likes_query = \App\Models\Like::whereIn('post_id', $postIds)
                            ->where('user_id', '!=', $id);

        $grouped_likes = $all_likes_query->get()->unique('post_id')->reverse();
        $show_all = $request->query('show_all', false);

        if ($show_all) {
            $likes = $grouped_likes;
        } else {
            $likes = $grouped_likes->take(7);
        }

        $has_more = $grouped_likes->count() > $likes->count();

        return view('users.profile.likes')
            ->with('user', $user)
            ->with('likes', $likes)
            ->with('has_more', $has_more);
    }

    public function bookmarks($id) {
        $user = $this->user->findOrFail($id);

        $bookmarks = \App\Models\Bookmark::where('user_id', $id)->latest()->get();

        return view('users.profile.bookmarks')
            ->with('user', $user)
            ->with('bookmarks', $bookmarks);
    }
}

