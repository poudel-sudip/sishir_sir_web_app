<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Course;
use App\Models\Batch;
use Auth;
use App\Helpers\Helper;

class FrontCourseController extends Controller
{
    public function courseBatchList()
    {
        $data = [];
        $data['courses'] = Course::where('status','=','Active')
        ->whereHas('batches',function($batch){
            $batch->whereIn('batches.status',['Active','Running']);
        })
        ->orderBy('id','desc')
        ->get(['id','name'])
        ->values();

        $batches = Batch::whereIn('status', ['Active','Running'])
            ->orderBy('id','desc')
            ->paginate(12, ['id','course_id','name','status','fee','discount','duration','durationType','image']);

        $batches->getCollection()->transform(function($b) {
            $b->final_price = $b->fee - $b->discount;
            $b->discount = $b->discount > 0 ? intval((($b->discount / $b->fee) * 100)) : 0;
            $b->duration = $b->duration . ' ' . ucwords($b->durationType);
            unset($b->durationType, $b->course_id);
            return $b;
        });

        $data['batches'] = $batches;


        // dd($data);
        return view('front.course.batch-list',$data);
    }

    public function categoryCourseBatchList(Request $request, $id)
    {
        $course = Course::where('status','=','Active')->where('id','=',$id)->first(['id','name']);
        if(!$course){
            abort(404,'Course not found');
        }

        $data = [];
        $data['selected_course'] = $course;
        $data['courses'] = Course::where('status','=','Active')
        ->whereHas('batches',function($batch){
            $batch->whereIn('batches.status',['Active','Running']);
        })
        ->orderBy('id','desc')
        ->get(['id','name'])
        ->values();

        $batches = $course->batches()->whereIn('batches.status', ['Active','Running'])
            ->orderBy('id','desc')
            ->paginate(12, ['id','course_id','name','status','fee','discount','duration','durationType','image']);

        $batches->getCollection()->transform(function($b) {
            $b->final_price = $b->fee - $b->discount;
            $b->discount = $b->discount > 0 ? intval((($b->discount / $b->fee) * 100)) : 0;
            $b->duration = $b->duration . ' ' . ucwords($b->durationType);
            unset($b->durationType, $b->course_id);
            return $b;
        });

        $data['batches'] = $batches;


        // dd($data);
        return view('front.course.course-batch-list',$data);
    }

    public function courseBatchDetails(Request $request, $id)
    {

        $batch = Batch::with('course:id,category_id,name,detail','course.category:id,name')
        ->whereIn('status', ['Active','Running'])
            ->where('id','=',$id)
            ->first();

        if(!$batch){
            abort(404,'Course Batch not found');
        }
        
        $batch->final_price = $batch->fee - $batch->discount;
        $batch->discount = $batch->discount > 0 ? intval((($batch->discount / $batch->fee) * 100)) : 0;
        $batch->duration = $batch->duration . ' ' . ucwords($batch->durationType);
        // $batch->users = $batch->customers('count');
        $batch->file_count = $batch->classFiles()->count();
        $batch->video_count = $batch->classVideos()->count();
        // $batch->mcq_count = $batch->batchExams()->whereHas('exam')->count();
        // $batch->written_count = $batch->batchWrittenExams()->whereHas('exam')->count();

        $batch->curriculum_list = $batch->curriculums()
        ->where('status','=',1)
        ->orderBy('title')
        ->get(['id','title','is_heading'])
        ->values();
        
        
        unset($batch->durationType);

        $data = [];
        $data['batch'] = $batch;
        $data['is_student_logged_in'] = Auth::check() && Auth::user()->role == 'Student';
        
        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtype = 'article';
        $data['counterData'] = Helper::pageCounterCounts($batch->name,$pgurl,$pgtype);

        // dd($data);
        return view('front.course.batch-details',$data);
    }
}
