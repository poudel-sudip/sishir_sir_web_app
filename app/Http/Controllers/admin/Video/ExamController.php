<?php

namespace App\Http\Controllers\admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoExam;
use App\Models\VideoCourse\VideoExamResult;
use App\Models\VideoCourse\VideoExamEvaluation;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCategory;

class ExamController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(VideoCourse $course)
    {
        $exams = $course->exams;
        // dd($course,$exams);
        return view('admin.videocourse.exams.index',compact('course','exams'));
    }

    public function create(VideoCourse $course)
    {
        $categories = ExamCategory::all();
        return view('admin.videocourse.exams.create',compact('course','categories'));
    }

    public function store(Request $request, VideoCourse $course)
    {
        // dd($request->all());
        $request->validate([
            'exam_name' => 'numeric|required|min:1',
        ]);
        $course ->exams()->create([
            'exam_id' => $request->exam_name,
        ]);
        return redirect('/admin/video-course/'.$course->id.'/exams');
    }

    public function destroy(VideoCourse $course, VideoExam $exam)
    {
        // dd($course,$exam);//delete results and evaluations too
        VideoExamEvaluation::where('course_id',$course->id)->where('exam_id',$exam->exam_id)->delete();
        VideoExamResult::where('course_id',$course->id)->where('exam_id',$exam->exam_id)->delete();
        $exam->delete();
        return redirect('/admin/video-course/'.$course->id.'/exams');
    }

    public function results(VideoCourse $course, Exam $exam)
    {
        // dd($course,$exam);
        $results=VideoExamResult::where('course_id',$course->id)->where('exam_id',$exam->id)->get();
        return view('admin.videocourse.exams.results',compact('results','course','exam'));
    }
}
