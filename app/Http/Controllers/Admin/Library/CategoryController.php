<?php

namespace App\Http\Controllers\Admin\Library;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Library\LibraryCategory;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = [];
        $data['category'] = null;
        $categories = LibraryCategory::where('parent_id','=',null)->orderBy('name')->get();
        $data['categories'] = $categories;
        // dd($data);
        return view('admin.library.category.index',$data);
    }

    private function getSubChildCategories($categories,$parentID = null)
    {
        $subChildCategories = collect();

        foreach ($categories as $category) {

            if (!$category->childs()->count()) {
                // Include immediate child if no further children
                if($category->parent_id == $parentID)
                {
                    $category->name = $category->parent->name.' :: '.$category->name;
                    unset($category->parent);
                }

                $subChildCategories->push($category);
                

            } else {
                // Recursively fetch sub-child categories of these children
                $subChildCategories = $subChildCategories->merge($this->getSubChildCategories($category->childs()->get(['id','parent_id','name']),$category->id));
            }
           
        }

        return $subChildCategories;
    }

    public function getSubMaterialsJson(LibraryCategory $category)
    {      
        $sub_lib = [];
        $pdf_files = [];
        if(!$category->childs()->count())  
        {
            $pdf_files = $category->materials()->get(['id','name','filename','status']);

        }
        else
        {
            $sub_lib = $this->getSubChildCategories($category->childs()->get(['id','parent_id','name']));
        }

        
        return response()->json(
            [
                'sub_libraries' => $sub_lib,
                'pdf_files' => $pdf_files,
            ]
        , 200);
    }

    public function getChilds(LibraryCategory $category)
    {
        $data = [];
        $data['category'] = $category;
        $data['categories'] = $category->childs->sortBy('name');
        return view('admin.library.category.index',$data);
    }

    // public function create()
    // {
    //     return view('admin.library.category.create');
    // }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'folderName' => 'required|string',
            'parent' => 'numeric|nullable',
        ]);

        LibraryCategory::create([
            'name' => $request->folderName,
            'parent_id' => $request->parent ?? null,
            'status' => 'Active',
        ]);

        if($request->parent)
        {
            return redirect('/admin/library/'.$request->parent.'/directories');
        }
        else
        {
            return redirect('/admin/library'); 
        }

        // $data = $request->validate([
        //     'name' => 'string|required',
        //     'order' => 'numeric|required',
        //     'status' => 'string|required',
        // ]);

        // LibraryCategory::create($data);

        // return redirect('/admin/library');
    }

    // public function edit(LibraryCategory $category)
    // {
    //     $data[] = [];
    //     $data['group'] = $category;
    //     return view('admin.library.category.edit',$data);
    // }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "folder_id" => "required|numeric",
            "folder_name" => "required|string",
        ]);

        $category = LibraryCategory::find($request->folder_id);
        if($category)
        {
            $category->update([
                'name' => ucwords($request->folder_name),
            ]);

            if($category->parent_id)
            {
                return redirect('/admin/library/'.$category->parent_id.'/directories'); 
            }
        }

        return redirect('/admin/library');


        // $data = $request->validate([
        //     'name' => 'string|required',
        //     'order' => 'numeric|required',
        //     'status' => 'string|required',
        // ]);

        // $category->update($data);
        // return redirect('/admin/library');
    }

    public function destroy(LibraryCategory $category, Request $request)
    {
        // dd($request->all());
        $category->childs()->delete();
        $category->materials()->delete();
        $category->delete();

        if($request->parent)
        {
            return redirect('/admin/library/'.$request->parent.'/directories');
        }
        else
        {
            return redirect('/admin/library'); 
        }
    }
}
