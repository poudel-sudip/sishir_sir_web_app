<?php

namespace App\Exports;

use App\Models\Reports\ReportBooking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class MonthlyBookingsExport implements FromView,ShouldAutoSize,WithEvents
{
    public $date;
    public function __construct($date)
    {
        $this->date=$date;
    }

    public function view(): View
    {
        $date=$this->date;
        $reports=ReportBooking::whereYear('created_at', '=', date('Y',strtotime($date)))
            ->whereMonth('created_at', '=', date('m',strtotime($date)))
            ->orderBy('created_at')->get();
        return view('admin.excelReportsExports.booking.monthly',[
            'reports'=>$reports,
            'date'=>$date
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(18);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical('center');
            },
        ];
    }
}
