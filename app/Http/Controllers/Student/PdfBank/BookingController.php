<?php

namespace App\Http\Controllers\Student\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Models\Ebook\Ebook as PDFBank;
use App\Models\Ebook\EbookBooking as Booking;
use App\Models\MerchantBooking;
use App\Models\BookingCoupon as Coupon;

use App\Http\Controllers\NepalPayProxyController;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = auth()->user()->ebook_bookings()->orderByDesc('id')->paginate(21);
        return view('student.pdf_bank.booking.index',compact('bookings'));
    }

    public function create()
    {
        $bookedBookIds=auth()->user()->ebook_bookings()->pluck('book_id')->values()->toArray();
        $pdfbanks = PDFBank::where('status','=','Active')->whereNotIn('id',$bookedBookIds)->get();
        return view('student.pdf_bank.booking.create',compact('pdfbanks'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'pdf_bank'=>'required|numeric|min:1',
            'remarks'=>'string|nullable',
        ]);
        $search=Booking::where([
            ['book_id','=',$request->pdf_bank],
            ['user_id','=',auth()->user()->id],
        ])->count();
            
        if($search){
            // return back()->withInput()->with('alreadybooked', 'You Have Already Enrolled This eBook !!!');
            return back()->withInput()->with('alreadybooked', 'You have already enrolled in this eBook. Please visit the Dashboard to view and download the PDF.');
        }

        $booking = Booking::create([
            'user_id'=>auth()->user()->id,
            'book_id'=>$request->pdf_bank,
            'user_name'=>auth()->user()->name,
            'status'=>'Unverified',
            'updatedBy'=>auth()->user()->name,
            'remarks'=>$request->remarks,
        ]);

        return redirect('/student/pdf-bank-bookings/'.$booking->id.'/edit');
    }


    public function edit(Booking $booking, Request $request)
    {
        $data = [];

        $booking->booking_price = (($booking->book->price ?? 0) - ($booking->book->discount ?? 0));
        $trans_id = 'pdfbank-'.$booking->id.'-'.time();
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
                    "failure_url" => url("/student/pdf-bank-bookings/".$booking->id."/payment-failed"),
                    "success_url" => url("/student/pdf-bank-bookings/".$booking->id."/esewaSuccess"),
                    
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
                $R1 = 'PDF Booking Payment For '.ucwords($booking->book->title ?? ''); 
                $R2 = 'N/A'; 
                $RU = url("/student/pdf-bank-bookings/".$booking->id."/fonepaySuccess"); 
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
        return view('student.pdf_bank.booking.edit',$data);
    }

    public function manualPay(Request $request, Booking $booking)
    {
        // dd($request->all(),$booking);
        $request->validate([
            "verificationMode" => "string|required|min:1",
            "paymentAmount" => "numeric|required",
            "verificationDocument" => "image|required",
        ]);
        $img = request('verificationDocument')->store('uploads/pdf_bank_bookings','public');
        $booking->update([
            'verificationMode' => $request->verificationMode,
            'paymentAmount' => $request->paymentAmount,
            'verificationDocument' => $img,
            'status' => 'Processing',
        ]);

        return redirect('/student/pdf-bank-bookings');
    }

    public function couponPay(Request $request, Booking $booking)
    {
        // dd($request->all(),$booking);
        $request->validate([
            "verificationMode" => "string|required|min:1",
            "coupon_code" => "string|required|min:1",
        ]);

        $coupon = Coupon::where('source','=','pdfbank')
        ->where('used','=',false)
        ->where('coupon','=',strtolower(trim($request->coupon_code)))
        ->first();

        if(!$coupon)
        {
            return redirect("/student/pdf-bank-bookings/$booking->id/edit")->with('error_message','Invalid Coupon Code or Coupon Code is Already Used.'); 
        }
        // dd($coupon);
        
        $expiry = Carbon::now()->addDays($booking->book->expiry_days ?? 365);

        $booking->update([
            'verificationMode' => 'Coupon',
            'paymentAmount' => '0',
            'discount' => (($booking->book->price ?? 0) - ($booking->book->discount ?? 0)),
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
            'remarks' => $booking->book->title.'',
        ]);

        return redirect('/student/pdf-bank-bookings');
    }

    public function destroy(Booking $booking)
    {
        if($booking->status == 'Verified')
        {
            abort(403,'Please Contact Admin To Delete Verified Booking.');
        }
        $booking->delete();
        return redirect('/student/pdf-bank-bookings');
    }

    public function paymentFailed(Booking $booking)
    {
        return redirect("/student/pdf-bank-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
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
                    $data = http_build_query(array(
                        'total_amount'=> (($booking->book->price ?? 0) - ($booking->book->discount ?? 0)),
                        'transaction_uuid'=> $json_data['transaction_uuid'],
                        'product_code'=> config('payment.esewa_scd'),
                    ));
                   
                    $response = Http::get($url.'?'.$data)->getBody();
                    $json_response = json_decode($response);

                    if($json_response->status === 'COMPLETE')
                    {
                        $expiry = Carbon::now()->addDays($booking->book->expiry_days ?? 365);
                        $booking->update([
                            'status'=>'Verified',
                            'verificationMode'=>'Esewa',
                            'paymentAmount'=> $json_response->total_amount,
                            'remarks'=>'Booked by Student with Direct Esewa Payment For Product ID: '.$json_response->transaction_uuid.'  and Transaction Code: '.$json_response->ref_id,
                            'updatedBy'=>auth()->user()->name,
                            'expiry_date' => $expiry,
                        ]);

                        return redirect('/student/pdf-bank-bookings')->with('success_message','Transction Completed Succesfully.');
                    }

                }

            }

        }

        return redirect("/student/pdf-bank-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');

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
                        $expiry = Carbon::now()->addDays($booking->book->expiry_days ?? 365);
                        $booking->update([
                            'status'=>'Verified',
                            'verificationMode'=>'Fonepay',
                            'paymentAmount'=> $pamt,
                            'remarks'=>'Booked by Student with Direct Fonepay Payment with Unique Retrival Reference Number: '.$uid,
                            'updatedBy'=>auth()->user()->name,
                            'expiry_date' => $expiry,
                        ]);

                        return redirect('/student/pdf-bank-bookings')->with('success_message','Transction Completed Succesfully.');
                    }
                }
                 
            } 
            catch (\Throwable $th) {
                // throw $th;
                return redirect("/student/pdf-bank-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
            }

        }       
        return redirect("/student/pdf-bank-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');

    }
    
}
