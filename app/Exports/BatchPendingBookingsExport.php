<?php

namespace App\Exports;

use App\Models\Reports\ReportBooking;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class BatchPendingBookingsExport implements FromView,ShouldAutoSize,WithEvents
{
    public $batch;
    public function __construct($batch){
        $this->batch=$batch;
    }

    public function view(): View
    {
        $batch=$this->batch;
        $reports=(ReportBooking::all()
            ->where('batch_id','=',$batch->id))
            ->whereIn('status',['Unverified','Processing'])
            ->sortBy('updated_at');
        return view('admin.excelReportsExports.batch.batchPendingBookings',[
            'reports'=>$reports,
            'batch'=>$batch,
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:I1'; // All headers
                $event->sheet->getDelegate()->mergeCells($cellRange);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(20);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical('center');


                $cellRange = 'A2:I2'; // All headers
                $event->sheet->getDelegate()->mergeCells($cellRange);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(16);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical('center');


                $cellRange = 'A3:I3'; // All headers
                $event->sheet->getDelegate()->mergeCells($cellRange);
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(11);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical('center');


                $cellRange = 'A4:I4'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle($cellRange)->getAlignment()->setVertical('center');


            },
        ];
    }
}
