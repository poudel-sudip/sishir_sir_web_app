<?php

namespace App\Exports;

use App\Models\Reports\ReportTutor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TutorsExport implements FromView,ShouldAutoSize,WithEvents
{

    public function view(): View
    {
        $reports=ReportTutor::all()->sortBy('created_at');
        return view('admin.excelReportsExports.tutor.tutors',[
            'reports'=>$reports
        ]);
    }

    public function registerEvents(): array
    {
        return [];
    }
}
