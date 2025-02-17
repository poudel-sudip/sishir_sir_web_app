<?php

namespace App\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function index()
    {
        $bookings=Booking::all()->sortByDesc('id')->take(300);
        return view('admin.bookings.index',compact('bookings'));
    }

    public function allBookings()
    {
        $bookings=Booking::all();
        return view('admin.bookings.allBookings',compact('bookings'));
    }

    public function create()
    {
        $courses=Course::whereIn('status',['Active','Running'])->get();
        return view('admin.bookings.create',compact('courses'));
    }

    public function store()
    {
        $data=request()->validate([
            'course_name'=>'integer | required | min:1',
            'batch_name'=>'integer | required | min:1',
            'userid'=>'numeric | required | min:1',
            'status'=>'string | required',
            'verificationMode'=>'string|required',
            'paymentAmount'=>'numeric|nullable',
            'discount'=>'numeric|nullable',
            'verificationDocument'=>'nullable | image',
        ]);

        $batch = Batch::find($data['batch_name']);
        $user = User::find($data['userid']);

        $search = Booking::where([
            ['course_id','=',$data['course_name']],
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
            $imagePath=request('verificationDocument')->store('uploads','public');
        }       
        Booking::create([
            'course_id'=>$data['course_name'],
            'batch_id'=>$data['batch_name'],
            'user_id'=>$user->id,
            'user_name'=>$user->name,
            'status'=>$data['status'],
            'updatedBy'=>auth()->user()->name,
            'verificationMode'=>$data['verificationMode'] ?? '',
            'paymentAmount'=>$data['paymentAmount'] ?? 0,
            'discount'=>$data['discount'] ?? 0,
            'dueAmount'=>$due,
            'verificationDocument'=>$imagePath,
        ]);
        return redirect('/admin/bookings');
    }

    public function show($booking)
    {
        $booking = Booking::find($booking); 
        if(!$booking)
        {
            abort(404);
        }
        return view('admin.bookings.show',compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $courses=Course::where('status','Active')->get();
        return view('admin.bookings.edit',compact('booking','courses'));
    }

    public function update(Booking $booking)
    {
        $data=request()->validate([
            'status'=>'string | required',
            'uploadDocument'=>'image|nullable',
            'oldDocument'=>'string|nullable',
            'paymentAmount'=>'required|numeric',
            'discount'=>'required|numeric',
            'suspended'=>'required|boolean',
            'verificationMode'=>'min:1',
            'remarks'=>'string|nullable',
            'course_name'=>'numeric|required|min:1',
            'batch_name'=>'numeric|required|min:1',
        ]);

        $batch = Batch::find($data['batch_name']);

        // dd(request()->all(),$data,$batch);

        $due = (integer)(($batch->fee-$batch->discount)-$data['paymentAmount']-$data['discount']);

        $img = $data['oldDocument'];
        if(isset($data['uploadDocument']))
        {
            $img=request('uploadDocument')->store('uploads','public');
        }
        $booking->update([
            'status'=>$data['status'],
            'paymentAmount'=>$data['paymentAmount'],
            'discount'=>$data['discount'],
            'dueAmount'=>$due,
            'verificationDocument'=>$img,
            'updatedBy'=>auth()->user()->name,
            'suspended'=>$data['suspended'],
            'verificationMode'=>$data['verificationMode'],
            'remarks'=>$data['remarks'],
            'course_id'=>$batch->course_id,
            'batch_id'=>$batch->id,
        ]);

        return redirect('/admin/bookings');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect('/admin/bookings');
    }

    public function verifylist()
    {
        $bookings = Booking::where('status', '=', 'Processing')->get();
        return view('admin.bookings.verifylist',compact('bookings'));
    }

    public function duelist()
    {
        $bookings = Booking::where('status', '=', 'Verified')->where('dueAmount','>','10')->get();
        return view('admin.bookings.duelist',compact('bookings'));
    }

    public function suspendedlist()
    {
        $bookings = Booking::where('suspended', '=', true)->get();
        return view('admin.bookings.suspendlist',compact('bookings'));
    }

    public function unverifiedlist()
    {
        $bookings = Booking::where('status', '=', 'Unverified')->get();
        return view('admin.bookings.unverifiedlist',compact('bookings'));
    }

}
