<?php

namespace App\Exports;

use App\Models\Reports\ReportTutorBatches;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TutorsBatchesExport implements FromView,ShouldAutoSize,WithEvents
{
    public $tutor;
    public function __construct($tutor)
    {
        $this->tutor=$tutor;
    }

    public function view(): View
    {
        $tutor=$this->tutor;
        $reports=ReportTutorBatches::all()
            ->where('tutor','=',$tutor->id)
            ->sortBy('created_at');

        return view('admin.excelReportsExports.tutor.tutorBatches',[
            'reports'=>$reports,
            'tutor'=>$tutor,
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
