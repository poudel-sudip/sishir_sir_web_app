<?php

namespace App\Http\Controllers\Admin\Career;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories as Category;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Category::where('type','=','vaccancy_category')->get();
        return view('admin.careers.category.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.careers.category.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'string|required']);
        Category::create(['name'=>$request->name,'type'=>'vaccancy_category','status'=>'Active']);
        return redirect('/admin/careers-category');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category_id'=>'numeric|required',
            'category_name'=>'string|required'
        ]);

        $category = Category::find($request->category_id);
        if($category)
        {
            $category->update(['name'=>ucwords($request->category_name)]);
        }

        return redirect('/admin/careers-category');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect('/admin/careers-category');
    }

    public function vaccancies(Category $category)
    {
        $vaccancies = $category->vaccancies()->orderByDesc('id')->paginate(50);
        return view('admin.careers.category.vaccancies',compact('category','vaccancies'));
    }

}
