<?php

namespace App\Http\Controllers\admin\Forms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Forms\DynamicFormCategory;
use App\Models\Forms\DynamicFormSubCategory;

class SubCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(DynamicFormCategory $category)
    {
        $subcategories = $category->subCategories;
        return view('admin.dynamicforms.subcategories.index',compact('category','subcategories'));
    }

    public function create(DynamicFormCategory $category)
    {
        return view('admin.dynamicforms.subcategories.create',compact('category'));
    }

    public function store(DynamicFormCategory $category, Request $request)
    {
        // dd($request->all());
        $request->validate(['name' => 'string | required | min:1']);
        $category->subCategories()->create(['name' => ucwords($request->name)]);
        return redirect('/admin/dynamic-forms/categories/'.$category->id.'/sub-categories');
    }

    public function destroy(DynamicFormCategory $category, DynamicFormSubCategory $subCategory)
    {
        // dd($category,$subCategory);
        $subCategory->delete();
        return redirect('/admin/dynamic-forms/categories/'.$category->id.'/sub-categories');
    }
}
