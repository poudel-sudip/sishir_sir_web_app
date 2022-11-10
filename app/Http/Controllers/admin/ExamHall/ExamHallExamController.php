<?php

namespace App\Http\Controllers\admin\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCategory;
use App\Models\ExamHall\ExamHallExams;
use App\Models\ExamHall\ExamHallResults;
use App\Models\ExamHall\ExamHallEvaluation;

class ExamHallExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ExamHallCategories $category)
    {
        $catexams=$category->category_exams;
        // dd($category,$catexams);
        return view('admin.examhall.exams.index',compact('category','catexams'));
    }

    public function create(ExamHallCategories $category)
    {
        $categories = ExamCategory::all();
        return view('admin.examhall.exams.create',compact('category','categories'));
    }

    public function store(Request $request, ExamHallCategories $category)
    {
        // dd($category,$request->all());
        $request->validate([
            'title'=>'string|required',
            'exam_name'=>'required|numeric|min:1',
        ]);
        $category->category_exams()->create(['exam_id'=>$request->exam_name]);
        return redirect('/admin/exam-hall/'.$category->id.'/exams');
    }

    public function destroy(Request $request, ExamHallCategories $category, ExamHallExams $exam)
    {
        // dd($request->all(),$category,$exam);
        ExamHallEvaluation::where('category_id',$category->id)->where('exam_id',$exam->exam_id)->delete();
        ExamHallResults::where('category_id',$category->id)->where('exam_id',$exam->exam_id)->delete();
        $exam->delete();
        return redirect('/admin/exam-hall/'.$category->id.'/exams');
    }

    public function results(ExamHallCategories $category, Exam $exam)
    {
        // dd($category,$exam);
        $results=ExamHallResults::where('category_id',$category->id)->where('exam_id',$exam->id)->get();
        return view('admin.examhall.exams.results',compact('results','category','exam'));
    }
}
