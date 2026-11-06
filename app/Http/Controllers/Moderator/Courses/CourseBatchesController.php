<?php

namespace App\Http\Controllers\Moderator\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseBatchesController extends Controller
{
    public function index(Course $course)
    {
        return view('moderator.courses.batches',compact('course'));
    }

    public function display(Course $course)
    {
        $batches = $course->batches()
        ->where('user_id','=',auth()->user()->id)
        ->whereIn('status',['Active','Running'])
        ->get(['id','name','slug','fee','discount','status']);
    
        return response()->json([
            'batches' => $batches,
            'success' => true,
        ]);
    }

}
