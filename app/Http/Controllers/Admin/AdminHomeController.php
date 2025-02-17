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
use App\Models\ExamHall\ExamHallBookings;
use App\Models\Vendors\Vendor;
use App\Models\VideoCourse\VideoCourse;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\EbookBooking;

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
            'exam_booking' => (object)[
                'count' => ExamHallBookings::all()->count(),
                'verified' => ExamHallBookings::where('status','=','Verified')->count(),
                'unverified' => ExamHallBookings::where('status','=','Unverified')->count(),
                'processing' => ExamHallBookings::where('status','=','Processing')->count(),
                'link' => '/admin/exam-hall/bookings',
            ],
            'pdf_booking' => (object)[
                'count' => EbookBooking::all()->count(),
                'verified' => EbookBooking::where('status','=','Verified')->count(),
                'unverified' => EbookBooking::where('status','=','Unverified')->count(),
                'processing' => EbookBooking::where('status','=','Processing')->count(),
                'link' => '/admin/pdf-bank-bookings',
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

