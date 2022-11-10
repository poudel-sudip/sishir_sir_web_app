<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Booking;
use App\Models\User;
use App\Models\Vendors\VendorBooking;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendor=auth()->user()->vendor;
        $bookings=$vendor->mybookings->sortByDesc('id')->take(300);
        return view('vendors.bookings.index',compact('bookings'));
    }

    public function allBookings()
    {
        $vendor=auth()->user()->vendor;
        $bookings=$vendor->mybookings->sortByDesc('id');
        return view('vendors.bookings.allbookings',compact('bookings'));
    }

    public function create()
    {
        $courses=Course::where('status','Active')->get();
        return view('vendors.bookings.create',compact('courses'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data=$request->validate([
            'course_name'=>'numeric | required | min:1',
            'batch_name'=>'numeric | required | min:1',
            'coursePrice'=>'numeric | required',
            'myPrice'=>'numeric | required',
            'count'=>'numeric | required | gte:1',
            'userIds'=>'string | required | min:1',
            'verificationMode'=>'string | required',
            'paymentAmount'=>'numeric|nullable',
            'verificationDocument'=>'nullable | image',
        ]);

        $batch=Batch::find($data['batch_name']);
        $users=explode(",",$data['userIds']);
        array_splice($users,$data['count']);

        $price=(integer)((integer)($data['paymentAmount'])/sizeof($users));  // pay amount per person
        $bookcount = 0;
        $userstr = '';
        $imagePath="";
        if(isset($data['verificationDocument']))
        {
            $imagePath=request('verificationDocument')->store('uploads','public');
        }
        foreach ($users as $row) {
            $user = User::find($row);
            if($user)
            {
                $booking = Booking::create([
                    'course_id'=>$batch->course_id,
                    'batch_id'=>$batch->id,
                    'user_id'=>$user->id,
                    'user_name'=>$user->name,
                    'description'=> 'Manual Booked by Vendor',
                    'updatedBy'=>auth()->user()->name,
                    'verificationMode'=> $data['verificationMode'],
                    'accountNo' => 'Vendor',
                    'paymentAmount'=> $price,
                    'discount'=> ($batch->fee - $batch->discount - $price) ?? 0,
                    'dueAmount'=> '0',
                    'features'=> 'All',
                    'status'=>'Processing',
                    'verificationDocument'=>$imagePath,
                ]);

                $vendor=auth()->user()->vendor;

                $vendor->mybookings()->create([
                    'booking_id'=>$booking->id,
                    'Amount' => $price,
                    'verificationDocument' => $imagePath,
                ]);

                $bookcount ++;
                $userstr .= $user->id . ', ';
            }
        }

        return redirect('/vendor/bookings')->with('success_message', $bookcount.' Bookings of User Id '.$userstr.' Created Succesfully.');

        // dd($data,$users,$data['count'],$price);
    }

    public function show(VendorBooking $vendorbooking)
    {
        $booking=$vendorbooking->booking;
        // dd($vendorbooking,$booking);
        return view('vendors.bookings.show',compact('booking'));
    }

    public function edit(VendorBooking $vendorbooking)
    {
        $booking=$vendorbooking->booking;
        $courses=Course::where('status','Active')->get();
        return view('vendors.bookings.edit',compact('booking','vendorbooking','courses'));
    }

    public function update(Request $request, VendorBooking $vendorbooking)
    {
        // dd($request->all(),$vendorbooking);
        $data=request()->validate([
            'status'=>'string | required',
            'paymentAmount'=>'required|numeric',
            'discount'=>'required|numeric',
            'coursefee'=>'required|numeric|min:1',
            'verificationMode'=>'min:1',
            'remarks'=>'string|nullable',
            'course_name'=>'numeric|required|min:1',
            'batch_name'=>'numeric|required|min:1',
            'features'=>'string|min:3',
        ]);

        $due=(integer)($data['coursefee']-$data['paymentAmount']-$data['discount']);

        $vendorbooking->booking()->update([
            'status'=>$data['status'],
            'paymentAmount'=>$data['paymentAmount'],
            'discount'=>$data['discount'],
            'dueAmount'=>$due,
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=>$data['verificationMode'],
            'features'=>$data['features'],
            'remarks'=>$data['remarks'],
        ]);

        return redirect('/vendor/bookings');
    }

    public function destroy(VendorBooking $vendorbooking)
    {
        $vendorbooking->booking()->delete();
        $vendorbooking->delete();
        return redirect('/vendor/bookings');
    }

    public function next(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "course_name" => "required|numeric|min:1",
            "batch_name" => "required|numeric|min:1",
            "userCount" => "required|numeric|gte:1",
        ]);

        return view('vendors.bookings.paybookings',[
            'course'=>Course::find($request->course_name),
            'batch'=>Batch::find($request->batch_name),
            'user_count'=>$request->userCount,
        ]);
    }

    public function esewaSuccess(Request $request, Batch $batch, $userids)
    {
        $users=explode("-",$userids);
        // dd($request->all(),$userids,$users,$batch);

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
            // dd($response);
            $response_code =trim($this->get_xml_node_value('response_code',$response));
            if($response_code=='Success')
            {
                //create booking
                $price=(integer)((integer)($request->amt)/sizeof($users));  // pay amount per person
                $bookcount = 0;
                $userstr = '';
                foreach ($users as $row) {
                    $user = User::find($row);
                    if($user)
                    {
                        $booking = Booking::create([
                            'course_id'=>$batch->course_id,
                            'batch_id'=>$batch->id,
                            'user_id'=>$user->id,
                            'user_name'=>$user->name,
                            'description'=> 'Booked by Vendor with Esewa Direct Payment',
                            'updatedBy'=>auth()->user()->name,
                            'verificationMode'=> 'Esewa',
                            'accountNo' => 'Vendor',
                            'paymentAmount'=> $price,
                            'discount'=> ($batch->fee - $batch->discount - $price) ?? 0,
                            'dueAmount'=> '0',
                            'features'=> 'All',
                            'status'=>'Verified',
                        ]);

                        $vendor=auth()->user()->vendor;

                        $vendor->mybookings()->create([
                            'booking_id'=>$booking->id,
                            'Amount' => $price,
                        ]);

                        $bookcount ++;
                        $userstr .= $user->id . ', ';

                    }
                }
                //return redirect as 2 bookings of users id 121,123 created success
                return redirect('/vendor/bookings')->with('success_message', $bookcount.' Bookings of User Id '.$userstr.' Created and Verified Succesfully.');

            }

        }

        return redirect('/vendor/bookings')->with('error_message','Booking Transaction Failed. Try Again Later.');

    }

    public function paymentFailed(Request $request, $userids)
    {
        // dd($userids);
        return redirect('/vendor/bookings')->with('error_message','Booking Transaction Failed. Try Again Later.');
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
