<?php

namespace App\Http\Controllers\admin\Report;

use App\Exports\TutorsBatchesExport;
use App\Exports\TutorsExport;
use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Models\Reports\ReportTutor;
use App\Models\Reports\ReportTutorBatches;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class TutorReportcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index()
    {
        $tutors=Tutor::all();
        return view('admin.reports.tutor.index',compact('tutors'));
    }

    public function tutorReport()
    {
        $reports=ReportTutor::all()->sortBy('created_at');
        return view('admin.reports.tutor.tutors',compact('reports'));
    }

    public function tutorBatchReport(Tutor $tutor)
    {

        $reports=ReportTutorBatches::all()
            ->where('tutor','=',$tutor->id)
            ->sortBy('created_at');
        return view('admin.reports.tutor.tutorBatches',compact('reports','tutor'));
    }

    public function exportTutors(): BinaryFileResponse
    {
        return Excel::download(new TutorsExport, 'All Tutors.xlsx');
    }

    public function exportTutorBatches(Tutor $tutor): BinaryFileResponse
    {
        return Excel::download(new TutorsBatchesExport($tutor), 'Tutor Batches.xlsx');
    }
}
