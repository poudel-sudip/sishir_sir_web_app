<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Gate;

class CourseBatchesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Course $course)
    {
        return view('admin.courses.batches',compact('course'));
    }

    public function display(Course $course)
    {
        $batches= [];
        $active=$course->batches()
            ->where('status','=','Active')
            ->orWhere('status','=','Running')
            ->get();
        foreach($active as $batch)
        {
            $batches[] = array(
                'id'=>$batch->id,
                'name'=>$batch->name,
            );
        }
        return $batches;
    }

    public function tutorCourse(Tutor $tutor)
    {
        $courses=$tutor->specialCourses()->where('status','=','Active')->get();
        dd($tutor,$courses);
    }
}
