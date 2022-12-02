<?php

namespace App\Http\Controllers\Student\Ebook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\EbookBooking;
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
        return view('student.ebook.booking.index',compact('bookings'));
    }

    public function create()
    {
        $books = Ebook::where('status','=','Active')->get();
        return view('student.ebook.booking.create',compact('books'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'book'=>'required|numeric|min:1',
            'remarks'=>'string|nullable',
        ]);
        $search=EbookBooking::where([
            ['book_id','=',$request->book],
            ['user_id','=',auth()->user()->id],
        ])->count();
            
        if($search){
            return back()->withInput()->with('alreadybooked', 'You Have Already Enrolled This E-Book !!!');
        }

        $booking= EbookBooking::create([
            'user_id'=>auth()->user()->id,
            'book_id'=>$request->book,
            'user_name'=>auth()->user()->name,
            'status'=>'Unverified',
            'updatedBy'=>auth()->user()->name,
            'remarks'=>$request->remarks,
        ]);

        return redirect('/student/ebook-bookings/'.$booking->id.'/edit');
    }

    public function edit(EbookBooking $booking)
    {
        return view('student.ebook.booking.edit',compact('booking'));
    }

    public function update(Request $request, EbookBooking $booking)
    {
        // dd($request->all(),$booking);
        $request->validate([
            "verificationMode" => "string|required|min:1",
            "paymentAmount" => "numeric|required",
            "verificationDocument" => "image|required",
        ]);
        $img = request('verificationDocument')->store('uploads','public');
        $booking->update([
            'verificationMode' => $request->verificationMode,
            'paymentAmount' => $request->paymentAmount,
            'verificationDocument' => $img,
            'status' => 'Processing',
        ]);

        return redirect('/student/ebook-bookings');
    }

    public function destroy(EbookBooking $booking)
    {
        $booking->delete();
        return redirect('/student/ebook-bookings');
    }

    public function paymentFailed(EbookBooking $booking)
    {
        return redirect("/student/ebook-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
    }

    public function esewaSuccess(EbookBooking $booking, Request $request)
    {
        if(isset($request->oid) && isset($request->amt) && isset($request->refId))
        {
            $url = config('payment.esewa_verify_url');
            $data =[
                'amt'=> ($booking->book->price - $booking->book->discount),
                'rid'=> $request->refId,
                'pid'=> $request->oid,
                'scd'=> config('payment.esewa_scd')
            ];
            
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($curl);
            curl_close($curl);
            // dd($response);
            $response_code =trim($this->get_xml_node_value('response_code',$response));
            if($response_code=='Success')
            {
                $booking->update([
                    'status'=>'Verified',
                    'verificationMode'=>'Esewa',
                    'paymentAmount'=>$data['amt'],
                    'remarks'=>'Booked by Student with Direct Esewa Payment',
                    'updatedBy'=>auth()->user()->name,
                ]);
                MerchantBooking::create([
                    'type' => 'ebook',
                    'title' => $booking->book->title ?? '',
                    'merchant' => 'esewa',
                    'booking_id' => $booking->id,
                ]);
                return redirect('/student/ebook-bookings')->with('success_message','Transction Completed Succesfully.');
            }
            
        }

        return redirect("/student/ebook-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
    }

    public function khaltiSuccess(EbookBooking $booking, Request $request)
    {
        $args = http_build_query(array(
            'token' => $request->token,
            'amount'  => ($booking->book->price - $booking->book->discount) * 100
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
                'paymentAmount'=>($booking->book->price - $booking->book->discount),
                'remarks'=>'Booked by Student with Direct Khalti Payment',
                'updatedBy'=>auth()->user()->name,
            ]);
            MerchantBooking::create([
                'type' => 'ebook',
                'title' => $booking->book->title ?? '',
                'merchant' => 'khalti',
                'booking_id' => $booking->id,
            ]);
            return response()->json([
                'success' => 1,
                'redirecto' => url('/student/ebook-bookings')
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
