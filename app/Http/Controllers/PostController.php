<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    private $post;
    private $category;

    public function __construct(Post $post, Category $category){
        $this->post = $post;
        $this->category = $category;
    }

        #Get all categories needed
    public function create(){
        $all_categories =$this->category->all();//get all categories
        return view('users.posts.create')->with('all_categories', $all_categories);//send data to view(blade)
    }

    #store data to database
    public function store(Request $request) {
        #1. Validate all from data
        $request->validate([
            'category'    => 'required|array|between:1,3', // 画面にあった「(up to 3)」のルール！
            'description' => 'required|min:1|max:1000',
            'image'       => 'required|mimes:jpeg,jpg,png,gif|max:1048',
]);


    #2. Save the post to database
    $this->post->user_id        = Auth::user()->id;
    $this->post->image          = 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image));
    $this->post->description    = $request->description;
    $this->post->save();

    #3. Save the categories to the category_post table
    // $category_post = []; これがいらない意味は？
    foreach($request->category as $category_id) {
        $category_post[] = ['category_id' => $category_id];
        // category_post is an array
    }
    $this->post->categoryPost()->createMany($category_post);
    // 上の$category_post[]がcreateMany($category_post)のこと指してる

    #ここのcategoryPost()->はpost.phpの⇩の部分の事
    // public function ⭐︎categoryPost(){
    //     return $this->hasMany(CategoryPost::class);
    // }

    // We don't need to add post_id because laravel will automatically add it because of"categoryPost"relationship (please check Post Model)
    // createMany  works like create(), expect it accepts 2D array

    #4. Go back to homepage
    return redirect()->route('index');

}

    #show specific post
    public function show($id) {
        $post = $this->post->findOrFail($id);//find $id
        return view('users.posts.show')->with('post', $post);
    }

    #edit specific post
    public function edit($id) {
        $post = $this->post->findOrFail($id);

        #If the AUTH USER is NOT the owner of the post,redirect to homepage.
        if (Auth::user()->id != $post->user->id){
            return redirect()->route('index');
        }

        $all_categories = $this->category->all();//get all categories

        #get all the category IDs of this post. Save in an array
        $selected_categories = []; //array for already selected categories
        foreach($post->categoryPost as $category_post){//loop through all categories under a post (categoryPost relationship)
            $selected_categories[] = $category_post->category_id;
        // １番から順にチェックしたか確認して、TRUEだったらチェック入れときますよーのforeach loop
        }

        return view('users.posts.edit')
        ->with('post', $post)
        ->with('all_categories', $all_categories)
        ->with('selected_categories',$selected_categories);

    }

    #update specific post
    public function update(Request $request, $id)
    {
        $request->validate([
            'category'    => 'required|array|between:1,3',
            'description' => 'required|min:1|max:1000',
            'image'       => 'mimes:jpeg,jpg,png,gif|max:1048',
        ]);

        $post = $this->post->findOrFail($id);

        $post->update([
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            $post->update([
                'image' => 'data:image/' . $request->image->extension() . ';base64,' . base64_encode(file_get_contents($request->image))
            ]);
        }

        $post->categoryPost()->delete();
        $category_post = [];
        foreach ($request->category as $category_id) {
            $category_post[] = ['category_id' => $category_id];
        }

        $post->categoryPost()->createMany($category_post);

        return redirect()->route('post.show', $id);
    }

     public function destroy($id)
    {
        $post = $this->post->findOrFail($id);
        $post->delete();

        return redirect()->route('index');
    }
}
