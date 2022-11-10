<?php

namespace App\Http\Controllers\admin\Report;

use App\Exports\BookingsExport;
use App\Exports\DailyBookingsExport;
use App\Exports\MonthlyBookingsExport;
use App\Exports\TutorsBatchesExport;
use App\Exports\YearlyBookingsExport;
use App\Http\Controllers\Controller;
use App\Models\Reports\ReportBooking;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookingReportcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.reports.booking.index',[]);
    }

    public function bookingReport()
    {
        $reports=ReportBooking::all()->sortBy('created_at');
        return view('admin.reports.booking.bookings',compact('reports'));
    }

    public function dailyBookingReport()
    {
        $data=request()->validate([
            'year_for_daily_booking'=>'required | numeric | digits:4',
            'month_for_daily_booking'=>'required | numeric | lt:13',
            'day_for_daily_booking'=>'required | numeric | lt:33',
        ]);
        $date=$data['year_for_daily_booking'].'-'.$data['month_for_daily_booking'].'-'.$data['day_for_daily_booking'];
        $reports=ReportBooking::whereDate('created_at','=', date('Y-m-d',strtotime($date)))
            ->orderBy('status')->get();
        return view('admin.reports.booking.dailyBookings',compact('reports','date'));
    }

    public function monthlyBookingReport()
    {

        $data=request()->validate([
            'year_for_monthly_booking'=>'required | numeric | digits:4',
            'month_for_monthly_booking'=>'required | numeric | lt:13',
        ]);
        $date=$data['year_for_monthly_booking'].'-'.$data['month_for_monthly_booking'].'-1';
        $reports=ReportBooking::whereYear('created_at', '=', date('Y',strtotime($date)))
            ->whereMonth('created_at', '=', date('m',strtotime($date)))
            ->orderBy('created_at')->get();
        return view('admin.reports.booking.monthlyBookings',compact('reports','date'));
    }

    public function yearlyBookingReport()
    {
        $data=request()->validate([
            'year_for_yearly_booking'=>'required | numeric | digits:4',
        ]);
        $date=$data['year_for_yearly_booking'].'-1-1';
        $reports=ReportBooking::whereYear('created_at', '=', date('Y',strtotime($date)))
            ->orderBy('created_at')->get();
        return view('admin.reports.booking.yearlyBookings',compact('reports','date'));
    }

    public function exportBookings(): BinaryFileResponse
    {
        return Excel::download(new BookingsExport, 'All Bookings.xlsx');
    }

    public function dailyBookingsExport($date): BinaryFileResponse
    {
        return Excel::download(new DailyBookingsExport($date), 'Daily Bookings.xlsx');
    }

    public function monthlyBookingsExport($date): BinaryFileResponse
    {
        return Excel::download(new MonthlyBookingsExport($date), 'Monthly Bookings.xlsx');
    }

    public function YearlyBookingsExport($date): BinaryFileResponse
    {
        return Excel::download(new YearlyBookingsExport($date), 'Yearly Bookings.xlsx');
    }
}
