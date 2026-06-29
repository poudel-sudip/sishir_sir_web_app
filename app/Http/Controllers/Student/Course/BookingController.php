<?php

namespace App\Http\Controllers\Student\Course;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Categories;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MerchantBooking;

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

        return redirect('/student/course-bookings/'.$booking->id.'/edit');

    }

    public function destroy(Request $request, Booking $booking)
    {
        // dd($booking);
        if($booking->status == 'Verified')
        {
            abort(403,'Cannot Delete Verified Booking.');
        }
        $booking->delete();
        return redirect('/student/course-bookings');
    }

    public function edit(Booking $booking, Request $request)
    {
        $data = [];

        $booking->booking_price = (($booking->batch->fee ?? 0) - ($booking->batch->discount ?? 0));
        $trans_id = 'course-'.$booking->id.'-'.time();
        $booking->trans_id = $trans_id;
        $data['booking'] = $booking;

        return view('student.courses.bookings.verify',$data);
    }

    public function paymentFailed(Booking $booking, Request $request)
    {
        return redirect("/student/course-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
    }

    public function manualVerify(Request $request, Booking $booking)
    {
        // dd($request->all(),$booking);
        $request->validate([
            'bookingid'=>'required|numeric',
            'course_id'=>'required|string|min:1',
            'batch_id'=>'required|string|min:1',
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

        return redirect('/student/course-bookings');
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
            abort(403,'Cannot Access Videos Unverified Booking.');
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
   

    // public function index()
    // {
    //     $data = [];
    //     $data['bookings'] = auth()->user()->course_bookings()->get();
    //     return view('student.courses.bookings.index',$data);
    // }

    // public function create()
    // {
    //     $data = [];
    //     $data['courses'] = Course::where('status','=','Active')->get();
    //     return view('student.courses.bookings.create',$data);
    // }

    // public function store()
    // {
    //     $data=request()->validate([
    //         'course_name'=>'integer | required | min:1',
    //         'batch_name'=>'integer | required | min:1',
    //         'description'=>'string | nullable',
    //     ]);
    //     $search=Booking::where([
    //         ['course_id','=',$data['course_name']],
    //         ['batch_id','=',$data['batch_name']],
    //         ['user_id','=',auth()->user()->id],
    //         ])->count();
    //     if($search){
    //         return back()->withInput()->with('alreadybooked', 'You Have Already Booked This Course!');
    //     }
    //     $booking=Booking::create([
    //         'course_id'=>$data['course_name'],
    //         'batch_id'=>$data['batch_name'],
    //         'user_id'=> auth()->user()->id,
    //         'user_name'=>auth()->user()->name,
    //         'description'=>$data['description'],
    //         'status'=>'Unverified',
    //         'updatedBy'=>auth()->user()->name,
    //     ]);
    //     return redirect('/student/course-bookings/'.$booking->id.'/edit');
    // }

    // public function show(Booking $booking)
    // {
    //     return view('student.courses.bookings.show',compact('booking'));
    // }

    // public function edit(Booking $booking)
    // {
    //     return view('student.courses.bookings.verify',compact('booking'));
    // }

    // public function update(Booking $booking)
    // { 
    //     $data=request()->validate([
    //         'verificationMode'=>'required | string',
    //         'paymentAmount'=>'required | integer',
    //         'verificationDocument'=>'required | image',
    //     ]);
    //     $imagePath=request('verificationDocument')->store('uploads','public');

    //     $booking->update([
    //         'verificationMode'=>$data['verificationMode'],
    //         'paymentAmount'=>$data['paymentAmount'],
    //         'verificationDocument'=>$imagePath,
    //         'status'=>'Processing',
    //     ]);
        
    //     // return redirect('/student/home');
    //     return redirect('/student/course-bookings');
    // }

    // public function destroy(Booking $booking)
    // {
    //     // dd($booking);
    //     $booking->delete();
    //     return redirect('/student/course-bookings');
    // }

    // public function esewaSuccess(Booking $booking, Request $request)
    // {
    //     // dd($request, $booking);
    //     if(isset($request->oid) && isset($request->amt) && isset($request->refId))
    //     {
    //         // dd($request->all(), $booking);
    //         $url = config('payment.esewa_verify_url');
    //         $data =[
    //             'amt'=> ($booking->batch->fee - $booking->batch->discount),
    //             'rid'=> $request->refId,
    //             'pid'=> $request->oid,
    //             'scd'=> config('payment.esewa_scd')
    //         ];
            
    //         $curl = curl_init($url);
    //         curl_setopt($curl, CURLOPT_POST, true);
    //         curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    //         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //         $response = curl_exec($curl);
    //         curl_close($curl);
    //         // dd($response);
    //         $response_code =trim($this->get_xml_node_value('response_code',$response));
    //         // dd($response_code);
    //         if($response_code=='Success')
    //         {
    //             $booking->update([
    //                 'status'=>'Verified',
    //                 'verificationMode'=>'Esewa',
    //                 'paymentAmount'=>$data['amt'],
    //                 'remarks'=>'Booked by Student with Direct Esewa Payment',
    //                 'description'=>'Booked by Student with Direct Esewa Payment',
    //                 'updatedBy'=>auth()->user()->name,
    //             ]);
    //             // MerchantBooking::create([
    //             //     'type' => 'course',
    //             //     'title' => $booking->batch->name ?? '',
    //             //     'merchant' => 'esewa',
    //             //     'booking_id' => $booking->id,
    //             // ]);

    //             return redirect('/student/course-classroom')->with('success_message','Transction Completed Succesfully.');
    //         }
    //     }

    //     return redirect("/student/course-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');

    // }

    // public function khaltiSuccess(Booking $booking, Request $request)
    // {
    //     $args = http_build_query(array(
    //         'token' => $request->token,
    //         'amount'  => ($booking->batch->fee - $booking->batch->discount) * 100
    //     ));
        
    //     $url = config('payment.khalti_verify_url');
        
    //     # Make the call using API.
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_POST, 1);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
    //     $headers = ['Authorization: Key '.config('payment.khalti_secret_key')];
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
    //     // Response
    //     $response = curl_exec($ch);
    //     $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //     curl_close($ch);
        
    //     if($status_code == 200)
    //     {
    //         $booking->update([
    //             'status'=>'Verified',
    //             'verificationMode'=>'Khalti',
    //             'paymentAmount'=>($booking->batch->fee - $booking->batch->discount),
    //             'remarks'=>'Booked by Student with Direct Khalti Payment',
    //             'description'=>'Booked by Student with Direct Khalti Payment',
    //             'updatedBy'=>auth()->user()->name,
    //         ]);
    //         // MerchantBooking::create([
    //         //     'type' => 'course',
    //         //     'title' => $booking->batch->name ?? '',
    //         //     'merchant' => 'khalti',
    //         //     'booking_id' => $booking->id,
    //         // ]);
    //         return response()->json([
    //             'success' => 1,
    //             'redirecto' => url('/student/course-classroom')
    //         ], 200);
    //     }
    //     else
    //     {
    //         return response()->json([
    //             'error' => 1,
    //             'message' => 'Payment Failed. Please try again later.'
    //         ]);
    //     }
        
    // }

    // public function paymentFailed(Booking $booking, Request $request)
    // {
    //     return redirect("/student/course-bookings/$booking->id/edit")->with('error_message','Transaction Failed. Try Again Later.');
    // }
    
    // public function classroom()
    // {
    //     $data = [];
    //     $data['bookings'] = auth()->user()->bookings()->where([['status','=','Verified'],['suspended','=',false]])->orderByDesc('id')->get();
    //     return view('student.courses.bookings.classroom',$data);
    // }

}
