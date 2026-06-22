<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $all_posts = $this->post->latest()->get();
        $home_posts = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUser();
        return view('users.home')
            ->with('home_posts', $home_posts)
            ->with('suggested_users', $suggested_users);

    }

    #Filter homepage. Show posts for auth's user and from followed users
    public function getHomePosts() {
        $all_posts = $this->post->latest()->get(); //det all post from latest posted
        $home_posts = []; //array dor the auth's posts and followed users

        foreach($all_posts as $post) {
            if($post->user->isFollowed() || $post->user->id === Auth::user()->id){
                //if posts are from followed posts will be inside the array
                $home_posts[] = $post;
            }
        }
        return $home_posts; //return array
    }

    #Get the users that the AUTH USER is not following
    public function getSuggestedUser() {
        $all_users = $this->user->all()->except(Auth::user()->id);//get al users expect logged in user
        $suggested_users = []; //array for users auth user is not following

        foreach($all_users as $user){//loop through all users
            if(!$user->isFollowed()){//if the AUTH USER is not following that user
            $suggested_users[] = $user;
            }
    }
    return $suggested_users;//return array
    }

    public function search(Request $request) {
        $users = $this->user->where('name', 'like', '%' .$request->search.'%')->get();
        return view('users.search')->with('users', $users)->with('search', $request->search);
    }
}
