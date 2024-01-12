<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Gate;

class BlogController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $blogs=Blog::all()->sortByDesc('id');
        return view('admin.blog.index',[
            'blogs'=>$blogs,
        ]);
    }

    public function create()
    {
        return view('admin.blog.create',[]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=>['required','string'],
            'description'=>['required'],
            'status'=>['required'],
            'image'=>['image'],
            'author'=>['nullable'],
            'search_tags'=>['nullable'],
        ]);
        $img=$request->image->store('uploads','public');
        Blog::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status,
            'image'=>$img,
            'author'=>$request->author ?? auth()->user()->name,
            'search_tags' => $request->search_tags,
            'user_id' => auth()->user()->id,
        ]);
        return redirect('/admin/blogs');
    }

    public function show(Blog $blog)
    {
        return view('admin.blog.show',compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.edit',compact('blog'));
    }

    public function update(Blog $blog,Request $request)
    {
        $request->validate([
            'title' =>['required','string'],
            'description' => ['required','string'],
            'old_image' => '',
            'status' => 'min:1',
            'image'=>'',
            'author' => '',
            'search_tags' => '',
        ]);
        $img=$request->old_image;
        if(isset($request->image))
        {
            $img=$request->image->store('uploads','public');
        }
        $blog->update([
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$img,
            'status'=>$request->status,
            'author'=>$request->author ?? auth()->user()->name,
            'search_tags'=>$request->search_tags,
        ]);
        return redirect('/admin/blogs');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect('/admin/blogs');
    }
}
