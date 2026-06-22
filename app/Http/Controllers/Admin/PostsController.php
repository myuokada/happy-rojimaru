<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller
{
    private $post;

    public function __construct(Post $post) {
        $this->post = $post;
    }

    #get all posts
    public function index() {
        $all_posts = $this->post->withTrashed()->latest()->get();//->get();追加
        // withTrashed() - include the soft deleted records in a query's result
        return view('admin.posts.index')->with('all_posts', $all_posts);
    }

    #deactivate a user
    public function hidden($id) {
        $this->post->destroy($id);//delete a usera
        return redirect()->back();
    }

    #activate a user
    public function visible($id) {
        $this->post->onlyTrashed()->findOrFail($id)->restore();
        // onlyTrashed() -retrieves soft deleted records only
        // restore() - This will "un-delete" aa soft deleted data. This will set the "delete_at" column to null
        return redirect()->back();
    }
}
