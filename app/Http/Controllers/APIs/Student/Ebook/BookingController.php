<?php

namespace App\Http\Controllers\APIs\Student\Ebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\EbookBooking;

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
        $bookings = $this->user->ebook_bookings()->get()->map(function($booking){
            return [
                'booking_id'=>$booking->id,
                'book_name'=>$booking->book->title ?? '',
                'book_slug'=>$booking->book->slug ?? '',
                'book_author'=>$booking->book->author ?? '',
                'book_thumbnail'=>$booking->book->thumbnail ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
                'chapter_link'=> ($booking->status == 'Verified' ? url('api/v1/my/ebooks/'.$booking->id.'/chapters') : ''),
            ];
        });
        return response()->json($bookings->toArray());
    }

    public function verifiedBookings()
    {
        $bookings=$this->user->ebook_bookings()->where('status','=','Verified')->get()->map(function($booking){
            return [
                'booking_id'=>$booking->id,
                'book_name'=>$booking->book->title ?? '',
                'book_slug'=>$booking->book->slug ?? '',
                'book_author'=>$booking->book->author ?? '',
                'book_thumbnail'=>$booking->book->thumbnail ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
                'chapter_link'=> url('api/v1/my/ebooks/'.$booking->id.'/chapters'),

            ];
        });
        return response()->json($bookings->toArray());
    }

    public function unverifiedBookings()
    {
        $bookings=$this->user->ebook_bookings()->where('status','!=','Verified')->get()->map(function($booking){
            return [
                'booking_id'=>$booking->id,
                'book_name'=>$booking->book->title ?? '',
                'book_slug'=>$booking->book->slug ?? '',
                'book_author'=>$booking->book->author ?? '',
                'book_thumbnail'=>$booking->book->thumbnail ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
            ];
        });
        return response()->json($bookings->toArray());
    }

    public function storeBooking(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'book_id'=>'required|numeric|min:1',
            'remarks'=>'string|nullable',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $search=EbookBooking::where([
            ['book_id','=',$request->book_id],
            ['user_id','=',$this->user->id],
            ])->count();

        if($search){
            return response()->json(["booking_error"=>"You Have Already Booked This Ebook."],400);
        }

        $booking=EbookBooking::create([
            'user_id'=> $this->user->id,
            'user_name'=>$this->user->name,
            'status'=>'Unverified',
            'updatedBy'=>$this->user->name,
            'book_id'=>$request->book_id,
            'remarks'=>$request->remarks ?? '',
        ]);
        return response()->json($booking);
    }

    public function showBooking($bookingID)
    {
        $booking = EbookBooking::find($bookingID);
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
            "book" => [
                'book_id' => $booking->book->id ?? '',
                'book_name' => $booking->book->title ?? '',
                'book_slug' => $booking->book->slug ?? '',
                'book_author' => $booking->book->author ?? '',
                'book_thumbnail' => $booking->book->thumbnail ?? '',
                'book_price' => $booking->book->price ?? '',
                'book_discount' => $booking->book->discount ?? '',
            ],

        ]);
    }


    public function updateBooking(Request $request,$bookingID)
    {
        $booking = EbookBooking::find($bookingID);
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
                "book" => [
                    'book_id' => $booking->book->id ?? '',
                    'book_name' => $booking->book->title ?? '',
                    'book_slug' => $booking->book->slug ?? '',
                    'book_author' => $booking->book->author ?? '',
                    'book_thumbnail' => $booking->book->thumbnail ?? '',
                    'book_price' => $booking->book->price ?? '',
                    'book_discount' => $booking->book->discount ?? '',
                ],
            ],
            
        ]);
    }

    public function deleteBooking(Request $request,$bookingID)
    {
        $booking = EbookBooking::find($bookingID);
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
