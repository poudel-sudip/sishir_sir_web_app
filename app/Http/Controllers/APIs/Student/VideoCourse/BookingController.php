<?php

namespace App\Http\Controllers\APIs\Student\VideoCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoBooking;

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
        $bookings = $this->user->video_bookings()->get()->map(function($booking){
            return [
                'booking_id'=>$booking->id,
                'course_name'=>$booking->course->name ?? '',
                'course_slug'=>$booking->course->slug ?? '',
                'course_thumbnail'=>$booking->course->thumbnail ?? '',
                'category_name'=>$booking->course->category->name ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
                'liveclass_link'=> ($booking->status == 'Verified' ? $booking->class_link : ''),
                'chapter_link'=> ($booking->status == 'Verified' ? url('api/v1/my/video-course/'.$booking->id.'/chapters') : ''),
                'cqc_link'=> ($booking->status == 'Verified' ? url('api/v1/my/video-course/'.$booking->id.'/cqc') : ''),
                'exams_link'=> ($booking->status == 'Verified' ? url('api/v1/my/video-course/'.$booking->id.'/exams') : ''),

            ];
        });
        return response()->json($bookings->toArray());
    }

    public function verifiedBookings()
    {
        $bookings=$this->user->video_bookings()->where('status','=','Verified')->get()->map(function($booking){
            return [
                'booking_id'=>$booking->id,
                'course_name'=>$booking->course->name ?? '',
                'course_slug'=>$booking->course->slug ?? '',
                'course_thumbnail'=>$booking->course->thumbnail ?? '',
                'category_name'=>$booking->course->category->name ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
                'liveclass_link'=> ($booking->status == 'Verified' ? $booking->class_link : ''),
                'chapter_link'=> ($booking->status == 'Verified' ? url('api/v1/my/video-course/'.$booking->id.'/chapters') : ''),
                'cqc_link'=> ($booking->status == 'Verified' ? url('api/v1/my/video-course/'.$booking->id.'/cqc') : ''),
                'exams_link'=> ($booking->status == 'Verified' ? url('api/v1/my/video-course/'.$booking->id.'/exams') : ''),

            ];
        });
        return response()->json($bookings->toArray());
    }


    public function unverifiedBookings()
    {
        $bookings=$this->user->video_bookings()->where('status','!=','Verified')->get()->map(function($booking){
            return [
                'booking_id'=>$booking->id,
                'course_name'=>$booking->course->name ?? '',
                'course_slug'=>$booking->course->slug ?? '',
                'course_thumbnail'=>$booking->course->thumbnail ?? '',
                'category_name'=>$booking->course->category->name ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
                'liveclass_link'=> '',
                'chapter_link'=> '',
                'cqc_link'=> '',
                'exams_link'=> '',
            ];
        });
        return response()->json($bookings->toArray());
    }

    public function storeBooking(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'course_id'=>'required|numeric|min:1',
            'remarks'=>'string|nullable',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $search = VideoBooking::where([
            ['course_id','=',$request->course_id],
            ['user_id','=',$this->user->id],
            ])->count();

        if($search){
            return response()->json(["booking_error"=>"You Have Already Booked This Video Course."],400);
        }

        $booking = VideoBooking::create([
            'user_id'=> $this->user->id,
            'user_name'=>$this->user->name,
            'status'=>'Unverified',
            'updatedBy'=>$this->user->name,
            'course_id'=>$request->course_id,
            'remarks'=>$request->remarks ?? '',
        ]);
        return response()->json($booking);
    }

    public function showBooking($bookingID)
    {
        $booking = VideoBooking::find($bookingID);
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
            "accountNo"=> $booking->accountNo,
            "paymentAmount"=> $booking->paymentAmount,
            "discount"=> $booking->discount,
            "dueAmount"=> $booking->dueAmount,
            "verificationDocument"=> $booking->verificationDocument,
            "created_at"=> $booking->created_at,
            "updated_at"=> $booking->updated_at,
            "video_course" => [
                'course_id' => $booking->course->id ?? '',
                'course_name' => $booking->course->name ?? '',
                'course_slug' => $booking->course->slug ?? '',
                'course_thumbnail' => $booking->course->thumbnail ?? '',
                'course_fee' => $booking->course->fee ?? '',
                'course_discount' => $booking->course->discount ?? '',
            ],

        ]);
    }


    public function updateBooking(Request $request,$bookingID)
    {
        $booking = VideoBooking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }

        $validator=Validator::make($request->all(),[
            'verificationMode'=>'required | string',
            'paymentAmount'=>'required | numeric',
            'verificationDocument'=>'string | nullable',
        ]);
 
        if($validator->fails()){
            return response()->json([$validator->errors()],400);
        }

        $booking->update([
            'verificationMode'=>$request['verificationMode'],
            'paymentAmount'=>$request['paymentAmount'],
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
                "accountNo"=> $booking->accountNo,
                "paymentAmount"=> $booking->paymentAmount,
                "discount"=> $booking->discount,
                "dueAmount"=> $booking->dueAmount,
                "verificationDocument"=> $booking->verificationDocument,
                "created_at"=> $booking->created_at,
                "updated_at"=> $booking->updated_at,
                "video_course" => [
                    'course_id' => $booking->course->id ?? '',
                    'course_name' => $booking->course->name ?? '',
                    'course_slug' => $booking->course->slug ?? '',
                    'course_thumbnail' => $booking->course->thumbnail ?? '',
                    'course_fee' => $booking->course->fee ?? '',
                    'course_discount' => $booking->course->discount ?? '',
                ],
            ],
            
        ]);
    }

    public function deleteBooking(Request $request,$bookingID)
    {
        $booking = VideoBooking::find($bookingID);
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

}
