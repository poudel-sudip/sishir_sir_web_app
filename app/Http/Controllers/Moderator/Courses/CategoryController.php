<?php

namespace App\Http\Controllers\Moderator\Courses;

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
        return view('moderator.categories.index',compact('categories'));
    }

    public function create()
    {
        return view('moderator.categories.create');
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
        return redirect('/moderator/categories');
    }

    public function destroy(Categories $categories)
    {
        $categories->bookings()->delete();
        $categories->batches()->delete();
        $categories->courses()->delete();
        $categories->delete();
        return redirect('/moderator/categories');
    }

    public function edit(Categories $category)
    {
        return view('moderator.categories.edit',compact('category'));
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
        return redirect('/moderator/categories');
    }

}
