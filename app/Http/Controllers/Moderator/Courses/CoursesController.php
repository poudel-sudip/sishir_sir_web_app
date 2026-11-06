<?php

namespace App\Http\Controllers\Moderator\Courses;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CoursesController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Categories $category)
    {
        return view('moderator.courses.index',[
            'courses'=>Course::withCount('batches')
                ->where(function($c){
                    $c->where('user_id','=',auth()->user()->id)
                    ->orWhereHas('batches',function($b){
                        $b->where('user_id','=',auth()->user()->id);
                    });
                })
                ->orderByDesc('id')
                ->get(['id','name','status','isPopular','order']),
        ]);
    }

    public function create()
    {
        // $categories= Categories::all()->where('status','=','Active');
        $data = [];
        return view('moderator.courses.create',$data);
    }

    public function show(Course $course)
    {
        return view('moderator.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        if($course->user_id != auth()->user()->id)
        {
            abort(403, 'You are not authorized to update this data.');
        }

        $data = [];
        $data['course'] = $course;
        // $categories= Categories::all()->where('status','=','Active');

        return view('moderator.courses.edit', $data);
    }

    public function store()
    {
        $data = request()->validate([
            'name'=>'required',
            'description'=>'required',
            'details'=>'required | string',
            'status'=>'required',
            'isPopular'=>'required',
            'courseImage'=>'required | image',
            // 'category'=>'required | min:1',
            'order'=>'required | numeric | min:1',
        ]);

        $imagePath = request('courseImage')->store('uploads/courses/thumbnails','public');

        Course::create([
            'name'=>$data['name'],
            // 'category_id'=>$data['category'],
            'description'=>$data['description'],
            'detail'=>$data['details'],
            'status'=>$data['status'],
            'isPopular'=>$data['isPopular'],
            'image'=>$imagePath,
            'order'=>$data['order'],
            'user_id' => auth()->user()->id,
        ]);

        return redirect('/moderator/courses');
    }

    public function update(Course $course)
    {
        $data = request()->validate([
            'name'=>'required',
            'description'=>'required',
            'details'=>'required',
            'status'=>'required',
            'isPopular'=>'required',
            'courseImage'=>'',
            'oldImage'=>'',
            // 'category'=>'required | min:1',
            'order'=>'required | numeric | min:1',
        ]);

        $imagePath = $data['oldImage'];
        if(isset($data['courseImage']))
        {
            $imagePath = request('courseImage')->store('uploads/courses/thumbnails','public');
        }
        $course->update([
            'name'=>$data['name'],
            'description'=>$data['description'],
            'detail'=>$data['details'],
            'status'=>$data['status'],
            // 'category_id'=>$data['category'],
            'isPopular'=>$data['isPopular'],
            'image'=>$imagePath,
            'order'=>$data['order'],
        ]);
        return redirect('/moderator/courses');
    }

    public function destroy(Course $course)
    {
        if($course->batches()->count() > 0)
        {
            abort(403, 'Please Delete Associated Batches First');
        }

        if($course->user_id != auth()->user()->id)
        {
            abort(403, 'You are not authorized to delete this data.');
        }

        $course->bookings()->delete();
        $course->batches()->delete();
        // $course->features()->delete();
        $course->delete();
        return redirect('/moderator/courses');
    }
}
