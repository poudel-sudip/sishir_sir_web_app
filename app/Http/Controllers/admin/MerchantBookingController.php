<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MerchantBooking;

class MerchantBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = MerchantBooking::all();
        // dd($bookings);
        return view('admin.reports.booking.merchantbooking',compact('bookings'));
    }
}
