<?php

namespace App\Http\Controllers\admin\Audio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audio\AudioCategory;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = AudioCategory::all();
        return view('admin.audios.category.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.audios.category.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'string|required']);
        AudioCategory::create(['name'=>$request->name]);
        return redirect('/admin/audios');
    }

    public function destroy(AudioCategory $category)
    {
        $category->delete();
        return redirect('/admin/audios');
    }

    public function edit(AudioCategory $category)
    {
        return view('admin.audios.category.edit',compact('category'));
    }

    public function update(Request $request, AudioCategory $category)
    {
        $request->validate(['name'=>'string|required']);
        $category->update(['name'=>$request->name]);
        return redirect('/admin/audios');
    }

}
