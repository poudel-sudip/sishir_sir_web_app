<?php

namespace App\Http\Controllers\Admin;

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
        return view('admin.merchantbooking.index',compact('bookings'));
    }
}
