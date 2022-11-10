<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\User;
use App\Models\Vendors\VendorExamBooking;

class ExamBookingController extends Controller
{
    public function index()
    {
        $vendor=auth()->user()->vendor;
        $bookings=$vendor->examBookings->sortByDesc('id')->take(300);
        return view('vendors.examhall.index',compact('bookings'));
    }

    public function allBookings()
    {
        $vendor=auth()->user()->vendor;
        $bookings=$vendor->examBookings->sortByDesc('id');
        return view('vendors.examhall.allbookings',compact('bookings'));
    }

    public function create()
    {
        $exams = ExamHallCategories::where('status','=','Active')->get();
        return view('vendors.examhall.create',compact('exams'));
    }

    public function show(VendorExamBooking $booking)
    {
        // dd($booking,$booking->booking);
        $booking=$booking->booking;
        return view('vendors.examhall.show',compact('booking'));
    }

    public function next(Request $request)
    {
        // dd($request->all());
        $request->validate([
            "exam_name" => "required|numeric|min:1",
            "userCount" => "required|numeric|gte:1",
        ]);

        return view('vendors.examhall.paybookings',[
            'exam'=>ExamHallCategories::find($request->exam_name),
            'user_count'=>$request->userCount,
        ]);
    }

    public function edit(VendorExamBooking $exambooking)
    {
        $booking=$exambooking->booking;
        // dd($booking,$exambooking);
        return view('vendors.examhall.edit',compact('booking','exambooking'));
    }

    public function destroy(VendorExamBooking $booking)
    {
        // dd($booking);
        $booking->booking()->delete();
        $booking->delete();
        return redirect('/vendor/exam-hall/bookings');
    }

    public function paymentFailed(Request $request, $userids)
    {
        // dd($userids);
        return redirect('/vendor/exam-hall/bookings')->with('error_message','Booking Transaction Failed. Try Again Later.');
    }

    public function esewaSuccess(Request $request, ExamHallCategories $exam, $userids)
    {
        // dd($request->all(),$exam,$userids);
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
            // dd($response);
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
                        $booking = ExamHallBookings::create([
                            'user_id' => $user->id,
                            'category_id' => $exam->id,
                            'user_name' => $user->name,
                            'status' => 'Verified',
                            'remarks' => 'Booked By Vendor with Esewa Direct Payment',
                            'updatedBy' =>auth()->user()->name,
                            'verificationMode' => 'Esewa',
                            'paidAmount' => $price,
                            'discount' => ($exam->price - $exam->discount - $price) ?? 0,
                            'dueAmount' => '0',
                        ]);

                        $vendor=auth()->user()->vendor;

                        $vendor->examBookings()->create([
                            'booking_id'=>$booking->id,
                            'Amount' => $price,
                        ]);

                        $bookcount ++;
                        $userstr .= $user->id . ', ';
                    }
                }
                return redirect('/vendor/exam-hall/bookings')->with('success_message', $bookcount.' Bookings of User Id '.$userstr.' Created and Verified Succesfully.');

            }
        }

        return redirect('/vendor/exam-hall/bookings')->with('error_message','Booking Transaction Failed. Try Again Later.');

    }

    public function update(Request $request, VendorExamBooking $vendorbooking)
    {
        // dd($request->all(),$vendorbooking);
        $data=request()->validate([
            "bookingid" => "required|numeric",
            "exam_category" => "required|string",
            "examfee" => "required|numeric",
            "paymentAmount" => "required|numeric",
            "discount" => "numeric|nullable",
            "verificationMode" => "required|string",
            "status" => "required|string",
            "remarks" => "nullable|string",
        ]);

        $due=(integer)($data['examfee']-$data['paymentAmount']-$data['discount']);

        $vendorbooking->booking()->update([
            'status'=>$data['status'],
            'paidAmount'=>$data['paymentAmount'],
            'discount'=>$data['discount'],
            'dueAmount'=>$due,
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=>$data['verificationMode'],
            'remarks'=>$data['remarks'],
        ]);

        return redirect('/vendor/exam-hall/bookings');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $data=$request->validate([
            'exam_name'=>'numeric | required | min:1',
            'examPrice'=>'numeric | required',
            'myPrice'=>'numeric | required',
            'count'=>'numeric | required | gte:1',
            'userIds'=>'string | required | min:1',
            'verificationMode'=>'string | required',
            'paymentAmount'=>'numeric|nullable',
            'verificationDocument'=>'nullable | image',
        ]);

        $users=explode(",",$data['userIds']);
        array_splice($users,$data['count']);
        $exam = ExamHallCategories::find($data['exam_name']);
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
                $booking = ExamHallBookings::create([
                    'user_id' => $user->id,
                    'category_id' => $exam->id,
                    'user_name' => $user->name,
                    'status' => 'Processing',
                    'remarks' => 'Manual Booked by Vendor',
                    'updatedBy' =>auth()->user()->name,
                    'verificationMode' => $data['verificationMode'],
                    'paidAmount' => $price,
                    'discount' => ($exam->price - $exam->discount - $price) ?? 0,
                    'dueAmount' => '0',
                    'verificationDocument'=>$imagePath,
                ]);

                $vendor=auth()->user()->vendor;
                $vendor->examBookings()->create([
                    'booking_id'=>$booking->id,
                    'Amount' => $price,
                    'verificationDocument' => $imagePath,
                ]);

                $bookcount ++;
                $userstr .= $user->id . ', ';
            }
        }

        return redirect('/vendor/exam-hall/bookings')->with('success_message', $bookcount.' Bookings of User Id '.$userstr.' Created Succesfully.');
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
