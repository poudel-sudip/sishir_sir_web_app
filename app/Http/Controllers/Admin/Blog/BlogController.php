<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;
use App\Models\Categories as Category;

class BlogController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $blogs=Blog::orderByDesc('id')->get(['id','category_id','title','created_at','author','status']);
        return view('admin.blog.index',[
            'blogs'=>$blogs,
        ]);
    }

    public function create()
    {
        $data['categories'] = Category::where('type','=','blog-category')->get(['id','name']);
        return view('admin.blog.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category'=>['numeric','nullable'],
            'title'=>['required','string'],
            'description'=>['required'],
            'status'=>['required'],
            'image'=>['image'],
            'show_image' => ['required','boolean'],
            'author'=>['nullable'],
            'search_tags'=>['nullable'],
            'author_image' => ['image','nullable'],
        ]);
        $img=$request->image->store('uploads','public');
        $authimg = null;
        if(isset($request->author_image))
        {
            $authimg = $request->author_image->store('uploads','public');
        }

        $blog = Blog::create([
            'category_id'=>$request->category,
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status,
            'image'=>$img,
            'show_image' => $request->show_image ?? 0,
            'author'=>$request->author ?? auth()->user()->name,
            'authorimage' => $authimg,
            'search_tags' => $request->search_tags,
            'user_id' => auth()->user()->id,
        ]);

        if($blog->category)
        {
            return redirect('/admin/blogs/categories/'.$blog->category_id.'/posts');
        }
        return redirect('/admin/blogs');
    }

    public function show(Blog $blog)
    {
        return view('admin.blog.show',compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $data['blog'] = $blog;
        $data['categories'] = Category::where('type','=','blog-category')->get(['id','name']);

        return view('admin.blog.edit',$data);
    }

    public function update(Blog $blog,Request $request)
    {
        $request->validate([
            'category'=>['numeric','nullable'],
            'title' =>['required','string'],
            'description' => ['required','string'],
            'old_image' => '',
            'status' => 'min:1',
            'image'=>'image|nullable',
            'show_image' => ['required','boolean'],
            'author' => '',
            'search_tags' => '',
            'author_image' => 'image|nullable',
            'old_author_image' => 'string|nullable',
        ]);
        $img=$request->old_image;
        if(isset($request->image))
        {
            $img=$request->image->store('uploads','public');
        }
        $authimg=$request->old_author_image;
        if(isset($request->author_image))
        {
            $authimg=$request->author_image->store('uploads','public');
        }
        $blog->update([
            'category_id'=>$request->category,
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$img,
            'show_image' => $request->show_image ?? 0,
            'status'=>$request->status,
            'author'=>$request->author ?? auth()->user()->name,
            'authorimage' => $authimg,
            'search_tags'=>$request->search_tags,
        ]);

        if($blog->category)
        {
            return redirect('/admin/blogs/categories/'.$blog->category_id.'/posts');
        }

        return redirect('/admin/blogs');
    }

    public function destroy(Blog $blog)
    {
        $category_id = $blog->category->id ?? null;
        $blog->delete();

        if($category_id)
        {
            return redirect('/admin/blogs/categories/'.$category_id.'/posts');
        }
        return redirect('/admin/blogs');
    }
}
