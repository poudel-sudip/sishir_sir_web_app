<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManualBooking;

class ManualBookingController extends Controller
{
    
    protected function index()
    {
        $vendor = auth()->user()->vendor;
        if(ucwords($vendor->manual_booking_access) != 'Yes' )
        {
            return redirect('/vendor/home');
        }
        $bookings = [];
        $coverageArea = '';
        if($vendor->coverage_type=='district')
        {
            $coverageArea = $vendor->district_city;
            $cities =array_map("trim",explode(",",$coverageArea));
            $bookings = $coverageArea!='' ? ManualBooking::whereIn('district',$cities)->get() : [];
        }
        elseif($vendor->coverage_type=='provience')
        {
            $coverageArea = $vendor->provience;
            $proviences =array_map("trim",explode(",",$coverageArea));
            $bookings = $coverageArea!='' ? ManualBooking::whereIn('provience',$proviences)->get() : [];
        }
        else{}

        return view('vendors.manualBooking.index',compact('bookings','vendor','coverageArea'));
    }

    protected function view($booking)
    {
        return ManualBooking::find($booking);
    }

    public function edit(ManualBooking $booking)
    {
        return view('vendors.manualBooking.update',compact('booking'));
    }

    public function update(ManualBooking $booking)
    {
        $data=request()->validate([
            'status'=>'string | required',
        ]);
        $booking->update([
            'status'=>$data['status'],
        ]);

        return redirect('vendor/manual-bookings');
    }

    public function destroy(ManualBooking $booking)
    {
        $booking->delete();
        return redirect('vendor/manual-bookings');
    }
}
