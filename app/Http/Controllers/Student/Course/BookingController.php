<?php

namespace App\Http\Controllers\Student\Course;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;

use App\Models\Booking;
use App\Models\Categories;
use App\Models\Course;
use App\Models\Batch;
use App\Models\MerchantBooking;
use App\Models\BookingCoupon as Coupon;
use App\Http\Controllers\NepalPayProxyController;

use App\Helpers\CustomPdfHelper;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = auth()->user()->bookings()->whereHas('batch')->orderByDesc('id')->paginate(21);
        return view('student.courses.bookings.index',[
            'bookings'=>$bookings,
        ]);
    }

    public function enroll()
    {
        $bookedbatchIds = auth()->user()->bookings()->pluck('batch_id')->values()->toArray();
        $batches = Batch::whereIn('status',['Active','Running'])->whereNotIn('id',$bookedbatchIds)->get();
        return view('student.courses.bookings.enroll',compact('categories'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'batch_id'=>'required|numeric|min:1',
            'remarks'=>'string|nullable',
        ]);

        $search = Booking::where([
            ['batch_id','=',$request->batch_id],
            ['user_id','=',auth()->user()->id],
            ])->count();
            
        if($search){
            // return back()->withInput()->with('alreadybooked', 'You Have Already Booked This Exam Set!');
            return back()->withInput()->with('alreadybooked', 'You Have Already Booked This Course Batch. Please visit the Dashboard to view the course batch.');
        }

        $booking= Booking::create([
            'user_id'=>auth()->user()->id,
            'batch_id'=>$request->batch_id,
            'user_name'=>auth()->user()->name,
            'status'=>'Unverified',
            'updatedBy'=>auth()->user()->name,
            'remarks'=>$request->remarks,
        ]);

        return redirect('/student/online-course-bookings/'.$booking->id.'/edit');

    }

    public function destroy(Request $request, Booking $booking)
    {
        // dd($booking);
        if($booking->status == 'Verified')
        {
            abort(403,'Cannot Delete Verified Booking.');
        }
        $booking->delete();
        return redirect('/student/online-course-bookings');
    }

    public function edit(Booking $booking, Request $request)
    {
        $data = [];

        $booking->booking_price = (($booking->batch->fee ?? 0) - ($booking->batch->discount ?? 0));
        if(strtolower($booking->status) == 'expired')
        {
            $booking->booking_price = intval($booking->booking_price * 0.5);
        }

        $trans_id = 'course-'.$booking->id.'-'.time();
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
                        //throw $th;
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
                    "failure_url" => url("/student/online-course-bookings/".$booking->id."/payment-failed"),
                    "success_url" => url("/student/online-course-bookings/".$booking->id."/esewaSuccess"),
                    
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
                $R1 = 'Online Course Booking Payment For '.ucwords($booking->batch->name ?? ''); 
                $R2 = 'N/A'; 
                $RU = url("/student/online-course-bookings/".$booking->id."/fonepaySuccess"); 
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

        return view('student.courses.bookings.verify',$data);
    }

    public function paymentFailed(Booking $booking, Request $request)
    {
        return redirect("/student/online-course-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
    }

    public function manualPay(Request $request, Booking $booking)
    {
        // dd($request->all(),$booking);
        $request->validate([
            'bookingid'=>'required|numeric',
            'online_course'=>'required|string|min:1',
            'verificationMode'=>'required|string|min:1',
            'verificationDocument'=>'required|image',
            'paymentAmount'=>'required|numeric',
        ]);

        $imagePath = request('verificationDocument')->store('uploads/courses/batch_'.$booking->batch_id.'/payments','public');

        $booking->update([
            'verificationMode'=>$request->verificationMode,
            'verificationDocument'=>$imagePath,
            'paymentAmount'=>$request->paymentAmount,
            'status'=>'Processing',
        ]);

        return redirect('/student/online-course-bookings');
    }

    public function couponPay(Request $request, Booking $booking)
    {
        // dd($request->all(),$booking);
        $request->validate([
            "verificationMode" => "string|required|min:1",
            "coupon_code" => "string|required|min:1",
        ]);

        $coupon = Coupon::where('source','=','onlinecourse')
        ->where('used','=',false)
        ->where('coupon','=',strtolower(trim($request->coupon_code)))
        ->first();

        if(!$coupon)
        {
            return redirect("/student/online-course-bookings/$booking->id/edit")->with('error_message','Invalid Coupon Code or Coupon Code is Already Used.'); 
        }
        // dd($coupon);
        
        $expiry = Carbon::now()->addDays($booking->batch->expiry_days ?? 365);

        $booking->update([
            'verificationMode' => 'Coupon',
            'paymentAmount' => '0',
            'discount' => (($booking->batch->fee ?? 0) - ($booking->batch->discount ?? 0)),
            'status' => 'Verified',
            'remarks'=>'Booked by Student with Coupon Code: '.$coupon->coupon,
            'updatedBy'=>auth()->user()->name,
            'expiry_date' => $expiry,
        ]);

        $coupon->update([
            'used' => true,
            'use_date' => date('Y-m-d G:i:s'),
            'booking_id' => $booking->id,
            'user_id' => auth()->user()->id,
            'remarks' => $booking->batch->name.'',
        ]);

        return redirect('/student/online-course-bookings');
    }

    public function esewaSuccess(Booking $booking, Request $request)
    {
        // dd($request->all());
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
                    
                    $booking_payment_amount = intval(($booking->batch->fee ?? 0) - ($booking->batch->discount ?? 0));
                    $booking_bill_amount = intval(($booking->batch->fee ?? 0) - ($booking->batch->discount ?? 0));
                    $booking_payment_remarks = 'New Online Course Booking of '.($booking->batch->name ?? 'Unknown Course');
                    if(strtolower($booking->status) == 'expired')
                    {
                        $booking_payment_amount = intval($booking_payment_amount * 0.5);
                        $booking_payment_remarks = 'Online Course Booking renewal with 50% discount of '.($booking->batch->name ?? 'Unknown Course');
                    }

                    $data = http_build_query(array(
                        'total_amount'=> $booking_payment_amount,
                        'transaction_uuid'=> $json_data['transaction_uuid'],
                        'product_code'=> config('payment.esewa_scd'),
                    ));
                   
                    $response = Http::get($url.'?'.$data)->getBody();
                    $json_response = json_decode($response);

                    if($json_response->status === 'COMPLETE')
                    {
                        $expiry = Carbon::now()->addDays($booking->batch->expiry_days ?? 365);

                        $invoice_data = [
                            'user_id' => auth()->user()->id,
                            'type' => 'course',
                            'booking_id' => $booking->id,
                            'payment_mode' => 'Esewa',
                            'reference_code' => $json_response->ref_id ?? null,
                            'payment_amount' => $booking_payment_amount ?? '0',
                            'payment_remarks' => $booking_payment_remarks,
                            'discount_amount' => $booking_bill_amount - $booking_payment_amount,
                            'due_amount' => 0,
                            'verified_by' => auth()->user()->name,
                            'expiry_date' => $expiry,
                            'paid' => 1,
                            'informed' => 0,
                        ];

                        $booking->update([
                            'status'=>'Verified',
                            'verificationMode'=>'Esewa',
                            'paymentAmount'=> $json_response->total_amount,
                            'remarks'=>'Booked by Student with Direct Esewa Payment For Product ID: '.$json_response->transaction_uuid.'  and Transaction Code: '.$json_response->ref_id,
                            'updatedBy'=>auth()->user()->name,
                            'expiry_date' => $expiry,
                        ]);

                        $booking->payment_invoices()->create($invoice_data);

                        return redirect('/student/online-course-bookings')->with('success_message','Transction Completed Succesfully.');
                    }

                }

            }

        }

        return redirect("/student/online-course-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');

    }

    public function fonepaySuccess(Booking $booking, Request $request)
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
                        $expiry = Carbon::now()->addDays($booking->batch->expiry_days ?? 365);

                        $booking_payment_amount = intval(($booking->batch->fee ?? 0) - ($booking->batch->discount ?? 0));
                        $booking_bill_amount = intval(($booking->batch->fee ?? 0) - ($booking->batch->discount ?? 0));
                        $booking_payment_remarks = 'New Online Course Booking of '.($booking->batch->fee ?? 'Unknown Course');
                        if(strtolower($booking->status) == 'expired')
                        {
                            $booking_payment_amount = intval($booking_payment_amount * 0.5);
                            $booking_payment_remarks = 'Online Course Booking renewal with 50% discount of '.($booking->batch->name ?? 'Unknown Course');
                        }

                        $invoice_data = [
                            'user_id' => auth()->user()->id,
                            'type' => 'course',
                            'booking_id' => $booking->id,
                            'payment_mode' => 'Fonepay',
                            'reference_code' => $uid ?? null,
                            'payment_amount' => $booking_payment_amount ?? '0',
                            'payment_remarks' => $booking_payment_remarks,
                            'discount_amount' => $booking_bill_amount - $booking_payment_amount,
                            'due_amount' => 0,
                            'verified_by' => auth()->user()->name,
                            'expiry_date' => $expiry,
                            'paid' => 1,
                            'informed' => 0,
                        ];

                        $booking->update([
                            'status'=>'Verified',
                            'verificationMode'=>'Fonepay',
                            'paymentAmount'=> $pamt,
                            'remarks'=>'Booked by Student with Direct Fonepay Payment with Unique Retrival Reference Number: '.$uid,
                            'updatedBy'=>auth()->user()->name,
                            'expiry_date' => $expiry,
                        ]);

                        $booking->payment_invoices()->create($invoice_data);
                        
                        return redirect('/student/online-course-bookings')->with('success_message','Transction Completed Succesfully.');
                    }
                }
                 
            } 
            catch (\Throwable $th) {
                // throw $th;
                return redirect("/student/online-course-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
            }

        }       
        return redirect("/student/online-course-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');

    }

    public function fileList(Booking $booking)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access Files Unverified Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }

        if(in_array($batch->status,['Active','Running']) == false)
        {
            abort(403,'Cannot Access Files of Non-Active Batch.');
        }

        $data = [];
        $data['booking'] = $booking;
        $data['batch'] = $batch;
        $data['files'] = $batch->classFiles()->orderBy('created_at')->get();

        return view('student.courses.bookings.file_list',$data);
    }

    public function videoList(Booking $booking)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access Videos Unverified Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }
        if(in_array($batch->status,['Active','Running']) == false)
        {
            abort(403,'Cannot Access Files of Non-Active Batch.');
        }

        $data = [];
        $data['booking'] = $booking;
        $data['batch'] = $batch;
        $data['videos'] = $batch->classVideos()->orderBy('created_at')->get();
        return view('student.courses.bookings.video_list',$data);
    }


    public function curriculumList(Booking $booking)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access Contents of this course Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }
        
        $data = [];
        $data['booking'] = $booking;
        $data['batch'] = $batch;
        $data['curriculums'] = $batch->curriculums()
        ->where('status','=',1)
        ->orderBy('title')
        ->get(['id','title','is_heading'])
        ->values();

        return view('student.courses.bookings.curriculum_list',$data);
    }


    public function curriculumShow(Booking $booking, $cid)
    {
        if($booking->status != 'Verified')
        {
            abort(403,'Cannot Access Videos Unverified Booking.');
        }
        $batch = $booking->batch;
        if(!$batch)
        {
            abort(404,'Batch Not Found.');
        }
        
        $curriculum = $batch->curriculums()->where('status','=',1)->find($cid);
        if(!$curriculum)
        {
            abort(404,'Curriculum Not Found.');
        }

        $data = [];
        $data['booking'] = $booking;
        $data['batch'] = $batch;
        $data['curriculum_single'] = $curriculum;
        $data['curriculums'] = $batch->curriculums()
        ->where('status','=',1)
        ->orderBy('title')
        ->get(['id','title','is_heading'])
        ->values();
        
        return view('student.courses.bookings.curriculum_show',$data);
    }
   

    public function showCertificate(Request $request, Booking $booking)
    {
        if($booking->status != 'Completed')
        {
            abort(403, 'This Course is not Completed.');
        }

        if($booking->user_id != auth()->user()->id){
            abort(403,'This is not your course booking. Access Denied.');
        }

        $booking->description = json_decode($booking->description);

        $certificate = (object)[];
        $certificate->certificate_no  = "CERT-".date('Y')."-".$booking->id;
        $certificate->logo = public_path('images/logo.png');
        $certificate->date = Carbon::parse($booking->description->exam_date ?? Carbon::now())->format('d F Y');
        $certificate->student_id = auth()->user()->id;
        $certificate->student_name = auth()->user()->name;
        $certificate->course = $booking->batch->name ?? '';
        $certificate->duration = ($booking->batch->duration ?? '').' '.($booking->batch->durationType ?? '');

        // dd($booking, $certificate);
        $data = [];
        $data['certificate'] = $certificate;

        $html = view('exports.pdf.course_certificate', $data)->render();
        $title = 'Course Certificate';

        return CustomPdfHelper::createPdf($title,$html,$footer=false,$download=false); 
    }



}
