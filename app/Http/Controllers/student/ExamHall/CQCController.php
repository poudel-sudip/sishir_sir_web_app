<?php

namespace App\Http\Controllers\Student\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallCategories;

class CQCController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ExamHallCategories $category)
    {
        // dd($category,$category->cqcs);
        return view('student.examhall.cqc.cqc',compact('category'));
    }

    public function store(Request $request, ExamHallCategories $category)
    {
        // dd($request->all(),$category);
        $request->validate(['question' => 'required|string|min:5']);
        $category->cqcs()->create([
            'name'=>auth()->user()->name,
            'question' => $request->question,
        ]);

        return redirect('/student/exam-bookings/'.$category->id.'/cqc');
    }
}
