<?php

namespace App\Http\Controllers\APIs\Student\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallBookings;

class CQCController extends Controller
{
    protected $user; 

    protected function guard()
    {
        return Auth::guard('api');
    }

    public function __construct()
    {
        $this->middleware('auth:api');
        $this->user=$this->guard()->user();
    }

    public function index($bookingID)
    {
        $booking = ExamHallBookings::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $category = $booking->category;
        if(!$category)
        {
            return response()->json(['error'=>'Booked Exam Set Not Found'], 404);
        }

        $cqcs = $category->cqcs()->get(['id','name','question','created_at']);

        return response()->json([
            'category' => [
                'id' => $category->id,
                'name' => $category->title,
                'slug' => $category->slug,
                'thumbnail' => $category->image,
            ],
            'cqc_lists' => $cqcs,
            
        ]);
    }

    public function store($bookingID, Request $request)
    {
        $booking = ExamHallBookings::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking Not Found'], 404);
        }

        if($booking->status != 'Verified')
        {
            return response()->json(['error'=>'This Booking is not Verified. Please Contact Administrator.'], 403);
        }

        $category = $booking->category;
        if(!$category)
        {
            return response()->json(['error'=>'Booked Exam Set Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'question'=>'string | required',
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $data = $category->cqcs()->create([
            'name'=>$this->user->name,
            'question'=>$request['question'],
        ]);

        return response()->json($data);
    }
}
