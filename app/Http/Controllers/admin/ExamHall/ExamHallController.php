<?php

namespace App\Http\Controllers\admin\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallEvaluation;
use App\Models\ExamHall\ExamHallResults;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\ExamHall\ExamHallCQC;

class ExamHallController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories=ExamHallCategories::all();
        return view('admin.examhall.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.examhall.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'title'=>'string|required|min:5',
            'price'=>'required|numeric',
            'discount'=>'required|numeric',
            'description'=>'required|string',
            'status'=>'required|string|min:1',
            'image' => 'required|image',
        ]);

        $image=request('image')->store('uploads','public');

        ExamHallCategories::create([
            'title'=>$request->title,
            'price'=>$request->price,
            'discount'=>$request->discount ?? 0,
            'description'=>$request->description,
            'image'=>$image,
            'status'=>$request->status,
        ]);

        return redirect('/admin/exam-hall');
    }

    public function edit(ExamHallCategories $category)
    {
        return view('admin.examhall.edit',compact('category'));
    }

    public function update(Request $request, ExamHallCategories $category)
    {
        // dd($category,$request->all());
        $request->validate([
            "categoryID" => "required|numeric",
            "title" => "required|string|min:5",
            "price" => "required|numeric",
            'discount'=>'required|numeric',
            'description'=>'required|string',
            "status" => "required|string|min:1",
            'oldImage' =>'string|nullable',
            'image' => 'image|nullable',
            'class_link' => 'url|nullable',
            'isPinned' => 'string|required',
        ]);

        $image=$request->oldImage;
        if(isset($request->image))
        {
            $image=request('image')->store('uploads','public');
        }

        $category->update([
            'title'=>$request->title,
            'price'=>$request->price,
            'discount'=>$request->discount ?? 0,
            'description'=>$request->description,
            'image'=>$image,
            'status'=>$request->status,
            'class_link' => $request->class_link,
            'isPinned' => $request->isPinned,
        ]);
        return redirect('/admin/exam-hall');
    }

    public function destroy(ExamHallCategories $category)
    {
        ExamHallBookings::where('category_id',$category->id)->delete();
        ExamHallEvaluation::where('category_id',$category->id)->delete();
        ExamHallResults::where('category_id',$category->id)->delete();
        $category->category_exams()->delete();

        $category->delete();
        return redirect('/admin/exam-hall');
    }

    public function cqcindex(ExamHallCategories $category)
    {
        // dd($category);
        return view('admin.examhall.cqc',compact('category'));
    }

    public function cqcstore(Request $request, ExamHallCategories $category)
    {
        // dd($request->all(),$category);
        $request->validate(['question' => 'string|required|min:5']);
        $category->cqcs()->create([
            'name'=>auth()->user()->name,
            'question' => $request ->question,
        ]);

        return redirect('/admin/exam-hall/'.$category->id.'/cqc');
    }

    public function cqcdestroy(Request $request, ExamHallCategories $category, ExamHallCQC $cqc)
    {
        // dd($request->all(),$category,$cqc);
        $cqc->delete();
        return redirect('/admin/exam-hall/'.$category->id.'/cqc');
    }
}
