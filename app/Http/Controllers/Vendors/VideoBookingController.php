<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoBooking;
use App\Models\Vendors\VendorVideoBooking;
use App\Models\User;

class VideoBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendor=auth()->user()->vendor;
        $bookings=$vendor->videoBookings->sortByDesc('id')->take(300);
        return view('vendors.videocourse.index',compact('bookings'));
    }

    public function allBookings()
    {
        $vendor=auth()->user()->vendor;
        $bookings=$vendor->videoBookings->sortByDesc('id');
        return view('vendors.videocourse.allbookings',compact('bookings'));
    }

    public function create()
    {
        $courses = VideoCourse::where('status','=','Active')->get();
        return view('vendors.videocourse.create',compact('courses'));
    }

    public function show(VendorVideoBooking $booking)
    {
        // dd($booking,$booking->booking);
        $booking=$booking->booking;
        return view('vendors.videocourse.show',compact('booking'));
    }

    public function edit(VendorVideoBooking $videobooking)
    {
        $booking=$videobooking->booking;
        return view('vendors.videocourse.edit',compact('booking','videobooking'));
    }
    
    public function update(Request $request, VendorVideoBooking $videobooking)
    {
        // dd($request->all(),$videobooking);
        $data=request()->validate([
            'status'=>'string | required',
            'paymentAmount'=>'required|numeric',
            'discount'=>'required|numeric',
            'coursefee'=>'required|numeric|min:1',
            'verificationMode'=>'min:1',
            'remarks'=>'string|nullable',
            'course'=>'string|required|min:1',
        ]);

        $due=(integer)($data['coursefee']-$data['paymentAmount']-$data['discount']);

        $videobooking->booking()->update([
            'status'=>$data['status'],
            'paymentAmount'=>$data['paymentAmount'],
            'discount'=>$data['discount'],
            'dueAmount'=>$due,
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=>$data['verificationMode'],
            'remarks'=>$data['remarks'],
        ]);

        return redirect('/vendor/video-booking');
    }

    public function next(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "course" => "required|numeric|min:1",
            "userCount" => "required|numeric|gte:1",
        ]);

        return view('vendors.videocourse.paybookings',[
            'course'=>VideoCourse::find($request->course),
            'user_count'=>$request->userCount,
        ]);
    }

    public function paymentFailed(Request $request, $userids)
    {
        // dd($userids);
        return redirect('/vendor/video-booking')->with('error_message','Booking Transaction Failed. Try Again Later.');
    }

    public function esewaSuccess(Request $request, VideoCourse $course, $userids)
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
                        $booking = VideoBooking::create([
                            'user_id' => $user->id,
                            'course_id' => $course->id,
                            'user_name' => $user->name,
                            'status' => 'Verified',
                            'remarks' => 'Booked By Vendor with Esewa Direct Payment',
                            'updatedBy' =>auth()->user()->name,
                            'verificationMode' => 'Esewa',
                            'paidAmount' => $price,
                            'discount' => ($course->fee - $course->discount - $price) ?? 0,
                            'dueAmount' => '0',
                        ]);

                        $vendor=auth()->user()->vendor;

                        $vendor->videoBookings()->create([
                            'booking_id'=>$booking->id,
                            'Amount' => $price,
                        ]);

                        $bookcount ++;
                        $userstr .= $user->id . ', ';
                    }
                }

                return redirect('/vendor/video-booking')->with('success_message', $bookcount.' Bookings of User Id '.$userstr.' Created and Verified Succesfully.');
            }
        }

        return redirect('/vendor/video-booking')->with('error_message','Booking Transaction Failed. Try Again Later.');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data=$request->validate([
            'course'=>'numeric | required | min:1',
            'coursePrice'=>'numeric | required',
            'myPrice'=>'numeric | required',
            'count'=>'numeric | required | gte:1',
            'userIds'=>'string | required | min:1',
            'verificationMode'=>'string | required',
            'paymentAmount'=>'numeric|nullable',
            'verificationDocument'=>'nullable | image',
        ]);

        $users=explode(",",$data['userIds']);
        array_splice($users,$data['count']);
        $course = VideoCourse::find($data['course']);
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
                $booking = VideoBooking::create([
                    'course_id'=>$course->id,
                    'user_id'=>$user->id,
                    'user_name'=>$user->name,
                    'remarks'=> 'Manual Booked by Vendor',
                    'updatedBy'=>auth()->user()->name,
                    'verificationMode'=> $data['verificationMode'],
                    'accountNo' => 'Vendor',
                    'paymentAmount'=> $price,
                    'discount'=> ($course->fee - $course->discount - $price) ?? 0,
                    'dueAmount'=> '0',
                    'status'=>'Processing',
                    'verificationDocument'=>$imagePath,
                ]);

                $vendor=auth()->user()->vendor;
                $vendor->videoBookings()->create([
                    'booking_id'=>$booking->id,
                    'Amount' => $price,
                    'verificationDocument' => $imagePath,
                ]);

                $bookcount ++;
                $userstr .= $user->id . ', ';
            
            }
        }

        return redirect('/vendor/video-booking')->with('success_message', $bookcount.' Bookings of User Id '.$userstr.' Created Succesfully.');
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

    public function destroy(VendorVideoBooking $videobooking)
    {
        $videobooking->booking()->delete();
        $videobooking->delete();
        return redirect('/vendor/video-booking');
    }

}
