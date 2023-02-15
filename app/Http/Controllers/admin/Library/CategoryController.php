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
        $categories = LibraryCategory::all();
        $data['categories'] = $categories;
        // dd($data);
        return view('admin.library.category.index',$data);
    }

    public function create()
    {
        return view('admin.library.category.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
        ]);

        LibraryCategory::create($data);

        return redirect('/admin/library');
    }

    public function edit(LibraryCategory $category)
    {
        $data[] = [];
        $data['group'] = $category;
        return view('admin.library.category.edit',$data);
    }

    public function update(LibraryCategory $category, Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required',
            'order' => 'numeric|required',
            'status' => 'string|required',
        ]);

        $category->update($data);
        return redirect('/admin/library');
    }

    public function destroy(LibraryCategory $category, Request $request)
    {
        $category->materials()->delete();
        $category->delete();
        return redirect('/admin/library');
    }
}
