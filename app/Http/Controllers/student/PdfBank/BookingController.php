<?php

namespace App\Http\Controllers\Student\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\Ebook\Ebook as PDFBank;
use App\Models\Ebook\EbookBooking as Booking;
use App\Models\MerchantBooking;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = auth()->user()->ebook_bookings;
        return view('student.pdf_bank.booking.index',compact('bookings'));
    }

    public function create()
    {
        $pdfbanks = PDFBank::where('status','=','Active')->get();
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
            return back()->withInput()->with('alreadybooked', 'You Have Already Enrolled This PDF Bank !!!');
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


    public function edit(Booking $booking)
    {
        $data = [];

        $booking->booking_price = (($booking->book->price ?? 0) - ($booking->book->discount ?? 0));
        $trans_id = 'pdfbank-'.$booking->id.'-'.time();
        $esewa_pay_data = null;
        $fonepay_pay_data = null;

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


        return view('student.pdf_bank.booking.edit',$data);
    }

    public function update(Request $request, Booking $booking)
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

                        $booking->update([
                            'status'=>'Verified',
                            'verificationMode'=>'Esewa',
                            'paymentAmount'=> $json_response->total_amount,
                            'remarks'=>'Booked by Student with Direct Esewa Payment For Product ID: '.$json_response->transaction_uuid.'  and Transaction Code: '.$json_response->ref_id,
                            'updatedBy'=>auth()->user()->name,
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

        if(isset($request->PRN) && isset($request->UID) && isset($request->P_AMT))
        {
            try 
            {
                $sharedSecretKey = config('payment.fonepay_secret_key');
                $url = config('payment.fonepay_verify_url');
                $pid = config('payment.fonepay_pid'); 
                $uid = $request->UID;
                $prn = $request->PRN;
                $bid = $request->BID ?? '';
                $amt = (($booking->book->price ?? 0) - ($booking->book->discount ?? 0));

                $data = http_build_query(array(
                    'PRN' => $prn,    
                    'PID' => $pid,    
                    'BID' => $bid,    
                    'AMT' => $amt, // original payment amount    
                    'UID' => $uid,    
                    'DV' => hash_hmac('sha512', $pid . ',' . $amt . ',' . $prn . ',' . $bid . ',' . $uid, $sharedSecretKey),

                ));           
                                    
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $data);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $responseXML = curl_exec($ch);
                $response = simplexml_load_string($responseXML);

                if($response->success == 'true')
                {
                    if($response->response_code == 'successful' && $response->statusCode == 0)
                    {
                        $booking->update([
                            'status'=>'Verified',
                            'verificationMode'=>'Fonepay',
                            'paymentAmount'=> $response->txnAmount,
                            'remarks'=>'Booked by Student with Direct Fonepay Payment with Unique Code: '.$response->uniqueId,
                            'updatedBy'=>auth()->user()->name,
                        ]);

                        return redirect('/student/pdf-bank-bookings')->with('success_message','Transction Completed Succesfully.');
                    }
                }
                
            } 
            catch (\Throwable $th) {
                //throw $th;
                return redirect("/student/pdf-bank-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
            }

        }       

        return redirect("/student/pdf-bank-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');

    }
    
}
