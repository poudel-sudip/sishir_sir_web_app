<?php

namespace App\Http\Controllers\admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\Accounts\AccountIncome;
use App\Models\Accounts\AccountExpense;
use App\Models\Vendors\Vendor;
use App\Models\VideoCourse\VideoBooking;
use App\Models\Ebook\EbookBooking;

class ReportController extends Controller
{
    public function index()
    {
        $collection=(object)[
            'cash'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Cash')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Cash')->where('deleted','=',false)->sum('amount'),
            ],
            'connectips'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Connect IPS')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Connect IPS')->where('deleted','=',false)->sum('amount'),
            ],
            'imepay'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','IME Pay')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','IME Pay')->where('deleted','=',false)->sum('amount'),
            ],
            'esewa'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Esewa')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Esewa')->where('deleted','=',false)->sum('amount'),
            ],
            'khalti'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Khalti')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Khalti')->where('deleted','=',false)->sum('amount'),
            ],
            'globalbank'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Global Bank')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Global Bank')->where('deleted','=',false)->sum('amount'),
            ],
            'megabank'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Mega Bank')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Mega Bank')->where('deleted','=',false)->sum('amount'),
            ],
        ];

        return view('admin.accounts.reports.index',compact('collection'));
    }

    public function collections()
    {
        $AccountCollection=(object)[
            'cash'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Cash')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Cash')->where('deleted','=',false)->sum('amount'),
            ],
            'connectips'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Connect IPS')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Connect IPS')->where('deleted','=',false)->sum('amount'),
            ],
            'imepay'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','IME Pay')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','IME Pay')->where('deleted','=',false)->sum('amount'),
            ],
            'esewa'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Esewa')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Esewa')->where('deleted','=',false)->sum('amount'),
            ],
            'khalti'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Khalti')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Khalti')->where('deleted','=',false)->sum('amount'),
            ],
            'globalbank'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Global Bank')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Global Bank')->where('deleted','=',false)->sum('amount'),
            ],
            'megabank'=>(object)[
                'income'=>AccountIncome::where('toAccount','=','Mega Bank')->where('deleted','=',false)->sum('amount'),
                'expense'=>AccountExpense::where('fromAccount','=','Mega Bank')->where('deleted','=',false)->sum('amount'),
            ],
        ];

        $courseCollection=(object)[
            'cash'=>Booking::all()->where('status','=','Verified')->where('verificationMode','=','Self')->sum('paymentAmount'),
            'connectips'=>Booking::all()->where('status','=','Verified')->where('verificationMode','=','Connect IPS')->sum('paymentAmount'),
            'esewa'=>Booking::all()->where('status','=','Verified')->where('verificationMode','=','Esewa')->sum('paymentAmount'),
            'imepay'=>Booking::all()->where('status','=','Verified')->where('verificationMode','=','IME Pay')->sum('paymentAmount'),
            'khalti'=>Booking::all()->where('status','=','Verified')->where('verificationMode','=','Khalti')->sum('paymentAmount'),
            'bank'=>Booking::all()->where('status','=','Verified')->where('verificationMode','=','Bank')->sum('paymentAmount'),
            'due'=>Booking::all()->where('status', '=', 'Verified')->where('dueAmount','>','0')->sum('dueAmount'),
        ];

        $examCollection=(object)[
            'cash'=>ExamHallBookings::all()->where('status','=','Verified')->where('verificationMode','=','Self')->sum('paidAmount'),
            'connectips'=>ExamHallBookings::all()->where('status','=','Verified')->where('verificationMode','=','Connect IPS')->sum('paidAmount'),
            'esewa'=>ExamHallBookings::all()->where('status','=','Verified')->where('verificationMode','=','Esewa')->sum('paidAmount'),
            'imepay'=>ExamHallBookings::all()->where('status','=','Verified')->where('verificationMode','=','IME Pay')->sum('paidAmount'),
            'khalti'=>ExamHallBookings::all()->where('status','=','Verified')->where('verificationMode','=','Khalti')->sum('paidAmount'),
            'bank'=>ExamHallBookings::all()->where('status','=','Verified')->where('verificationMode','=','Bank')->sum('paidAmount'),
            'due'=>ExamHallBookings::all()->where('status', '=', 'Verified')->where('dueAmount','>','0')->sum('dueAmount'),
        ];

        $videoCollection=(object)[
            'cash'=>VideoBooking::all()->where('status','=','Verified')->where('verificationMode','=','Self')->sum('paymentAmount'),
            'connectips'=>VideoBooking::all()->where('status','=','Verified')->where('verificationMode','=','Connect IPS')->sum('paymentAmount'),
            'esewa'=>VideoBooking::all()->where('status','=','Verified')->where('verificationMode','=','Esewa')->sum('paymentAmount'),
            'imepay'=>VideoBooking::all()->where('status','=','Verified')->where('verificationMode','=','IME Pay')->sum('paymentAmount'),
            'khalti'=>VideoBooking::all()->where('status','=','Verified')->where('verificationMode','=','Khalti')->sum('paymentAmount'),
            'bank'=>VideoBooking::all()->where('status','=','Verified')->where('verificationMode','=','Bank')->sum('paymentAmount'),
            'due'=>VideoBooking::all()->where('status', '=', 'Verified')->where('dueAmount','>','0')->sum('dueAmount'),
        ];

        $ebookCollection=(object)[
            'cash'=>EbookBooking::all()->where('status','=','Verified')->where('verificationMode','=','Self')->sum('paymentAmount'),
            'connectips'=>EbookBooking::all()->where('status','=','Verified')->where('verificationMode','=','Connect IPS')->sum('paymentAmount'),
            'esewa'=>EbookBooking::all()->where('status','=','Verified')->where('verificationMode','=','Esewa')->sum('paymentAmount'),
            'imepay'=>EbookBooking::all()->where('status','=','Verified')->where('verificationMode','=','IME Pay')->sum('paymentAmount'),
            'khalti'=>EbookBooking::all()->where('status','=','Verified')->where('verificationMode','=','Khalti')->sum('paymentAmount'),
            'bank'=>EbookBooking::all()->where('status','=','Verified')->where('verificationMode','=','Bank')->sum('paymentAmount'),
            'due'=>EbookBooking::all()->where('status', '=', 'Verified')->where('dueAmount','>','0')->sum('dueAmount'),
        ];

        $vendorCollection= Vendor::all()->map(function($vendor){
            $coursebookings = $vendor->mybookings->map(function($booking){
                return $booking->booking;
            });

            $exambookings = $vendor->examBookings->map(function($booking){
                return $booking->booking;
            });

            $videobookings = $vendor->videoBookings->map(function($booking){
                return $booking->booking;
            });

            $ebookbookings = $vendor->ebookBookings->map(function($booking){
                return $booking->booking;
            });

            $cver = $coursebookings->where('status','=','Verified')->sum('paymentAmount');
            $cunver = $coursebookings->where('status','!=','Verified')->sum('paymentAmount');

            $ever = $exambookings->where('status','=','Verified')->sum('paidAmount');
            $eunver = $exambookings->where('status','!=','Verified')->sum('paidAmount');

            $vver = $videobookings->where('status','=','Verified')->sum('paymentAmount');
            $vunver = $videobookings->where('status','!=','Verified')->sum('paymentAmount');

            $ebver = $ebookbookings->where('status','=','Verified')->sum('paymentAmount');
            $ebunver = $ebookbookings->where('status','!=','Verified')->sum('paymentAmount');

            return (object)[
                'name' => $vendor->name,
                'course'=>(object)[
                    'verified' => $cver,
                    'unverified' => $cunver,
                ],
                'exam' =>(object)[
                    'verified' => $ever,
                    'unverified' => $eunver,
                ],
                'video' =>(object)[
                    'verified' => $vver,
                    'unverified' => $vunver,
                ],
                'ebook' =>(object)[
                    'verified' => $ebver,
                    'unverified' => $ebunver,
                ],
            ];
        });

        // dd($AccountCollection,$courseCollection,$vendorCollection);
        return view('admin.accounts.reports.collections',compact('AccountCollection','courseCollection','examCollection','videoCollection','ebookCollection','vendorCollection'));

    }
}
