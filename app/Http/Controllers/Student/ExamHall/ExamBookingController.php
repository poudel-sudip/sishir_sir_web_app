<?php

namespace App\Http\Controllers\Student\ExamHall;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\MerchantBooking;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\BookingCoupon as Coupon;

use App\Http\Controllers\NepalPayProxyController;

class ExamBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings=auth()->user()->exam_bookings()->orderByDesc('id')->paginate(21);
        return view('student.examhall.bookings.index',[
            'bookings'=>$bookings,
        ]);
    }

    public function enroll()
    {
        $bookedCatIds=auth()->user()->exam_bookings()->pluck('category_id')->values()->toArray();
        $categories = ExamHallCategories::where('status','Active')->whereNotIn('id',$bookedCatIds)->get();
        return view('student.examhall.bookings.enroll',compact('categories'));
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
            // return back()->withInput()->with('alreadybooked', 'You Have Already Booked This Exam Set!');
            return back()->withInput()->with('alreadybooked', 'You Have Already Booked This Exam Set. Please visit the Dashboard to view and solve the exams.');
        }

        $booking= ExamHallBookings::create([
            'user_id'=>auth()->user()->id,
            'category_id'=>$request->exam_category,
            'user_name'=>auth()->user()->name,
            'status'=>'Unverified',
            'updatedBy'=>auth()->user()->name,
            'remarks'=>$request->remarks,
        ]);

        return redirect('/student/exam-bookings/'.$booking->id.'/edit');

    }

    public function destroy(Request $request, ExamHallBookings $booking)
    {
        // dd($booking);
        $booking->delete();
        return redirect('/student/exam-bookings');
    }

    public function edit(ExamHallBookings $booking, Request $request)
    {
        $data = [];

        $booking->booking_price = (($booking->category->price ?? 0) - ($booking->category->discount ?? 0));
        $trans_id = 'exam-'.$booking->id.'-'.time();
        $booking->trans_id = $trans_id;

        $esewa_pay_data = null;
        $fonepay_pay_data = null;
        $nepalpay_pay_data = null;

        try 
        {
            if($_SERVER['HTTP_HOST'] == 'shisiradhikari.com.np')
            {
                
                $data['nepalpay_pay_wallets'] = [];
                $processID = null;
                $npay = new NepalPayProxyController;
                try 
                {
                    $data['nepalpay_pay_wallets'] = $npay->getPaymentInstrumentDetails($request);
                    $processID = $npay->getProcessId($booking->booking_price,$booking->trans_id);
                } 
                catch (\Throwable $th) {
                    // throw $th;
                }

                if(count($data['nepalpay_pay_wallets']) && $processID)
                {
                    try 
                    {
                        $nepalpay_pay_data = (object)config('payment.nepal_pay');
                        if($nepalpay_pay_data)
                        {
                            $nepalpay_pay_data->process_id = $processID;
                        }
                    } 
                    catch (\Throwable $th) {
                        // throw $th;
                    }
                }

            }
            
        } 
        catch (\Throwable $th) {
            // throw $th;
        }

        try 
        {
            if(config('payment.esewa_scd') && config('payment.esewa_secret_key'))
            {
                $esewa_pay_data = (object)[
                    "transaction_uuid" => $trans_id,
                    "amount" => $booking->booking_price,
                    "product_delivery_charge" => 0,
                    "product_service_charge" => 0,
                    "tax_amount" => 0,
                    "total_amount" => $booking->booking_price,
                    "product_code" => config('payment.esewa_scd'),
                    "signed_field_names" => "total_amount,transaction_uuid,product_code",
                    "signature" => base64_encode(hash_hmac('sha256', ('total_amount='.$booking->booking_price.',transaction_uuid='.$trans_id.',product_code='.config('payment.esewa_scd')), config('payment.esewa_secret_key'), true)),
                    "failure_url" => url("/student/exam-bookings/".$booking->id."/payment-failed"),
                    "success_url" => url("/student/exam-bookings/".$booking->id."/esewaSuccess"),
                    
                ];
            }
            
        } 
        catch (\Throwable $th) {
            //throw $th;
        }
        

        try 
        {
            if(config('payment.fonepay_pid') && config('payment.fonepay_secret_key'))
            {
                $MD = 'P'; 
                $AMT = $booking->booking_price; 
                $CRN = 'NPR'; 
                $DT = date('m/d/Y'); 
                $R1 = 'Exam Booking Payment For '.ucwords($booking->category->title ?? ''); 
                $R2 = 'N/A'; 
                $RU = url("/student/exam-bookings/".$booking->id."/fonepaySuccess"); 
                $PRN = $trans_id; 
                $PID = config('payment.fonepay_pid'); 
                $sharedSecretKey = config('payment.fonepay_secret_key'); 

                $fonepay_pay_data = (object)[
                    "RU" => $RU,
                    "PID" => $PID,
                    "PRN" => $PRN,
                    "AMT" => $AMT,
                    "CRN" => $CRN,
                    "DT" => $DT,
                    "R1" => $R1,
                    "R2" => $R2,
                    "MD" => $MD,
                    "DV" => hash_hmac('sha512', ($PID.','.$MD.','.$PRN.','.$AMT.','.$CRN.','.$DT.','.$R1.','.$R2.','.$RU), $sharedSecretKey),                    
                ];

            }
        } 
        catch (\Throwable $th) {
            //throw $th;
        }
       
       $data['booking'] = $booking;
       $data['esewa_pay_data'] = $esewa_pay_data; 
       $data['fonepay_pay_data'] = $fonepay_pay_data; 
       $data['nepalpay_pay_data'] = $nepalpay_pay_data; 

        // dd($data);
        return view('student.examhall.bookings.verify',$data);
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
            'paymentAmount'=>$request->paymentAmount,
            'status'=>'Processing',
        ]);

        return redirect('/student/exam-bookings');
    }

    public function couponVerify(Request $request, ExamHallBookings $booking)
    {
        // dd($request->all(),$booking);
        $request->validate([
            "verificationMode" => "string|required|min:1",
            "coupon_code" => "string|required|min:1",
        ]);

        $coupon = Coupon::where('source','=','exam')
        ->where('used','=',false)
        ->where('coupon','=',strtolower(trim($request->coupon_code)))
        ->first();

        if(!$coupon)
        {
            return redirect("/student/exam-bookings/$booking->id/edit")->with('error_message','Invalid Coupon Code or Coupon Code is Already Used.'); 
        }
        // dd($coupon);
        
        $booking->update([
            'verificationMode' => 'Coupon',
            'paymentAmount' => '0',
            'discount' => (($booking->category->price ?? 0) - ($booking->category->discount ?? 0)),
            'status' => 'Verified',
            'remarks'=>'Booked by Student with Coupon Code: '.$coupon->coupon,
            'updatedBy'=>auth()->user()->name,
        ]);

        $coupon->update([
            'used' => true,
            'use_date' => date('Y-m-d G:i:s'),
            'booking_id' => $booking->id,
            'user_id' => auth()->user()->id,
            'remarks' => $booking->category->title.'',
        ]);

        return redirect('/student/exam-bookings');
    }

    public function esewaSuccess(ExamHallBookings $booking, Request $request)
    {
        if(isset($request->data))
        {
            $decoded_b64 = base64_decode($request->data);
            $json_data = json_decode($decoded_b64,true);

            if($json_data['status'] === 'COMPLETE')
            {
                $signed_fields = explode(',',$json_data['signed_field_names']);
                $signed_fields = array_map(function($field) use($json_data) {
                    return $field.'='.$json_data[$field];
                },$signed_fields);

                $signed_fields = implode(',',$signed_fields);
                $signature = base64_encode(hash_hmac('sha256', $signed_fields, config('payment.esewa_secret_key'), true));
                
                if($signature === $json_data['signature'])
                {
                    $url = config('payment.esewa_verify_url');
                    $data = http_build_query(array(
                        'total_amount'=> (($booking->category->price ?? 0) - ($booking->category->discount ?? 0)),
                        'transaction_uuid'=> $json_data['transaction_uuid'],
                        'product_code'=> config('payment.esewa_scd'),
                    ));
                   
                    $response = Http::get($url.'?'.$data)->getBody();
                    $json_response = json_decode($response);

                    if($json_response->status === 'COMPLETE')
                    {

                        $booking->update([
                            'status'=>'Verified',
                            'verificationMode'=>'Esewa',
                            'paymentAmount'=> $json_response->total_amount,
                            'remarks'=>'Booked by Student with Direct Esewa Payment For Product ID: '.$json_response->transaction_uuid.'  and Transaction Code: '.$json_response->ref_id,
                            'updatedBy'=>auth()->user()->name,
                        ]);

                        return redirect('/student/exam-bookings')->with('success_message','Transction Completed Succesfully.');
                    }

                }

            }

        }

        return redirect("/student/exam-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');

    }

    public function fonepaySuccess(ExamHallBookings $booking, Request $request)
    {        
        // dd($request->all());
        if(isset($request->PRN) && isset($request->UID) && isset($request->PS) && isset($request->RC) && isset($request->DV) && isset($request->UID))
        {

            try 
            {
                $sharedSecretKey = config('payment.fonepay_secret_key');
                $pid = config('payment.fonepay_pid'); 
                $prn = $request->PRN ?? '';
                $ps = $request->PS ?? '';
                $rc = $request->RC ?? '';
                $uid = $request->UID ?? '';
                $bc = $request->BC ?? '';
                $ini = $request->INI ?? '';
                $dv = $request->DV ?? '';
                $pamt = $request->P_AMT ?? '0';
                $ramt = $request->R_AMT ?? '0';
                $generatedDv = hash_hmac('sha512', ($prn.','.$pid.','.$ps.','.$rc.','.$uid.','.$bc.','.$ini.','.$pamt.','.$ramt), $sharedSecretKey);
                if(strtolower($generatedDv) === strtolower($dv))
                {
                    if ($ps === 'true' && $rc === 'successful')
                    {
                        $booking->update([
                            'status'=>'Verified',
                            'verificationMode'=>'Fonepay',
                            'paymentAmount'=> $pamt,
                            'remarks'=>'Booked by Student with Direct Fonepay Payment with Unique Retrival Reference Number: '.$uid,
                            'updatedBy'=>auth()->user()->name,
                        ]);

                        return redirect('/student/exam-bookings')->with('success_message','Transction Completed Succesfully.');
                    }
                }
                 
            } 
            catch (\Throwable $th) {
                // throw $th;
                return redirect("/student/exam-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
            }

        }       
        return redirect("/student/exam-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');

    }

    public function paymentFailed(ExamHallBookings $booking, Request $request)
    {
        return redirect("/student/exam-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
    }

    public function khaltiSuccess(ExamHallBookings $booking, Request $request)
    {
        $args = http_build_query(array(
            'token' => $request->token,
            'amount'  => ($booking->category->price - $booking->category->discount) * 100
        ));
        
        $url = config('payment.khalti_verify_url');
        
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $headers = ['Authorization: Key '.config('payment.khalti_secret_key')];
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
                'paymentAmount'=>($booking->category->price - $booking->category->discount),
                'remarks'=>'Booked by Student with Direct Khalti Payment',
                'updatedBy'=>auth()->user()->name,
            ]);
            // MerchantBooking::create([
            //     'type' => 'exam',
            //     'title' => $booking->category->name ?? '',
            //     'merchant' => 'khalti',
            //     'booking_id' => $booking->id,
            // ]);
            return response()->json([
                'success' => 1,
                'redirecto' => url('/student/exam-bookings')
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
