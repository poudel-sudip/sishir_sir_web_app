<?php

namespace App\Http\Controllers\admin\Video;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCategory;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoBooking;
use App\Models\VideoCourse\VideoExamResult;
use App\Models\VideoCourse\VideoExamEvaluation;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $courses = VideoCourse::all();
        return view('admin.videocourse.course.index',compact('courses'));
    }

    public function create()
    {
        $categories = VideoCategory::where('status','=','Active')->get();
        return view('admin.videocourse.course.create',compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data=request()->validate([
            'name'=>'required|string',
            'description'=>'required|string',
            'status'=>'required|string',
            'isPinned'=>'required|string',
            'thumbnail'=>'required | image',
            'category'=>'required | numeric | min:1',
            'order'=>'required | numeric | min:1',
            'fee' =>'required|numeric',
            'discount'=>'numeric|nullable',
        ]);

        $thumbnail=request('thumbnail')->store('uploads','public');

        VideoCourse::create([
            'name'=>$data['name'],
            'category_id'=>$data['category'],
            'description'=>$data['description'],
            'status'=>$data['status'],
            'isPinned'=>$data['isPinned'],
            'thumbnail'=>$thumbnail,
            'order'=>$data['order'],
            'fee' => $data['fee'],
            'discount' => $data['discount'] ?? 0,
        ]);

        return redirect('/admin/video-course');
    }

    public function show(VideoCourse $course)
    {
        return view('admin.videocourse.course.show',compact('course'));
    }

    public function edit(VideoCourse $course)
    {
        $categories = VideoCategory::where('status','=','Active')->get();
        return view('admin.videocourse.course.edit',compact('course','categories'));
    }

    public function update(Request $request, VideoCourse $course)
    {
        // dd($request->all());
        $data=request()->validate([
            'name'=>'required|string',
            'description'=>'required',
            'status'=>'required|string',
            'isPinned'=>'required|string',
            'thumbnail'=>'image|nullable',
            'old_thumbnail'=>'string|nullable',
            'category'=>'required | numeric | min:1',
            'order'=>'required | numeric | min:1',
            'fee' => 'required|numeric',
            'discount' => 'numeric|nullable',
            'class_link' => 'string|nullable',
            'intro_link' => 'url|nullable',
        ]);

        $thumbnail=$data['old_thumbnail'];
        if(isset($data['thumbnail']))
        {
            $thumbnail=request('thumbnail')->store('uploads','public');
        }

        $course->update([
            'name'=>$data['name'],
            'description'=>$data['description'],
            'status'=>$data['status'],
            'category_id'=>$data['category'],
            'isPinned'=>$data['isPinned'],
            'thumbnail'=>$thumbnail,
            'order'=>$data['order'],
            'fee' => $data['fee'],
            'discount' => $data['discount'] ?? 0,
            'class_link' => $data['class_link'],
            'intro_video' => $data['intro_link'],
        ]);

        return redirect('/admin/video-course');
    }

    public function destroy(VideoCourse $course)
    {
        VideoBooking::where('course_id',$course->id)->delete();
        VideoExamEvaluation::where('course_id',$course->id)->delete();
        VideoExamResult::where('course_id',$course->id)->delete();
        $course->exams()->delete();

        $course->delete();
        return redirect('/admin/video-course');
    }

    public function booking(VideoCourse $course)
    {
        $bookings=$course->bookings;
        return view('admin.videocourse.course.bookings',compact('course','bookings'));
    }
}
