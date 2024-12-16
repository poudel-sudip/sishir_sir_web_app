<?php

namespace App\Http\Controllers\Moderator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallExams;
use App\Models\ExamHall\ExamHallEvaluation;
use App\Models\ExamHall\ExamHallResults;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\ExamHall\ExamHallCQC;
use App\Models\Exams\Exam;
use App\Models\Exams\ExamCategory;
use App\Models\User;

class ExamHallController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        // $data['categories'] = ExamHallCategories::where('user_id','=',$user->id)->get();
        $data['categories'] = ExamHallCategories::get();
        return view('moderator.examhall.category.index',$data);
    }

    public function create()
    {
        return view('moderator.examhall.category.create');
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
            'search_tags' => 'nullable|string',
        ]);

        $image = request('image')->store('uploads','public');

        ExamHallCategories::create([
            'user_id' => auth()->user()->id,
            'title'=>$request->title,
            'price'=>$request->price,
            'discount'=>$request->discount ?? 0,
            'description'=>$request->description,
            'image'=>$image,
            'status'=>$request->status,
            'search_tags'=>$request->search_tags,
        ]);

        return redirect('/moderator/exam-hall');
    }

    public function edit(ExamHallCategories $category)
    {
        $data['category'] = $category;
        return view('moderator.examhall.category.edit',$data);
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
            'search_tags' => 'nullable|string',
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
            'search_tags' => $request->search_tags,
        ]);
        return redirect('/moderator/exam-hall');
    }

    public function destroy(ExamHallCategories $category)
    {
        abort(403,'Please Contact Admin To Delete it.');
        ExamHallBookings::where('category_id',$category->id)->delete();
        ExamHallEvaluation::where('category_id',$category->id)->delete();
        ExamHallResults::where('category_id',$category->id)->delete();
        $category->category_exams()->delete();

        $category->delete();
        return redirect('/moderator/exam-hall');
    }

    public function cqcindex(ExamHallCategories $category)
    {
        $data['category'] = $category;
        return view('moderator.examhall.category.cqc',$data);
    }

    public function cqcstore(Request $request, ExamHallCategories $category)
    {
        // dd($request->all(),$category);
        $request->validate(['question' => 'string|required|min:5']);
        $category->cqcs()->create([
            'name'=>auth()->user()->name,
            'question' => $request ->question,
        ]);

        return redirect('/moderator/exam-hall/'.$category->id.'/cqc');
    }

    public function cqcdestroy(Request $request, ExamHallCategories $category, ExamHallCQC $cqc)
    {
        // dd($request->all(),$category,$cqc);
        $cqc->delete();
        return redirect('/moderator/exam-hall/'.$category->id.'/cqc');
    }
    
    public function examindex(ExamHallCategories $category)
    {
        $data['category'] = $category;
        $data['catexams'] = $category->category_exams;
        // dd($category,$catexams);
        return view('moderator.examhall.exams.index',$data);
    }

    public function examcreate(ExamHallCategories $category)
    {
        $user = auth()->user();
        $data['category'] = $category;
        // $data['categories'] = ExamCategory::where('user_id','=',$user->id)->get();
        $data['categories'] = ExamCategory::get();
        return view('moderator.examhall.exams.create',$data);
    }

    public function examstore(Request $request, ExamHallCategories $category)
    {
        // dd($category,$request->all());
        $request->validate([
            'title'=>'string|required',
            'exam_name'=>'required|numeric|min:1',
        ]);

        $search = $category->category_exams()->where('exam_id','=',$request->exam_name)->first();
        if($search)
        {
            return back()->withInput()->withErrors(['exam_name'=>'This Exam is already present in the given Exam Category Set.']);
        }

        $category->category_exams()->create(['exam_id'=>$request->exam_name]);
        return redirect('/moderator/exam-hall/'.$category->id.'/exams');
    }

    public function examdestroy(Request $request, ExamHallCategories $category, ExamHallExams $exam)
    {
        abort(403,'Please Contact Admin To Delete it.');
        // dd($request->all(),$category,$exam);
        ExamHallEvaluation::where('category_id',$category->id)->where('exam_id',$exam->exam_id)->delete();
        ExamHallResults::where('category_id',$category->id)->where('exam_id',$exam->exam_id)->delete();
        $exam->delete();
        return redirect('/moderator/exam-hall/'.$category->id.'/exams');
    }

    public function examresults(ExamHallCategories $category, Exam $exam)
    {
        $data['category'] = $category;
        $data['exam'] = $exam;
        $data['results'] = ExamHallResults::where('category_id',$category->id)->where('exam_id',$exam->id)->get();
        return view('moderator.examhall.exams.results',$data);
    }

    public function setBookings(ExamHallCategories $category)
    {
        $data['category'] = $category;
        $data['bookings'] = $category->bookings;
        return view('moderator.examhall.booking.setbookings',$data);
    }

    public function bookingcreate()
    {
        abort(403,'Access Denied. Please Contact Admin.');
        $user = auth()->user();
        $data['categories'] = ExamHallCategories::where('user_id','=',$user->id)->where('status','Active')->get();
        return view('moderator.examhall.booking.create',$data);
    }

    public function bookingstore(Request $request)
    {
        abort(403,'Access Denied. Please Contact Admin.');
        // dd($request->all());
        $request->validate([
            "userID" => "required|numeric",
            "exam_category" => "required|numeric|min:1",
            "paymentAmount" => "required|numeric",
            "discount" => "required|numeric",
            "verificationMode" => "required|string|min:1",
            "status" => "required|string|min:1",
            "remarks" => "string|nullable",
        ]);

        $user = User::find($request['userID']);
        if(!$user)
        {
            return back()->withInput()->withErrors(['userID'=>'User Not Registered. Please Check Again !!!']);
        }

        $search=ExamHallBookings::where([
            ['category_id','=',$request['exam_category']],
            ['user_id','=',$request['userID']],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['exam_category'=>'This Exam Set is Already Booked by the Given User. Please Check Again !!!']);
        }

        $category = ExamHallCategories::find(request('exam_category'));
        $due=(integer)($category->price - $category->discount  - $request->paymentAmount - $request->discount);

        $booking = ExamHallBookings::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'user_name' => $user->name,
            'status' => $request->status,
            'updatedBy' =>auth()->user()->name,
            'verificationMode' => $request->verificationMode,
            'paymentAmount' => $request->paymentAmount,
            'discount' => $request->discount,
            'dueAmount' => $due,
            'remarks' => $request->remarks,
        ]);

        return redirect('/moderator/exam-hall/'.$category->id.'/bookings');
    }

    public function bookingshow(ExamHallBookings $booking)
    {
        $data['booking'] = $booking;
        return view('moderator.examhall.booking.show',$data);
    }

    public function bookingedit(ExamHallBookings $booking)
    {
        $user = auth()->user();
        if($booking->category && ($booking->category->user_id == $user->id))
        {
            $data['booking'] = $booking;
            return view('moderator.examhall.booking.edit',$data);
        }
        abort(403,'Access Denied. Please Contact Admin.');
        
    }

    public function bookingupdate(Request $request, ExamHallBookings $booking)
    {
        $user = auth()->user();
        if($booking->category && ($booking->category->user_id == $user->id))
        {
            // dd($request->all(),$booking);
            $request->validate([
                "bookingid" => "required|numeric",
                "exam_category" => "required|string",
                "paymentAmount" => "required|numeric",
                "discount" => "required|numeric",
                "verificationMode" => "required|string|min:1",
                'uploadDocument'=>'image|nullable',
                'oldDocument'=>'string|nullable',
                "status" => "required|string|min:1",
                "remarks" => "nullable|string",
                "examfee" => "required|numeric",
            ]);

            $due=(integer)($request->examfee - $request->paymentAmount - $request->discount);
            $img=$request->oldDocument;
            if(isset($request->uploadDocument))
            {
                $img=request('uploadDocument')->store('uploads','public');
            }
            $booking->update([
                "status" => $request->status,
                "updatedBy" => auth()->user()->name,
                "verificationMode" => $request->verificationMode,
                'verificationDocument'=>$img,
                "paymentAmount" => $request->paymentAmount,
                "discount" => $request->discount,
                "dueAmount" => $due,
                "remarks" => $request->remarks,
            ]);

            return redirect('/moderator/exam-hall/'.$booking->category_id.'/bookings');
        }

        abort(403,'Access Denied. Please Contact Admin.');
        
    }

    public function bookingdestroy(Request $request, ExamHallBookings $booking)
    {
        abort(403,'Access Denied. Please Contact Admin.');
        $booking->delete();
        return redirect('/moderator/exam-hall/'.$booking->category_id.'/bookings');

    }

    public function bookingindex()
    {
        $user = auth()->user();
        $catids = ExamHallCategories::where('user_id','=',$user->id)->get(['id','user_id'])->pluck('id')->values()->toArray();
        $data['bookings'] = ExamHallBookings::whereIn('category_id',$catids)->orderByDesc('id')->take(300)->get();
        return view('moderator.examhall.booking.index',$data);
    }

    public function allBookings()
    {
        $user = auth()->user();
        $catids = ExamHallCategories::where('user_id','=',$user->id)->get(['id','user_id'])->pluck('id')->values()->toArray();
        // $data['bookings'] = ExamHallBookings::whereIn('category_id',$catids)->get()->values();
        $data['bookings'] = ExamHallBookings::whereIn('category_id',$catids)->paginate(100);
        return view('moderator.examhall.booking.allbookings',$data);
    }
}
