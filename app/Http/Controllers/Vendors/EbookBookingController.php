<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\EbookBooking;
use App\Models\Vendors\VendorEbookBooking;
use App\Models\User;
class EbookBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendor=auth()->user()->vendor;
        $bookings=$vendor->ebookBookings->sortByDesc('id')->take(300);
        return view('vendors.ebook.index',compact('bookings'));
    }

    public function allBookings()
    {
        $vendor=auth()->user()->vendor;
        $bookings=$vendor->ebookBookings->sortByDesc('id');
        return view('vendors.ebook.allbookings',compact('bookings'));
    }

    public function create()
    {
        $books = Ebook::where('status','=','Active')->get();
        return view('vendors.ebook.create',compact('books'));
    }

    public function next(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "book" => "required|numeric|min:1",
            "userCount" => "required|numeric|gte:1",
        ]);

        return view('vendors.ebook.paybookings',[
            'book'=>Ebook::find($request->book),
            'user_count'=>$request->userCount,
        ]);
    }

    public function paymentFailed(Request $request, $userids)
    {
        // dd($userids);
        return redirect('/vendor/ebook-booking')->with('error_message','Booking Transaction Failed. Try Again Later.');
    }

    public function esewaSuccess(Request $request, Ebook $book, $userids)
    {
        $users=explode("-",$userids);
        if(isset($request->oid) && isset($request->amt) && isset($request->refId))
        {
            $url = "https://esewa.com.np/epay/transrec";
            $data =[
                'amt'=> $request->amt,
                'rid'=> $request->refId,
                'pid'=> $request->oid,
                'scd'=> 'NP-ES-ODADEPL',
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
                $price=(integer)((integer)($request->amt)/sizeof($users));  // pay amount per person
                $bookcount = 0;
                $userstr = '';
                foreach ($users as $row)
                {
                    $user = User::find($row);
                    if($user)
                    {
                        $booking = EbookBooking::create([
                            'user_id' => $user->id,
                            'book_id' => $book->id,
                            'user_name' => $user->name,
                            'status' => 'Verified',
                            'remarks' => 'Booked By Vendor with Esewa Direct Payment',
                            'updatedBy' =>auth()->user()->name,
                            'verificationMode' => 'Esewa',
                            'paidAmount' => $price,
                            'discount' => ($book->price - $book->discount - $price) ?? 0,
                            'dueAmount' => '0',
                        ]);

                        $vendor=auth()->user()->vendor;

                        $vendor->ebookBookings()->create([
                            'booking_id'=>$booking->id,
                            'Amount' => $price,
                        ]);

                        $bookcount ++;
                        $userstr .= $user->id . ', ';
                    }
                }

                return redirect('/vendor/ebook-booking')->with('success_message', $bookcount.' Bookings of User Id '.$userstr.' Created and Verified Succesfully.');
            }
        }

        return redirect('/vendor/ebook-booking')->with('error_message','Booking Transaction Failed. Try Again Later.');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data=$request->validate([
            'book'=>'numeric | required | min:1',
            'bookPrice'=>'numeric | required',
            'myPrice'=>'numeric | required',
            'count'=>'numeric | required | gte:1',
            'userIds'=>'string | required | min:1',
            'verificationMode'=>'string | required',
            'paymentAmount'=>'numeric|nullable',
            'verificationDocument'=>'nullable | image',
        ]);

        $users=explode(",",$data['userIds']);
        array_splice($users,$data['count']);
        $book = Ebook::find($data['book']);
        $price=(integer)((integer)($data['paymentAmount'])/sizeof($users));  // pay amount per person
        $bookcount = 0;
        $userstr = '';
        $imagePath="";

        if(isset($data['verificationDocument']))
        {
            $imagePath=request('verificationDocument')->store('uploads','public');
        }
        foreach ($users as $row) 
        {
            $user = User::find($row);
            if($user)
            {
                $booking = EbookBooking::create([
                    'book_id'=>$book->id,
                    'user_id'=>$user->id,
                    'user_name'=>$user->name,
                    'remarks'=> 'Manual Booked by Vendor',
                    'updatedBy'=>auth()->user()->name,
                    'verificationMode'=> $data['verificationMode'],
                    'accountNo' => 'Vendor',
                    'paymentAmount'=> $price,
                    'discount'=> ($book->price - $book->discount - $price) ?? 0,
                    'dueAmount'=> '0',
                    'status'=>'Processing',
                    'verificationDocument'=>$imagePath,
                ]);

                $vendor=auth()->user()->vendor;
                $vendor->ebookBookings()->create([
                    'booking_id'=>$booking->id,
                    'Amount' => $price,
                    'verificationDocument' => $imagePath,
                ]);

                $bookcount ++;
                $userstr .= $user->id . ', ';
            
            }
        }

        return redirect('/vendor/ebook-booking')->with('success_message', $bookcount.' Bookings of User Id '.$userstr.' Created Succesfully.');
    }

    public function show(VendorEbookBooking $booking)
    {
        // dd($booking,$booking->booking);
        $booking=$booking->booking;
        return view('vendors.ebook.show',compact('booking'));
    }


    public function edit(VendorEbookBooking $vendorbooking)
    {
        $booking=$vendorbooking->booking;
        return view('vendors.ebook.edit',compact('booking','vendorbooking'));
    }

    public function update(Request $request, VendorEbookBooking $vendorbooking)
    {
        // dd($request->all(),$vendorbooking);
        $data=request()->validate([
            'status'=>'string | required',
            'paymentAmount'=>'required|numeric',
            'discount'=>'required|numeric',
            'bookfee'=>'required|numeric|min:1',
            'verificationMode'=>'min:1',
            'remarks'=>'string|nullable',
            'book'=>'string|required|min:1',
        ]);

        $due=(integer)($data['bookfee']-$data['paymentAmount']-$data['discount']);

        $vendorbooking->booking()->update([
            'status'=>$data['status'],
            'paymentAmount'=>$data['paymentAmount'],
            'discount'=>$data['discount'],
            'dueAmount'=>$due,
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=>$data['verificationMode'],
            'remarks'=>$data['remarks'],
        ]);

        return redirect('/vendor/ebook-booking');
    }

    public function destroy(VendorEbookBooking $vendorbooking)
    {
        $vendorbooking->booking()->delete();
        $vendorbooking->delete();
        return redirect('/vendor/ebook-booking');
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
