<?php

namespace App\Http\Controllers\Moderator\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Course;
use App\Models\User;
use App\Models\Batch;
use Illuminate\Support\Facades\Auth;

class BookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $batchids = Batch::where('user_id','=',auth()->user()->id)->select('id','user_id')->pluck('id')->values();

        $data['bookings'] = Booking::with('user:id,name,email,contact')
        ->whereIn('batch_id',$batchids)
        ->orderByDesc('id')
        ->paginate(100);

        return view('moderator.courses.booking.index',$data);
    }

    public function statusBookings(Request $request)
    {
        $status = null;
        if($request->status)
        {
            $status = ucwords(trim($request->status));
        }
        
        $batchids = Batch::where('user_id','=',auth()->user()->id)->select('id','user_id')->pluck('id')->values();

        $data['status'] = $status;
        $data['bookings'] = Booking::with('user:id,name,email,contact')
        ->whereIn('batch_id',$batchids)
        ->where('status','=',$status)
        ->orderByDesc('id')->paginate(100);
        return view('moderator.courses.booking.status',$data);
    }

    public function batchBookings(Course $course, Batch $batch, Request $request)
    {
        if($batch->user_id != auth()->user()->id)
        {
            abort(403, 'You are not authorized to view this data.');
        }

        $status = $batch->name;
        $data['status'] = $status;
        $data['bookings'] = Booking::with('user:id,name,email,contact')->where('batch_id','=',$batch->id)->orderByDesc('id')->paginate(100);
        return view('moderator.courses.booking.status',$data);
    }

    public function allBookings(Request $request)
    {
        $batchids = Batch::where('user_id','=',auth()->user()->id)->select('id','user_id')->pluck('id')->values();

        $bookings = Booking::whereIn('batch_id',$batchids)->get();

        return view('moderator.courses.booking.all',compact('bookings'));
    }

    public function create()
    {
        $courses = Course::whereIn('status',['Active','Running'])->get();
        return view('moderator.courses.booking.create',compact('courses'));
    }

    public function store()
    {
        // dd(request()->all());
        $data=request()->validate([
            'course_name'=>'integer | required | min:1',
            'batch_name'=>'integer | required | min:1',
            'userid'=>'numeric | required | min:1',
            'status'=>'string | required',
            'verificationMode'=>'string|required',
            'paymentAmount'=>'numeric|nullable',
            'discount'=>'numeric|nullable',
            'verificationDocument'=>'nullable | image',
            'expiry_days'=>'numeric|nullable',
        ]);

        $batch = Batch::find($data['batch_name']);
        $user = User::find($data['userid']);

        $search = Booking::where([
            ['batch_id','=',$data['batch_name']],
            ['user_id','=',$data['userid']],
        ])->count();

        if($search){
            return back()->withInput()->withErrors(['batch_name'=>'This Course Batch is Already Booked by the Given User. Please Check Again !!!']);
        }

        if(!$user)
        {
            return back()->withInput()->withErrors(['userid'=>'User Not Registered. Please Check Again !!!']);
        }

        $due=(integer)(($batch->fee-$batch->discount)-$data['paymentAmount']-$data['discount']);
        $imagePath="";
        if(isset($data['verificationDocument']))
        {
            $imagePath = request('verificationDocument')->store('uploads/courses/batch_'.$batch->id.'/payments','public');
        }  
        
        $expiry_days = (int)($data['expiry_days'] ?? 365);
        $expiry_date = Carbon::now()->addDays($expiry_days)->format('Y-m-d');
        
        Booking::create([
            'batch_id'=>$batch->id,
            'user_id'=>$user->id,
            'user_name'=>$user->name,
            'status'=>$data['status'],
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=>$data['verificationMode'] ?? '',
            'paymentAmount'=>$data['paymentAmount'] ?? 0,
            'discount'=>$data['discount'] ?? 0,
            'dueAmount'=>$due,
            'verificationDocument'=>$imagePath,
            'expiry_date'=>$expiry_date,
        ]);

        return redirect('/moderator/course-bookings');
    }

    public function show($booking)
    {
        $booking = Booking::find($booking); 
        if(!$booking)
        {
            abort(404);
        }

        $expiry = Carbon::parse($booking->expiry_date ?? date('Y-m-d'));
        $today = Carbon::today();
        $daysToExpire = Carbon::parse($today)->diffInDays($expiry, false);
        $daysToExpire = max(0, $daysToExpire);
        $booking->expiry_days = (int)$daysToExpire;

        return view('moderator.courses.booking.show',compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $batchids = Batch::where('user_id','=',auth()->user()->id)->select('id','user_id')->pluck('id')->values();
        if(!in_array($booking->batch_id,$batchids))
        {
            abort(403, 'You are not authorized to update this data.');
        }

        $expiry = Carbon::parse($booking->expiry_date ?? date('Y-m-d'));
        $today = Carbon::today();
        $daysToExpire = Carbon::parse($today)->diffInDays($expiry, false);
        $daysToExpire = max(0, $daysToExpire);
        $booking->expiry_days = (int)$daysToExpire;

        // dd($booking,$daysToExpire);
        $courses = Course::where('status','Active')->get();
        return view('moderator.courses.booking.edit',compact('booking','courses'));
    }

    public function update(Booking $booking)
    {
        // dd(request()->all());
        $data=request()->validate([
            'status'=>'string | required',
            'uploadDocument'=>'image|nullable',
            'oldDocument'=>'string|nullable',
            'paymentAmount'=>'required|numeric',
            'discount'=>'required|numeric',
            // 'suspended'=>'required|boolean',
            'verificationMode'=>'min:1',
            'remarks'=>'string|nullable',
            'course_name'=>'numeric|required|min:1',
            'batch_name'=>'numeric|required|min:1',
            'expiry_days'=>'numeric|nullable',
        ]);

        $batch = Batch::find($data['batch_name']);

        // dd(request()->all(),$data,$batch);

        $due = (integer)(($batch->fee-$batch->discount)-$data['paymentAmount']-$data['discount']);

        $img = $data['oldDocument'];
        if(isset($data['uploadDocument']))
        {
            $img = request('uploadDocument')->store('uploads/courses/batch_'.$batch->id.'/payments','public');
        }

        $expiry_days = (int)($data['expiry_days'] ?? 365);
        if($expiry_days > 0)
        {
            $expiry = Carbon::now()->addDays($expiry_days)->format('Y-m-d');
            $booking->update([
                'expiry_date'=>$expiry,
            ]);
        }
        
        $booking->update([
            'status'=>$data['status'],
            'paymentAmount'=>$data['paymentAmount'],
            'discount'=>$data['discount'],
            'dueAmount'=>$due,
            'verificationDocument'=>$img,
            'updatedBy'=>auth()->user()->name,
            // 'suspended'=>$data['suspended'],
            'verificationMode'=>$data['verificationMode'],
            'remarks'=>$data['remarks'],
            'batch_id'=>$batch->id,
        ]);

        return redirect('/moderator/course-bookings');
    }

    public function destroy(Booking $booking)
    {
        $batchids = Batch::where('user_id','=',auth()->user()->id)->select('id','user_id')->pluck('id')->values();
        if(!in_array($booking->batch_id,$batchids))
        {
            abort(403, 'You are not authorized to delete this data.');
        }

        $booking->delete();
        return redirect('/moderator/course-bookings');
    }

    

}
