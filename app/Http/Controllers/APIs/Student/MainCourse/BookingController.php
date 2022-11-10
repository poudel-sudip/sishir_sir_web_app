<?php

namespace App\Http\Controllers\APIs\Student\MainCourse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;
use App\Models\Course;
use App\Models\MerchantBooking;

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
        $bookings=$this->user->bookings()->get()->map(function($booking){
            return [
                'id'=>$booking->id,
                'batch'=>$booking->batch->name ?? '',
                'course'=>$booking->course->name ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'suspended'=>$booking->suspended,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
            ];
        });
        return response()->json($bookings->toArray());
    }

    public function verifiedBookings()
    {
        $bookings=$this->user->bookings()->where('status','=','Verified')->get()->map(function($booking){
            return [
                'id'=>$booking->id,
                'batch'=>$booking->batch->name ?? '',
                'course'=>$booking->course->name ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'suspended'=>$booking->suspended,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
            ];
        });
        return response()->json($bookings->toArray());
    }

    public function unverifiedBookings()
    {
        $bookings=$this->user->bookings()->where('status','!=','Verified')->get()->map(function($booking){
            return [
                'id'=>$booking->id,
                'batch'=>$booking->batch->name ?? '',
                'course'=>$booking->course->name ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'suspended'=>$booking->suspended,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
            ];
        });
        return response()->json($bookings->toArray());
    }

    public function suspendedBookings()
    {
        $bookings=$this->user->bookings()->where('suspended','=',true)->get()->map(function($booking){
            return [
                'id'=>$booking->id,
                'batch'=>$booking->batch->name ?? '',
                'course'=>$booking->course->name ?? '',
                'user'=>$booking->user->name ?? '',
                'status'=>$booking->status,
                'suspended'=>$booking->suspended,
                'created_at'=>$booking->created_at,
                'updated_at'=>$booking->updated_at,
            ];
        });
        return response()->json($bookings->toArray());
    }

    public function storeBooking(Request $request)
    {
        $validator=Validator::make($request->all(),[
           'batch_id'=>'numeric|required|min:1',
           'course_id'=>'numeric|required|min:1',
        ]);

        if($validator->fails()){
            return response()->json([$validator->errors()]);
        }

        $search=Booking::where([
            ['course_id','=',$request->course_id],
            ['batch_id','=',$request->batch_id],
            ['user_id','=',$this->user->id],
            ])->count();

        if($search){
            return response()->json(["booking_error"=>"You Have Already Booked This Course Batch."]);
        }

        $booking=Booking::create([
            'course_id'=>$request->course_id,
            'batch_id'=>$request->batch_id,
            'user_id'=> $this->user->id,
            'user_name'=>$this->user->name,
            'status'=>'Unverified',
            'updatedBy'=>$this->user->name,
        ]);
        return response()->json($booking);
    }

    public function showBooking($bookingID)
    {
        $booking = Booking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }
        return response()->json([
            'id'=>$booking->id,
            'user_name'=>$booking->user_name,
            "description"=> $booking->description,
            "status"=> $booking->status,
            "updatedBy"=>$booking->updatedBy,
            "verificationMode"=> $booking->verificationMode,
            "accountNo"=> $booking->accountNo,
            "paymentAmount"=> $booking->paymentAmount,
            "discount"=> $booking->discount,
            "dueAmount"=> $booking->dueAmount,
            "suspended"=> $booking->suspended,
            "verificationDocument"=> $booking->verificationDocument,
            "features"=> $booking->features,
            "remarks"=>$booking->remarks,
            "created_at"=> $booking->created_at,
            "updated_at"=> $booking->updated_at,
            'batch'=>[
                'id'=>$booking->batch->id,
                'name'=>$booking->batch->name,
                'slug'=>$booking->batch->slug,
                'status'=>$booking->batch->status,
                'class_status'=>$booking->batch->class_status,
            ],
            'course'=>[
                'id'=>$booking->course->id,
                'name'=>$booking->course->name,
                'slug'=>$booking->course->slug,
            ],
        ]);
    }

    public function updateBooking(Request $request,$bookingID)
    {
        $booking = Booking::find($bookingID);
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
            return response()->json([$validator->errors()]);
        }

        $booking->update([
            'verificationMode'=>$request['verificationMode'],
            'paymentAmount'=>$request['paymentAmount'],
            'verificationDocument'=>$request['verificationDocument'],
            'status'=>'Processing',
        ]);

        return response()->json([
            'id'=>$booking->id,
            'user_name'=>$booking->user_name,
            "description"=> $booking->description,
            "status"=> $booking->status,
            "updatedBy"=>$booking->updatedBy,
            "verificationMode"=> $booking->verificationMode,
            "accountNo"=> $booking->accountNo,
            "paymentAmount"=> $booking->paymentAmount,
            "discount"=> $booking->discount,
            "dueAmount"=> $booking->dueAmount,
            "suspended"=> $booking->suspended,
            "verificationDocument"=> $booking->verificationDocument,
            "features"=> $booking->features,
            "remarks"=>$booking->remarks,
            "created_at"=> $booking->created_at,
            "updated_at"=> $booking->updated_at,
            'batch'=>[
                'id'=>$booking->batch->id,
                'name'=>$booking->batch->name,
                'slug'=>$booking->batch->slug,
                'status'=>$booking->batch->status,
                'class_status'=>$booking->batch->class_status,
            ],
            'course'=>[
                'id'=>$booking->course->id,
                'name'=>$booking->course->name,
                'slug'=>$booking->course->slug,
            ],
        ]);
    }

    public function esewaSuccess($bookingID, Request $request)
    {
        $booking = Booking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }

        if(isset($request->oid) && isset($request->amt) && isset($request->refId))
        {
            $url = "https://esewa.com.np/epay/transrec";
            $data =[
                'amt'=> ($booking->batch->fee - $booking->batch->discount),
                'rid'=> $request->refId,
                'pid'=> $request->oid,
                'scd'=> 'NP-ES-ODADEPL'
            ];
            
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            $response_code =trim($this->get_xml_node_value('response_code',$response));
            if($response_code=='Success')
            {
                $booking->update([
                    'status'=>'Verified',
                    'verificationMode'=>'Esewa',
                    'paymentAmount'=>$data['amt'],
                    'remarks'=>'Booked by Student with Direct Esewa Payment',
                    'description'=>'Booked by Student with Direct Esewa Payment',
                    'updatedBy'=>$this->user->name,
                ]);

                MerchantBooking::create([
                    'type' => 'course',
                    'title' => $booking->batch->name ?? '',
                    'merchant' => 'esewa',
                    'booking_id' => $booking->id,
                ]);

                return response()->json([
                    'success_message'=>'Transction Completed Succesfully.',
                    'booking'=>[
                        'id'=>$booking->id,
                        'user_name'=>$booking->user_name,
                        "description"=> $booking->description,
                        "status"=> $booking->status,
                        "updatedBy"=>$booking->updatedBy,
                        "verificationMode"=> $booking->verificationMode,
                        "accountNo"=> $booking->accountNo,
                        "paymentAmount"=> $booking->paymentAmount,
                        "discount"=> $booking->discount,
                        "dueAmount"=> $booking->dueAmount,
                        "suspended"=> $booking->suspended,
                        "verificationDocument"=> $booking->verificationDocument,
                        "features"=> $booking->features,
                        "remarks"=>$booking->remarks,
                        "created_at"=> $booking->created_at,
                        "updated_at"=> $booking->updated_at,
                        'batch'=>[
                            'id'=>$booking->batch->id,
                            'name'=>$booking->batch->name,
                            'slug'=>$booking->batch->slug,
                            'status'=>$booking->batch->status,
                            'class_status'=>$booking->batch->class_status,
                        ],
                        'course'=>[
                            'id'=>$booking->course->id,
                            'name'=>$booking->course->name,
                            'slug'=>$booking->course->slug,
                        ],
                    ]
                ]);
            }
        }

        return response()->json([
            'error_message'=>'Transaction Failed. Try Again Later.'
        ]);
    }

    public function khaltiSuccess($bookingID, Request $request)
    {
        $booking = Booking::find($bookingID);
        if(!$booking)
        {
            return response()->json(['error'=>'Booking With Given ID Not Found'], 404);
        }

        $args = http_build_query(array(
            'token' => $request->token,
            'amount'  => ($booking->batch->fee - $booking->batch->discount) * 100
        ));
        
        $url = "https://khalti.com/api/v2/payment/verify/";
        
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $headers = ['Authorization: Key live_secret_key_1b91899fe8e24614873df8eec8db48f2'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if($status_code == 200)
        {
            $booking->update([
                'status'=>'Verified',
                'verificationMode'=>'Khalti',
                'paymentAmount'=>($booking->batch->fee - $booking->batch->discount),
                'remarks'=>'Booked by Student with Direct Khalti Payment',
                'description'=>'Booked by Student with Direct Khalti Payment',
                'updatedBy'=>auth()->user()->name,
            ]);
            MerchantBooking::create([
                'type' => 'course',
                'title' => $booking->batch->name ?? '',
                'merchant' => 'khalti',
                'booking_id' => $booking->id,
            ]);
            return response()->json([
                'success' => true,
                'success_message'=>'Transction Completed Succesfully.',
                'booking'=>[
                    'id'=>$booking->id,
                    'user_name'=>$booking->user_name,
                    "description"=> $booking->description,
                    "status"=> $booking->status,
                    "updatedBy"=>$booking->updatedBy,
                    "verificationMode"=> $booking->verificationMode,
                    "accountNo"=> $booking->accountNo,
                    "paymentAmount"=> $booking->paymentAmount,
                    "discount"=> $booking->discount,
                    "dueAmount"=> $booking->dueAmount,
                    "suspended"=> $booking->suspended,
                    "verificationDocument"=> $booking->verificationDocument,
                    "features"=> $booking->features,
                    "remarks"=>$booking->remarks,
                    "created_at"=> $booking->created_at,
                    "updated_at"=> $booking->updated_at,
                    'batch'=>[
                        'id'=>$booking->batch->id,
                        'name'=>$booking->batch->name,
                        'slug'=>$booking->batch->slug,
                        'status'=>$booking->batch->status,
                        'class_status'=>$ooking->batch->class_status,
                    ],
                    'course'=>[
                        'id'=>$booking->course->id,
                        'name'=>$booking->course->name,
                        'slug'=>$booking->course->slug,
                    ],
                ]
            ], 200);
        }
        else
        {
            return response()->json([
                'error' => true,
                'message' => 'Payment Failed. Please try again later.'
            ]);
        }
        
    }

    public function paymentFailed($booking, Request $request)
    {
        return response()->json([
            'error_message'=>'Transaction Failed. Try Again Later.'
        ]);
    }

    public function get_xml_node_value($node, $xml)
    {
        if($xml==false)
        {
            return false;
        }

        $found=preg_match('#<'.$node.'(?:\s+[^>]+)?>(.*?)'.'</'.$node.'>#s',$xml,$matches);

        if($found!=false)
        {
            return $matches[1];
        }

        return false;
    }
}
