<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories as Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::where('type','=','blog-category')->get();
        // dd($categories);
        return view('admin.blog.categories',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['category'=> 'string|required|min:2']);
        Category::create([
            'name' => $request->category,
            'type' => 'blog-category',
            'status' => 'active',
        ]);

        return redirect('/admin/blogs/categories');
    }

    public function update(Request $request)
    {
        $request->validate([
            'category_id' => 'numeric|required|min:1',
            'category_name' => 'string|required',
        ]);
        Category::where('type','=','blog-category')
        ->find($request->category_id)
        ->update(['name'=>$request->category_name]);

        return redirect('/admin/blogs/categories');
    }

    public function destroy($category)
    {
        $category = Category::where('type','=','blog-category')->find($category);
        if($category)
        {
            $category->delete();
        }
        
        return redirect('/admin/blogs/categories');
    }

    public function blogPosts($category)
    {
        $category = Category::where('type','=','blog-category')->find($category);
        if(!$category)
        {
            abort(404,'Category not found');
        }
        $blogs = $category->blogs()->get(['id','category_id','title','created_at','author','status']);
        return view('admin.blog.category_blogs',compact('blogs','category'));
    }
}
