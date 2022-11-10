<?php

namespace App\Http\Controllers\APIs\Student\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallBookings;

class BookingController extends Controller
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

    public function allBookings()
    {
        $bookings = $this->user->exam_bookings()->get()->map(function($booking){
            return [
                'booking_id'=>$booking->id,
                'exam_category'=>$booking->category->title ?? '',
                'exam_slug'=>$booking->category->slug ?? '',
                'exam_thumbnail'=>$booking->category->image ?? '',
                'no_of_sets'=>$booking->category->category_exams->count() ?? '0',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
                'live_class_link'=> ($booking->status == 'Verified' ? $booking->category->class_link : ''),
                'cqc_link'=> ($booking->status == 'Verified' ? url('api/v1/my/examhall/'.$booking->id.'/cqc') : ''),
                'exams_link'=> ($booking->status == 'Verified' ? url('api/v1/my/examhall/'.$booking->id.'/exams') : ''),
            ];
        });
        return response()->json($bookings->toArray());
    }

    public function verifiedBookings()
    {
        $bookings=$this->user->exam_bookings()->where('status','=','Verified')->get()->map(function($booking){
            return [
                'booking_id'=>$booking->id,
                'exam_category'=>$booking->category->title ?? '',
                'exam_slug'=>$booking->category->slug ?? '',
                'exam_thumbnail'=>$booking->category->image ?? '',
                'no_of_sets'=>$booking->category->category_exams->count() ?? '0',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
                'live_class_link'=> $booking->category->class_link ?? '',
                'cqc_link'=> url('api/v1/my/examhall/'.$booking->id.'/cqc'),
                'exams_link'=> url('api/v1/my/examhall/'.$booking->id.'/exams'),

            ];
        });
        return response()->json($bookings->toArray());
    }


    public function unverifiedBookings()
    {
        $bookings=$this->user->exam_bookings()->where('status','!=','Verified')->get()->map(function($booking){
            return [
                'booking_id'=>$booking->id,
                'exam_category'=>$booking->category->title ?? '',
                'exam_slug'=>$booking->category->slug ?? '',
                'exam_thumbnail'=>$booking->category->image ?? '',
                'no_of_sets'=>$booking->category->category_exams->count() ?? '0',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
                'live_class_link'=> '',
                'cqc_link'=> '',
                'exams_link'=> '',
            ];
        });
        return response()->json($bookings->toArray());
    }

    public function deleteBooking(Request $request,$bookingID)
    {
        $booking = ExamHallBookings::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }

        if($booking->status == 'Verified')
        {
            return response()->json(['error'=>'This Booking is Already Verified. Please Contact Administrator to Delete This Data.'], 403);
        }

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Your Booking is Deleted Successfully',
        ], 200);
    }

    public function storeBooking(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'category_id'=>'required|numeric|min:1',
            'remarks'=>'string|nullable',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $search = ExamHallBookings::where([
            ['category_id','=',$request->category_id],
            ['user_id','=',$this->user->id],
            ])->count();

        if($search){
            return response()->json(["booking_error"=>"You Have Already Booked This Exam Set."],400);
        }

        $booking = ExamHallBookings::create([
            'user_id'=> $this->user->id,
            'user_name'=>$this->user->name,
            'status'=>'Unverified',
            'updatedBy'=>$this->user->name,
            'category_id'=>$request->category_id,
            'remarks'=>$request->remarks ?? '',
        ]);
        return response()->json($booking);
    }


    public function showBooking($bookingID)
    {
        $booking = ExamHallBookings::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }
        return response()->json([
            'id'=>$booking->id,
            'user_name'=>$booking->user_name,
            "status"=> $booking->status,
            "updatedBy"=>$booking->updatedBy,
            "verificationMode"=> $booking->verificationMode,
            "paidAmount"=> $booking->paidAmount,
            "discount"=> $booking->discount,
            "dueAmount"=> $booking->dueAmount,
            "verificationDocument"=> $booking->verificationDocument,
            "created_at"=> $booking->created_at,
            "updated_at"=> $booking->updated_at,
            "exam_category" => [
                'category_id' => $booking->category->id ?? '',
                'category_title' => $booking->category->title ?? '',
                'category_slug' => $booking->category->slug ?? '',
                'category_thumbnail' => $booking->category->image ?? '',
                'category_fee' => $booking->category->price ?? '',
                'category_discount' => $booking->category->discount ?? '',
            ],

        ]);
    }

    public function updateBooking(Request $request,$bookingID)
    {
        $booking = ExamHallBookings::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'verificationMode'=>'required | string',
            'paidAmount'=>'required | numeric',
            'verificationDocument'=>'string | nullable',
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()],400);
        }

        $booking->update([
            'verificationMode'=>$request['verificationMode'],
            'paidAmount'=>$request['paidAmount'],
            'verificationDocument'=>$request['verificationDocument'],
            'status'=>'Processing',
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id'=>$booking->id,
                'user_name'=>$booking->user_name,
                "status"=> $booking->status,
                "updatedBy"=>$booking->updatedBy,
                "verificationMode"=> $booking->verificationMode,
                "paidAmount"=> $booking->paidAmount,
                "discount"=> $booking->discount,
                "dueAmount"=> $booking->dueAmount,
                "verificationDocument"=> $booking->verificationDocument,
                "created_at"=> $booking->created_at,
                "updated_at"=> $booking->updated_at,
                "exam_category" => [
                    'category_id' => $booking->category->id ?? '',
                    'category_title' => $booking->category->title ?? '',
                    'category_slug' => $booking->category->slug ?? '',
                    'category_thumbnail' => $booking->category->image ?? '',
                    'category_fee' => $booking->category->price ?? '',
                    'category_discount' => $booking->category->discount ?? '',
                ],
            ],
            
        ]);
    }

}
