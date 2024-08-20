<?php

namespace App\Http\Controllers\Admin\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallEvaluation;
use App\Models\ExamHall\ExamHallResults;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\ExamHall\ExamHallCQC;
use App\Models\Categories as ExamGroup;

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
        $data['groups'] = ExamGroup::where('type','=','exam_hall')->where('status','=','Active')->get();
        return view('admin.examhall.create',$data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "exam_group" => "nullable|numeric",
            'title'=>'string|required|min:5',
            'price'=>'required|numeric',
            'discount'=>'required|numeric',
            'description'=>'required|string',
            'status'=>'required|string|min:1',
            'image' => 'required|image',
            'search_tags' => 'nullable|string',
        ]);

        $image=request('image')->store('uploads','public');

        ExamHallCategories::create([
            'group_id'=>$request->exam_group ?? null,
            'title'=>$request->title,
            'price'=>$request->price,
            'discount'=>$request->discount ?? 0,
            'description'=>$request->description,
            'image'=>$image,
            'status'=>$request->status,
            'search_tags'=>$request->search_tags,
        ]);

        return redirect('/admin/exam-hall');
    }

    public function edit(ExamHallCategories $category)
    {
        $data['groups'] = ExamGroup::where('type','=','exam_hall')->where('status','=','Active')->get();
        $data['category'] = $category;
        return view('admin.examhall.edit',$data);
    }

    public function update(Request $request, ExamHallCategories $category)
    {
        // dd($category,$request->all());
        $request->validate([
            "exam_group" => "nullable|numeric",
            "categoryID" => "required|numeric",
            "title" => "required|string|min:5",
            "price" => "required|numeric",
            'discount'=>'required|numeric',
            'description'=>'required|string',
            "status" => "required|string|min:1",
            'oldImage' =>'string|nullable',
            'image' => 'image|nullable',
            'isPinned' => 'string|required',
            'search_tags' => 'nullable|string',
        ]);

        $image=$request->oldImage;
        if(isset($request->image))
        {
            $image=request('image')->store('uploads','public');
        }

        $category->update([
            'group_id'=>$request->exam_group ?? null,
            'title'=>$request->title,
            'price'=>$request->price,
            'discount'=>$request->discount ?? 0,
            'description'=>$request->description,
            'image'=>$image,
            'status'=>$request->status,
            'isPinned' => $request->isPinned,
            'search_tags' => $request->search_tags,
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
