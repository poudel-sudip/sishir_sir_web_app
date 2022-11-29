<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Booking;
use App\Models\Accounts\AccountIncome;
use App\Models\Accounts\AccountExpense;
use App\Models\StudentEnquiry;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\Vendors\Vendor;
use App\Models\VideoCourse\VideoCourse;
use App\Models\Ebook\Ebook;

class AdminHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = (object)[
            'user' => (object)[
                'count' => User::all()->count(),
                'link' => '/admin/users',
            ],
            'booking' => (object)[
                'count' => Booking::all()->count(),
                'verified' => Booking::where('status','=','Verified')->count(),
                'unverified' => Booking::where('status','=','Unverified')->count(),
                'processing' => Booking::where('status','=','Processing')->count(),
                'link' => '/admin/bookings/all',
            ],
            'enquiry' => (object)[
                'count' => StudentEnquiry::all()->count(),
                'link' => '/leads/enquiries',
            ],
        ];
        
        $batches = Batch::all()->where('isPinned','=','Yes')->sortByDesc('status');
        $exams = ExamHallCategories::all()->where('isPinned','=','Yes');
        $ebooks = Ebook::where('isPinned','=','Yes')->get();
        // dd($data,$exams,$vendors);
        
        return view('admin.home',compact('data','batches','exams','ebooks'));
    }


}

