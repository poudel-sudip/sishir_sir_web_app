<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MerchantBooking;

class BookingsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $headercategories=Categories::all()->where('status','=','Active');
        $courses=Course::where('status','=','Active')->get();
        return view('student.courses.enroll',compact('courses','headercategories'));
    }

    public function store()
    {
        $data=request()->validate([
            'course_name'=>'integer | required | min:1',
            'batch_name'=>'integer | required | min:1',
            // 'description'=>'string | nullable',
        ]);
        $search=Booking::where([
            ['course_id','=',$data['course_name']],
            ['batch_id','=',$data['batch_name']],
            ['user_id','=',auth()->user()->id],
            ])->count();
        if($search){
            return back()->withInput()->with('alreadybooked', 'You Have Already Booked This Course!');
        }
        $booking=Booking::create([
            'course_id'=>$data['course_name'],
            'batch_id'=>$data['batch_name'],
            'user_id'=> auth()->user()->id,
            'user_name'=>auth()->user()->name,
            // 'description'=>$data['description'],
            'status'=>'Unverified',
            'updatedBy'=>auth()->user()->name,
        ]);
        return redirect('/student/courses/'.$booking->id.'/edit');
    }

    public function show(Booking $booking)
    {
        $headercategories=Categories::all()->where('status','=','Active');
        return view('student.courses.show',compact('booking','headercategories'));
    }

    public function edit(Booking $booking)
    {
        $headercategories=Categories::all()->where('status','=','Active');
        return view('student.courses.verify',compact('booking','headercategories'));
    }

    public function update(Booking $booking)
    { 
        $data=request()->validate([
            'verificationMode'=>'required | string',
            'paymentAmount'=>'required | integer',
            'verificationDocument'=>'required | image',
        ]);
        $imagePath=request('verificationDocument')->store('uploads','public');

        $booking->update([
            'verificationMode'=>$data['verificationMode'],
            'paymentAmount'=>$data['paymentAmount'],
            'verificationDocument'=>$imagePath,
            'status'=>'Processing',
        ]);
        
        // return redirect('/student/home');
        return redirect('/student/enrolled');
    }

    public function esewaSuccess(Booking $booking, Request $request)
    {
        // dd($request, $booking);
        if(isset($request->oid) && isset($request->amt) && isset($request->refId))
        {
            // dd($request->all(), $booking);
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
            // dd($response);
            $response_code =trim($this->get_xml_node_value('response_code',$response));
            // dd($response_code);
            if($response_code=='Success')
            {
                $booking->update([
                    'status'=>'Verified',
                    'verificationMode'=>'Esewa',
                    'paymentAmount'=>$data['amt'],
                    'remarks'=>'Booked by Student with Direct Esewa Payment',
                    'description'=>'Booked by Student with Direct Esewa Payment',
                    'updatedBy'=>auth()->user()->name,
                ]);
                MerchantBooking::create([
                    'type' => 'course',
                    'title' => $booking->batch->name ?? '',
                    'merchant' => 'esewa',
                    'booking_id' => $booking->id,
                ]);

                return redirect('/student/enrolled/classroom')->with('success_message','Transction Completed Succesfully.');
            }
        }

        return redirect("/student/courses/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');

    }

    public function khaltiSuccess(Booking $booking, Request $request)
    {
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
                'success' => 1,
                'redirecto' => url('/student/enrolled/classroom')
            ], 200);
        }
        else
        {
            return response()->json([
                'error' => 1,
                'message' => 'Payment Failed. Please try again later.'
            ]);
        }
        
    }

    public function paymentFailed(Booking $booking, Request $request)
    {
        return redirect("/student/courses/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
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
