<?php

namespace App\Http\Controllers\Admin\Courses;

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
        return view('admin.courses.index',[
            'courses'=>Course::all(),
        ]);
    }

    public function create()
    {
        $categories= Categories::all()->where('status','=','Active');
        return view('admin.courses.create', compact('categories'));
    }

    public function show(Course $course)
    {
        return view('admin.courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $categories= Categories::all()->where('status','=','Active');

        return view('admin.courses.edit', compact('course','categories'));
    }

    public function store()
    {
        $data=request()->validate([
            'name'=>'required',
            'description'=>'required',
            'details'=>'required | string',
            'status'=>'',
            'isPopular'=>'required',
            'courseImage'=>'required | image',
            'category'=>'required | min:1',
            'order'=>'required | numeric | min:1',
        ]);

        $imagePath=request('courseImage')->store('uploads','public');
        Course::create([
            'name'=>$data['name'],
            'category_id'=>$data['category'],
            'description'=>$data['description'],
            'detail'=>$data['details'],
            'status'=>$data['status'],
            'isPopular'=>$data['isPopular'],
            'image'=>$imagePath,
            'order'=>$data['order'],
        ]);

        return redirect('/admin/courses');
    }

    public function update(Course $course)
    {
        $data=request()->validate([
            'name'=>'required',
            'description'=>'required',
            'details'=>'required',
            'status'=>'',
            'isPopular'=>'required',
            'courseImage'=>'',
            'oldImage'=>'',
            'category'=>'required | min:1',
            'order'=>'required | numeric | min:1',
        ]);

        $imagePath=$data['oldImage'];
        if(isset($data['courseImage']))
        {
            $imagePath=request('courseImage')->store('uploads','public');
        }
        $course->update([
            'name'=>$data['name'],
            'description'=>$data['description'],
            'detail'=>$data['details'],
            'status'=>$data['status'],
            'category_id'=>$data['category'],
            'isPopular'=>$data['isPopular'],
            'image'=>$imagePath,
            'order'=>$data['order'],
        ]);
        return redirect('/admin/courses');
    }

    public function destroy(Course $course)
    {
        $course->bookings()->delete();
        $course->batches()->delete();
        $course->features()->delete();
        $course->delete();
        return redirect('/admin/courses');
    }
}
