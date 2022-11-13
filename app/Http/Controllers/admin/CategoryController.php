<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {   $categories= Categories::all();
        return view('admin.categories.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store()
    {
        $data=request()->validate([
            'name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required',
        ]);
        Categories::create([
            'name'=>$data['name'],
            'status'=>$data['status'],
            'order'=>$data['order'],
        ]);
        return redirect('/admin/categories');
    }

    public function destroy(Categories $categories)
    {
        $categories->bookings()->delete();
        $categories->batches()->delete();
        $categories->courses()->delete();
        $categories->delete();
        return redirect('/admin/categories');
    }

    public function edit(Categories $category)
    {
        return view('admin.categories.edit',compact('category'));
    }

    public function update(Categories $category, Request $request)
    {
       $data=$request->validate([
            'name'=>'required | string',
            'order'=>'required | numeric',
            'status'=>'required',
        ]);
        $category->update([
            'name'=>$data['name'],
            'status'=>$data['status'],
            'order'=>$data['order'],
        ]);
        return redirect('/admin/categories');
    }

}
