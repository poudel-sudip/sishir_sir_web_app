<?php

namespace App\Http\Controllers\admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCategory;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = VideoCategory::all();
        return view('admin.videocourse.category.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.videocourse.category.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required |string',
        ]);

        VideoCategory::create([
            'name'=>$request->name,
            'status'=>$request->status,
            'order'=>$request->order,
        ]);
        return redirect('/admin/video-category');
    }

    public function edit(VideoCategory $category)
    {
        return view('admin.videocourse.category.edit',compact('category'));
    }

    public function update(Request $request, VideoCategory $category)
    {
        $data=$request->validate([
            'name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required |string',
        ]);
        $category->update([
            'name'=>$data['name'],
            'status'=>$data['status'],
            'order'=>$data['order'],
        ]);
        return redirect('/admin/video-category');
    }

    public function destroy(VideoCategory $category)
    {
        $category->delete();
        return redirect('/admin/video-category');
    }
}
