<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VaccancyPost;
use App\Models\Categories as Category;

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
        $data['tags'] = Category::where('type','vaccancy_tag')->get();
        return view('admin.careers.create',$data);
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
            'related_rags' => 'array|nullable',
            'source' => 'nullable|string',
        ]);

        $pdf = null;
        $img = null;
        $thumbnail = null;
        $related_tags = [];
        if(isset($request->related_tags) && is_array($request->related_tags))
        {
            $related_tags = (array_map('intval', $request->related_tags));
        }

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
            'tag_ids' => $related_tags,
            'source' => $request->source,
        ]); 

        return redirect('/admin/careers');
    }

    public function show(VaccancyPost $vaccancy)
    {
        return view('admin.careers.show',compact('vaccancy'));
    }

    public function edit(VaccancyPost $vaccancy)
    {
        $vaccancy->tag_ids = is_array($vaccancy->tag_ids)
            ? $vaccancy->tag_ids
            : (is_string($vaccancy->tag_ids) ? json_decode($vaccancy->tag_ids, true) : []);

        $data['vaccancy'] = $vaccancy;
        $data['tags'] = Category::where('type','vaccancy_tag')->get();
        return view('admin.careers.edit',$data);
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
            'related_rags' => 'array|nullable',
            'source' => 'nullable|string',
        ]);
        
        $pdf = $request->old_pdf_file;
        $img = $request->old_img_file;
        $thumbnail = $request->old_thumbnail;
        $related_tags = [];
        if(isset($request->related_tags) && is_array($request->related_tags))
        {
            $related_tags = (array_map('intval', $request->related_tags));
        }

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
            'tag_ids' => $related_tags,
            'source' => $request->source,
        ]);

        return redirect('/admin/careers');
    }

    public function destroy(VaccancyPost $vaccancy)
    {
        $vaccancy->delete();
        return redirect('/admin/careers');
    }
}
