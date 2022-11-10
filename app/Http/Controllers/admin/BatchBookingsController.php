<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Booking;
use App\Models\Course;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class BatchBookingsController extends Controller
{
    public function index(Batch $batch)
    {
        $bookings=$batch->bookings()->get();
        return view('admin.batches.bookings.bookings',compact('bookings','batch'));
    }

    public function show(Batch $batch, Booking $booking)
    {
        return view('admin.batches.bookings.showbooking',compact('booking','batch'));
    }
    public function verifiedstatus(Batch $batch)
    {
        $data=$batch->bookings()->where('status','=','Verified')->get();
        return view('admin.batches.bookings.statusbooking',compact('data','batch'));
    }
    public function unverifiedstatus(Batch $batch)
    {
        $data=$batch->bookings()->where('status','=','Unverified')->get();
        return view('admin.batches.bookings.statusbooking',compact('data','batch'));
    }

    public function edit(Batch $batch, Booking $booking)
    {
        Gate::authorize('permission','booking-crud');
        return view('admin.batches.bookings.editbooking',compact('booking','batch'));
    }

    public function update(Batch $batch, Booking $booking)
    {        
        // dd(request()->all(),$batch->fee,$batch->discount);
        Gate::authorize('permission','booking-crud');
        $data=request()->validate([
            'status'=>'string | required',
            'uploadDocument'=>'image|nullable',
            'oldDocument'=>'',
            'paymentAmount'=>'required|numeric',
            'discount'=>'required|numeric',
            'verificationMode'=>'min:1',
            'accountNo'=>'',
            'remarks'=>'string|nullable',
            'features'=>'string|min:3',
        ]);
        $due=(integer)(($batch->fee - $batch->discount) - $data['paymentAmount']-$data['discount']);
        // dd(request()->all(),$batch->fee,$batch->discount,$due);

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
            'verificationMode'=>$data['verificationMode'] ?? '',
            'features'=>$data['features'],
            'accountNo'=>$data['accountNo'] ?? '',
            'updatedBy'=>Auth::user()->name,
            'remarks'=>$data['remarks'],
        ]);

        return redirect('/admin/batches/'.$batch->id.'/bookings');
    }

    public function destroy(Batch $batch, Booking $booking)
    {
        Gate::authorize('permission','booking-crud');
        $booking->delete();
        return redirect('/admin/batches/'.$batch->id.'/bookings');
    }
}
