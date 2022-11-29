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
        $blogs=Blog::all()->sortByDesc('created_at');
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
        ]);
        $img=$request->image->store('uploads','public');
        Blog::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'status'=>$request->status,
            'image'=>$img,
            'author'=>auth()->user()->name,
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
        ]);
        return redirect('/admin/blogs');
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect('/admin/blogs');
    }
}
