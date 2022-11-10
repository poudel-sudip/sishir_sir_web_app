<?php

namespace App\Exports;

use App\Models\Reports\ReportBooking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

class BookingsExport implements FromView,ShouldAutoSize,WithEvents
{

    public function view(): View
    {
        $reports=ReportBooking::all()->sortBy('created_at');
        return view('admin.excelReportsExports.booking.bookings',[
            'reports'=>$reports
        ]);
    }

    public function registerEvents(): array
    {
        return [];
    }
}
