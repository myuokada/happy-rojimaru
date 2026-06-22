<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; //Categoryの追加

class CategoriesController extends Controller
{
    private $category;

    public function __construct(Category $category) {
        $this->category = $category;
    }

    public function index() {
        $all_categories = $this->category->get();
        $uncategorized_count = \App\Models\Post::doesntHave('categoryPost')->count();
        return view('admin.categories.index')
            ->with('all_categories', $all_categories)
            ->with('uncategorized_count', $uncategorized_count);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|min:1|max:50|unique:categories,name'
        ]);

        $this->category->name = $request->name;
        $this->category->save();

        return redirect()->back();
    }

    public function destroy($id) {
        $category = $this->category->findOrFail($id);
        $category->delete();
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'new_name' => 'required|min:1|max:50|unique:categories,name,' . $id
        ]);
        $category = $this->category->findOrFail($id);
        $category->name = $request->new_name;
        $category->save();

        return redirect()->back();
    }
}
