<?php

namespace App\Http\Controllers\admin\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendors\Vendor;
use App\Models\Vendors\VendorBooking;
use App\Models\Vendors\VendorVideoBooking;
use App\Models\Vendors\VendorEbookBooking;
use App\Models\Vendors\VendorExamBooking;

class BookingController extends Controller
{
    
    public function courseBookings(Vendor $vendor)
    {
        // dd($vendor,$vendor->mybookings);
        $bookings = $vendor->mybookings;
        return view('admin.vendor.bookings.course',compact('vendor','bookings'));
    }

    public function examBookings(Vendor $vendor)
    {
        // dd($vendor,$vendor->examBookings);
        $bookings = $vendor->examBookings;
        return view('admin.vendor.bookings.exam',compact('vendor','bookings'));
    }

    public function videoBookings(Vendor $vendor)
    {
        // dd($vendor,$vendor->videoBookings);
        $bookings = $vendor->videoBookings;
        return view('admin.vendor.bookings.video',compact('vendor','bookings'));
    }

    public function ebookBookings(Vendor $vendor)
    {
        // dd($vendor,$vendor->videoBookings);
        $bookings = $vendor->ebookBookings;
        return view('admin.vendor.bookings.ebook',compact('vendor','bookings'));
    }

    public function allVendorsCourseBookings()
    {
        $bookings = VendorBooking::all();
        return view('admin.vendor.vendorwisebooking.course',compact('bookings'));

    }

    public function allVendorsVideoBookings()
    {
        $bookings = VendorVideoBooking::all();
        return view('admin.vendor.vendorwisebooking.video',compact('bookings'));

    }

    public function allVendorsEbookBookings()
    {
        $bookings = VendorEbookBooking::all();
        return view('admin.vendor.vendorwisebooking.ebook',compact('bookings'));

    }

    public function allVendorsExamBookings()
    {
        $bookings = VendorExamBooking::all();
        return view('admin.vendor.vendorwisebooking.exam',compact('bookings'));

    }
}
