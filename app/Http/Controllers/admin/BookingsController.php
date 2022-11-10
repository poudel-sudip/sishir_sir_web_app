<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Course;
use App\Models\User;
use App\Models\Batch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class BookingsController extends Controller
{
    //
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
        Gate::authorize('permission','booking-crud');
        $courses=DB::table('courses')->where('status','=','Active')->orWhere('status','=','Running')->get();
        return view('admin.bookings.create',compact('courses'));
    }

    public function store()
    {
        // dd(request()->all());
        Gate::authorize('permission','booking-crud');
        $data=request()->validate([
            'course_name'=>'integer | required | min:1',
            'batch_name'=>'integer | required | min:1',
            'userid'=>'numeric | required | min:1',
            'username'=>'',
            'description'=>'string | required',
            'status'=>'string | required',
            'verificationMode'=>'string',
            'accountNo'=>'',
            'paymentAmount'=>'numeric|nullable',
            'discount'=>'numeric|nullable',
            'verificationDocument'=>'nullable | image',
            'features'=>'required|string|min:3',
        ]);
        $batch=Batch::find($data['batch_name']);

        $search=Booking::where([
            ['course_id','=',$data['course_name']],
            ['batch_id','=',$data['batch_name']],
            ['user_id','=',$data['userid']],
            ])->count();
        if($search){
            return back()->withInput()->withErrors(['batch_name'=>'This Course Batch is Already Booked by the Given User. Please Check Again !!!']);
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
            'user_id'=>User::find(request('userid'))->id ?? Auth::user()->id,
            'user_name'=>User::find(request('userid'))->name ?? request('username') ?? Auth::user()->name,
            'description'=>$data['description'] ?? '',
            'status'=>$data['status'],
            'updatedBy'=>Auth::user()->name,
            'verificationMode'=>$data['verificationMode'] ?? '',
            'accountNo'=>$data['accountNo'] ?? '',
            'paymentAmount'=>$data['paymentAmount'] ?? 0,
            'discount'=>$data['discount'] ?? 0,
            'dueAmount'=>$due,
            'verificationDocument'=>$imagePath,
            'features'=>$data['features']
        ]);
        return redirect('/admin/bookings');
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show',compact('booking'));
    }

    public function edit(Booking $booking)
    {
        Gate::authorize('permission','booking-crud');
        $courses=Course::where('status','Active')->get();
        return view('admin.bookings.edit',compact('booking','courses'));
    }

    public function update(Booking $booking)
    {
        Gate::authorize('permission','booking-crud');
        $data=request()->validate([
            'status'=>'string | required',
            'uploadDocument'=>'image|nullable',
            'oldDocument'=>'',
            'paymentAmount'=>'required|numeric',
            'discount'=>'required|numeric',
            'suspended'=>'required|boolean',
            'coursefee'=>'required|numeric|min:1',
            'verificationMode'=>'min:1',
            'accountNo'=>'',
            'remarks'=>'string|nullable',
            'course_name'=>'numeric|required|min:1',
            'batch_name'=>'numeric|required|min:1',
            'features'=>'string|min:3',
            "trans_code" => "string|nullable",
        ]);
        // dd(request()->all(),$data);

        $due=(integer)($data['coursefee']-$data['paymentAmount']-$data['discount']);
        $img=$data['oldDocument'];
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
            'updatedBy'=>Auth::user()->name,
            'suspended'=>$data['suspended'],
            'accountNo'=>$data['accountNo'] ?? '',
            'verificationMode'=>$data['verificationMode'],
            'features'=>$data['features'],
            'remarks'=>$data['remarks'],
            'course_id'=>$data['course_name'],
            'batch_id'=>$data['batch_name'],
            'trans_code' => $data['trans_code'],
        ]);

        return redirect('/admin/bookings');
    }

    public function destroy(Booking $booking)
    {
        Gate::authorize('permission','booking-crud');
        $booking->vendorBooking()->delete();
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
