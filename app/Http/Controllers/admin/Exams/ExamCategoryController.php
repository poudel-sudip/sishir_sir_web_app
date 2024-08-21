<?php

namespace App\Http\Controllers\Admin\Exams;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exams\ExamCategory;

class ExamCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = ExamCategory::all();
        return view('admin.exams.category.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.exams.category.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'string|required']);
        ExamCategory::create(['title'=>$request->name]);
        return redirect('/admin/exam-category');
    }

    public function update(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'category_id'=>'numeric|required',
            'category_name'=>'string|required'
        ]);

        $category = ExamCategory::find($request->category_id);
        if($category)
        {
            $category->update(['title'=>ucwords($request->category_name)]);
        }

        return redirect('/admin/exam-category');
    }

    public function destroy(ExamCategory $category)
    {
        $category->delete();
        return redirect('/admin/exam-category');
    }

    public function exams(ExamCategory $category)
    {
        $exams = $category->exams;
        return view('admin.exams.category.exams',compact('category','exams'));
    }

    public function catExams(ExamCategory $category)
    {
        $exams = $category->exams()->where('status','=','Active')->get();
        return $exams;
    }
}
