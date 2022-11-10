<?php

namespace App\Http\Controllers\admin\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\User;

class ExamHallBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ExamHallCategories $category)
    {
        // dd($category->bookings);
        $bookings=$category->bookings;
        return view('admin.examhall.booking.index',compact('category','bookings'));
    }

    public function create()
    {
        $categories= ExamHallCategories::where('status','Active')->get();
        return view('admin.examhall.booking.create',compact('categories'));
    }

    public function show(ExamHallBookings $booking)
    {
        return view('admin.examhall.booking.show',compact('booking'));
    }

    public function edit(ExamHallBookings $booking)
    {
        return view('admin.examhall.booking.edit',compact('booking'));
    }

    public function store(Request $request)
    {
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

        $search=ExamHallBookings::where([
            ['category_id','=',$request['exam_category']],
            ['user_id','=',$request['userID']],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['exam_category'=>'This Exam is Already Booked by the Given User. Please Check Again !!!']);
        }

        $category = ExamHallCategories::find(request('exam_category'));
        $due=(integer)($category->price - $category->discount  - $request->paymentAmount - $request->discount);

        $booking = ExamHallBookings::create([
            'user_id' => User::find(request('userID'))->id ?? auth()->user()->id,
            'category_id' => $category->id,
            'user_name' => User::find(request('userID'))->name ?? auth()->user()->name,
            'status' => $request->status,
            'updatedBy' =>auth()->user()->name,
            'verificationMode' => $request->verificationMode,
            'paidAmount' => $request->paymentAmount,
            'discount' => $request->discount,
            'dueAmount' => $due,
            'remarks' => $request->remarks,
        ]);

        return redirect('/admin/exam-hall/'.$category->id.'/bookings');
    }

    public function update(Request $request, ExamHallBookings $booking)
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
            "trans_code" => "string|nullable",
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
            "paidAmount" => $request->paymentAmount,
            "discount" => $request->discount,
            "dueAmount" => $due,
            "remarks" => $request->remarks,
            "trans_code" => $request->trans_code,
        ]);

        return redirect('/admin/exam-hall/'.$booking->category_id.'/bookings');
    }

    public function destroy(Request $request, ExamHallBookings $booking)
    {
        $booking->vendorBooking()->delete();
        $booking->delete();
        return redirect('/admin/exam-hall/'.$booking->category_id.'/bookings');

    }

    public function allBookings()
    {
        $bookings=ExamHallBookings::all();
        return view('admin.examhall.booking.bookinglist',compact('bookings'));
    }

}
