<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VaccancyPost;

class VaccancyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vaccancies = VaccancyPost::orderByDesc('id')->paginate(50);
        return view('admin.careers.index',compact('vaccancies'));
    }

    public function create()
    {
        return view('admin.careers.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'pdf_file' => 'nullable|file',
            'img_file' => 'nullable|image',
            'thumbnail' => 'required|image',
            'status' => 'required|string',
            'search_tags' => 'nullable|string',
        ]);

        $pdf = null;
        $img = null;
        $thumbnail = null;

        if(isset($request->pdf_file))
        {
            $pdf = $request->pdf_file->store('uploads/vaccancy/pdf','public');
        }

        if(isset($request->img_file))
        {
            $img = $request->img_file->store('uploads/vaccancy/pdf','public');
        }

        if(isset($request->thumbnail))
        {
            $thumbnail = $request->thumbnail->store('uploads/vaccancy/thumbnail','public');
        }


        VaccancyPost::create([
            'user_id' => auth()->user()->id ?? null,
            'title' => $request->title,
            'thumbnail' => $thumbnail,
            'pdf_file' => $pdf,
            'img_file' => $img,
            'author' => ucwords($request->author ?? auth()->user()->name),
            'description' => $request->description,
            'status' => $request->status,
            'search_tags' => $request->search_tags,
        ]); 

        return redirect('/admin/careers');
    }

    public function show(VaccancyPost $vaccancy)
    {
        return view('admin.careers.show',compact('vaccancy'));
    }

    public function edit(VaccancyPost $vaccancy)
    {
        return view('admin.careers.edit',compact('vaccancy'));
    }

    public function update(VaccancyPost $vaccancy,Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'clear_pdf_file' => 'nullable',
            'clear_img_file' => 'nullable',
            'old_pdf_file' => 'nullable|string',
            'old_img_file' => 'nullable|string',
            'old_thumbnail' => 'nullable|string',
            'status' => 'required|string',
            'pdf_file' => 'nullable|file',
            'img_file' => 'nullable|file',
            'thumbnail' => 'nullable|image',
            'search_tags' => 'nullable|string',
        ]);
        
        $pdf = $request->old_pdf_file;
        $img = $request->old_img_file;
        $thumbnail = $request->old_thumbnail;

        if(isset($request->clear_pdf_file))
        {
            $pdf = null;
        }
        else
        {
            if(isset($request->pdf_file))
            {
                $pdf = $request->pdf_file->store('uploads/vaccancy/pdf','public');
            }
        }

        if(isset($request->clear_img_file))
        {
            $img = null;
        }
        else
        {
            if(isset($request->img_file))
            {
                $img = $request->img_file->store('uploads/vaccancy/pdf','public');
            }
        }
        

        if(isset($request->thumbnail))
        {
            $thumbnail = $request->thumbnail->store('uploads/vaccancy/thumbnail','public');
        }

        $vaccancy->update([
            'title' => $request->title,
            'thumbnail' => $thumbnail,
            'pdf_file' => $pdf,
            'img_file' => $img,
            'author' => ucwords($request->author ?? auth()->user()->name),
            'description' => $request->description,
            'status'=>$request->status,
            'search_tags' => $request->search_tags,
        ]);

        return redirect('/admin/careers');
    }

    public function destroy(VaccancyPost $vaccancy)
    {
        $vaccancy->delete();
        return redirect('/admin/careers');
    }
}
