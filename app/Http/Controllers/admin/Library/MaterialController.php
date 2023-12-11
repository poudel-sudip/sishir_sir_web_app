<?php

namespace App\Http\Controllers\Admin\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Library\LibraryCategory;
use App\Models\Library\LibraryMaterial;

class MaterialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(LibraryCategory $category)
    {
        $data = [];
        $data['category'] = $category;
        $data['materials'] = $category->materials;
        
        // dd($data,$category->childs,$category->parent);
        return view('admin.library.materials.index',$data);
    }

    public function create(LibraryCategory $category)
    {
        return view('admin.library.materials.create',compact('category'));
    }

    public function store(LibraryCategory $category, Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            // 'order' => 'numeric|required',
            'status' => 'string|required',
            'type' => 'string|required',
            'thumbnail' => 'image|nullable',
            'search_tags' => 'nullable|string',
            'description' => 'nullable|string',
            'author' => 'nullable|string',
            'published_year' => 'nullable|string',
            'pages' => 'nullable|string',
        ]);

        if($data['type'] == 'text' || $data['type'] == 'Text')
        {
            $request->validate(['description' => 'string|required|min:5']);
            $data['description'] = $request->description;
        }
        elseif($data['type'] == 'file' || $data['type'] == 'File')
        {
            $request->validate([ 
                'file' => 'required|file|mimes:pdf',
                'can_download' => 'required|boolean',
            ]);
            $data['download'] = $request->can_download;
            $data['filename'] = $request->file->getClientOriginalName();
            $data['fileurl'] = $request->file->storeAs('uploads',$data['filename'],'public');
        }

        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }

        $category->materials()->create($data);

        // return redirect('/admin/library/'.$category->id.'/materials');
        return redirect('/admin/library/'.$category->id.'/directories');
    }

    public function show(LibraryCategory $category, LibraryMaterial $material)
    {
        $data[] = [];
        $data['category'] = $category;
        $data['material'] = $material;
        return view('admin.library.materials.show',$data);
    }

    public function edit(LibraryCategory $category, LibraryMaterial $material)
    {
        $data[] = [];
        $data['category'] = $category;
        $data['material'] = $material;
        return view('admin.library.materials.edit',$data);
    }

    public function update(LibraryCategory $category, LibraryMaterial $material, Request $request)
    {
        $request->validate([
            'name' => 'string|required',
            // 'order' => 'numeric|required',
            'status' => 'string|required',
            'file' => 'nullable|file|mimes:pdf',
            'old_file' => 'nullable|string',
            'filename' => 'nullable|string',
            // 'description' => 'string|nullable',
            'type' => 'string|required',
            'thumbnail' => 'image|nullable',
            'old_thumbnail' => 'string|nullable',
            'can_download' => 'required|boolean',
            'search_tags' => 'nullable|string',
            'description' => 'nullable|string',
            'author' => 'nullable|string',
            'published_year' => 'nullable|string',
            'pages' => 'nullable|string',
        ]);
        
        $data = $request->only(['name','order','status','type','search_tags','description','author','published_year','pages']);

        if($data['type'] == 'text' || $data['type'] == 'Text')
        {
            $request->validate(['description' => 'string|required|min:5']);
            $data['filename'] = '';
            $data['fileurl'] = '';
            $data['description'] = $request->description;
        }
        elseif($data['type'] == 'file' || $data['type'] == 'File')
        {
            $data['download'] = $request->can_download;
            if($request->old_file == '' && !isset($request->file))
            {
                return back()->withInput()->withErrors(['file' => 'Please select a pdf file']);
            }
            elseif(isset($request->file))
            {
                $data['filename'] = $request->file->getClientOriginalName();
                $data['fileurl'] = $request->file->storeAs('uploads',$data['filename'],'public');
            }
            else
            {
                $data['fileurl'] = $request->old_file;
                $data['filename'] = $request->filename;
            }
        }
        else {}

        $data['thumbnail'] = $request->old_thumbnail;
        if(isset($request->thumbnail))
        {
            $data['thumbnail'] = $request->thumbnail->store('uploads','public');
        }

        $material->update($data);
        // return redirect('/admin/library/'.$category->id.'/materials');
        return redirect('/admin/library/'.$category->id.'/directories');
    }

    public function destroy(LibraryCategory $category, LibraryMaterial $material, Request $request)
    {
        $material->delete();
        // return redirect('/admin/library/'.$category->id.'/materials');
        return redirect('/admin/library/'.$category->id.'/directories');
    }

}
