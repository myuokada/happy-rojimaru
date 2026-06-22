<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment) {
        $this->comment = $comment;
    }

    #store date in comments tables
    public function store(Request $request,$post_id) {
        $request->validate(
            [
                'comment_body' . $post_id => 'required|max:150'
            ],
            [
                'comment_body' . $post_id . '.required' =>'You cannot submit an empty comment.',
                'comment_body' . $post_id . '.max'      =>'The comment must not have more than 150 characters.',
            ]
        );

        $this->comment->body    = $request->input('comment_body' . $post_id);
        // input() -data from the form (name) from a specific input value
        $this->comment->user_id = Auth::user()->id;
        $this->comment->post_id  = $post_id;
        $this->comment->save();

        return redirect()->route('post.show', $post_id);
    }
    public function destroy($comment_id)
    {
        $comment = $this->comment->findOrFail($comment_id);
        $comment->delete();

        return back();
    }
}
