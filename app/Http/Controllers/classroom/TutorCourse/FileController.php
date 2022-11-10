<?php

namespace App\Http\Controllers\classroom\TutorCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutors\SpecialCourse;
use App\Models\Tutors\TutorClassFile;

class FileController extends Controller
{
    public function index(SpecialCourse $course)
    {
        if(auth()->user()->role=='Admin'){
            $header='admin.layouts.app';
        }elseif (auth()->user()->role=='Student'){
            $header='student.layouts.app';
        }elseif (auth()->user()->role=='Tutor'){
            $header='tutors.layouts.app';
        }else{
            $header='layouts.app';
        }

        return view('specialCourseClassroom.files',compact('course','header'));
    }

    public function store(SpecialCourse $course)
    {

        $data=request()->validate([
            'filetitle'=>'string | required',
            'userfile'=>'required',
        ]);
        $filepath=request('userfile')->store('uploads/files','public');
        $course->files()->create([
            'user_id'=>auth()->user()->id,
            'user_name'=>auth()->user()->name,
            'fileTitle'=>$data['filetitle'],
            'filePath'=>$filepath,
        ]);
        return redirect('/special-course/classroom/files/'.$course->id);
    }

    public function view($id)
    {
        return TutorClassFile::find($id);
    }

    public function destroy(SpecialCourse $course, TutorClassFile $file)
    {
        $file->delete();
        return redirect('/special-course/classroom/files/'.$course->id);
    }

}
