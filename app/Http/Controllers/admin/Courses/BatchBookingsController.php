<?php

namespace App\Http\Controllers\Admin\Courses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Batch;
use App\Models\Booking;
use App\Models\Course;

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
        $status = 'Verified';
        return view('admin.batches.bookings.statusbooking',compact('data','batch','status'));
    }
    public function unverifiedstatus(Batch $batch)
    {
        $data=$batch->bookings()->where('status','=','Unverified')->get();
        $status = 'Unverified';
        return view('admin.batches.bookings.statusbooking',compact('data','batch','status'));
    }

    public function edit(Batch $batch, Booking $booking)
    {
        return view('admin.batches.bookings.editbooking',compact('booking','batch'));
    }

    public function update(Batch $batch, Booking $booking)
    {        
        $data=request()->validate([
            'status'=>'string | required',
            'uploadDocument'=>'image|nullable',
            'oldDocument'=>'string|nullable',
            'paymentAmount'=>'required|numeric',
            'discount'=>'required|numeric',
            'verificationMode'=>'min:1',
            'remarks'=>'string|nullable',
        ]);
        $due = (integer)(($batch->fee - $batch->discount) - $data['paymentAmount']-$data['discount']);
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
            'updatedBy'=>auth()->user()->name,
            'remarks'=>$data['remarks'],
        ]);

        return redirect('/admin/batches/'.$batch->id.'/bookings');
    }

    public function destroy(Batch $batch, Booking $booking)
    {
        $booking->delete();
        return redirect('/admin/batches/'.$batch->id.'/bookings');
    }
}
