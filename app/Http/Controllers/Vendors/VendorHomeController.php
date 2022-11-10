<?php

namespace App\Http\Controllers\Vendors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class VendorHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $vendor = auth()->user()->vendor;
        $data = (object)[
            "user" => (object)[
                "count"=>$vendor->myusers->count(),
                "link"=>"/vendor/users",
            ],
            "allusers" => (object)[
                "count"=>User::where('role','=','Student')->count(),
                "link"=>"/vendor/all-users",
            ],
            "course"=>(object)[
                "count"=>$vendor->mybookings->count(),
                "link"=>"/vendor/bookings",
            ],
            "exam"=>(object)[
                "count"=>$vendor->examBookings->count(),
                "link"=>"/vendor/exam-hall/bookings",
            ],
            "video"=>(object)[
                "count"=>$vendor->videoBookings->count(),
                "link"=>"/vendor/video-booking",
            ],
            "ebook"=>(object)[
                "count"=>$vendor->ebookBookings->count(),
                "link"=>"/vendor/ebook-booking",
            ],
        ];
        return view('vendors.home',compact('data'));
    }
}
