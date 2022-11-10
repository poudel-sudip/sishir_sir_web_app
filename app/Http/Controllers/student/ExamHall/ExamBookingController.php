<?php

namespace App\Http\Controllers\student\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\MerchantBooking;

class ExamBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings=auth()->user()->exam_bookings()->get();
        return view('student.ExamHall.index',[
            'bookings'=>$bookings,
        ]);
    }

    public function enroll()
    {
        $categories=ExamHallCategories::where('status','Active')->get();
        return view('student.ExamHall.enroll',compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'exam_category'=>'required|numeric|min:1',
            'remarks'=>'string|nullable',
        ]);

        $search=ExamHallBookings::where([
            ['category_id','=',$request->exam_category],
            ['user_id','=',auth()->user()->id],
            ])->count();
            
        if($search){
            return back()->withInput()->with('alreadybooked', 'You Have Already Booked This Exam Category!');
        }

        $booking= ExamHallBookings::create([
            'user_id'=>auth()->user()->id,
            'category_id'=>$request->exam_category,
            'user_name'=>auth()->user()->name,
            'status'=>'Unverified',
            'updatedBy'=>auth()->user()->name,
            'remarks'=>$request->remarks,
        ]);

        return redirect('/student/exam-hall/'.$booking->id.'/edit');

    }

    public function destroy(Request $request, ExamHallBookings $booking)
    {
        // dd($booking);
        $booking->delete();
        return redirect('/student/exam-hall');
    }

    public function edit(ExamHallBookings $booking)
    {
        return view('student.ExamHall.verify',compact('booking'));
    }

    public function manualVerify(Request $request, ExamHallBookings $booking)
    {
        // dd($request->all(),$booking);
        $request->validate([
            'bookingid'=>'required|numeric',
            'exam_category'=>'required|string|min:1',
            'verificationMode'=>'required|string|min:1',
            'verificationDocument'=>'required|image',
            'paymentAmount'=>'required|numeric',
        ]);
        $imagePath=request('verificationDocument')->store('uploads','public');
        $booking->update([
            'verificationMode'=>$request->verificationMode,
            'verificationDocument'=>$imagePath,
            'paidAmount'=>$request->paymentAmount,
            'status'=>'Processing',
        ]);

        return redirect('/student/exam-hall');
    }

    public function esewaSuccess(ExamHallBookings $booking, Request $request)
    {
        // dd($request->all(),$booking);

        if(isset($request->oid) && isset($request->amt) && isset($request->refId))
        {
            // dd($request->all(), $booking);
            $url = "https://esewa.com.np/epay/transrec";
            $data =[
                'amt'=> ($booking->category->price - $booking->category->discount),
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
                    'paidAmount'=>$data['amt'],
                    'remarks'=>'Booked by Student with Direct Esewa Payment',
                    'updatedBy'=>auth()->user()->name,
                ]);
                MerchantBooking::create([
                    'type' => 'exam',
                    'title' => $booking->category->name ?? '',
                    'merchant' => 'esewa',
                    'booking_id' => $booking->id,
                ]);
                return redirect('/student/exam-hall')->with('success_message','Transction Completed Succesfully.');
            }
        }

        return redirect("/student/exam-hall/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');


    }

    public function paymentFailed(ExamHallBookings $booking, Request $request)
    {
        return redirect("/student/exam-hall/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
    }

    public function khaltiSuccess(ExamHallBookings $booking, Request $request)
    {
        $args = http_build_query(array(
            'token' => $request->token,
            'amount'  => ($booking->category->price - $booking->category->discount) * 100
        ));
        
        $url = "https://khalti.com/api/v2/payment/verify/";
        
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $headers = ['Authorization: Key test_secret_key_ac3b9ea5852c45d597d141b28d2c7c44'];
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
                'paidAmount'=>($booking->category->price - $booking->category->discount),
                'remarks'=>'Booked by Student with Direct Khalti Payment',
                'updatedBy'=>auth()->user()->name,
            ]);
            MerchantBooking::create([
                'type' => 'exam',
                'title' => $booking->category->name ?? '',
                'merchant' => 'khalti',
                'booking_id' => $booking->id,
            ]);
            return response()->json([
                'success' => 1,
                'redirecto' => url('/student/exam-hall')
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