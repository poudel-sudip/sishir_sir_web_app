<?php

namespace App\Http\Controllers\admin\Report;

use App\Exports\BatchBookingsExport;
use App\Exports\BatchPendingBookingsExport;
use App\Exports\BatchVerifiedBookingsExport;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Reports\ReportBooking;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BatchReportcontroller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $batches=Batch::all();
        return view('admin.reports.batch.index',compact('batches'));
    }

    public function batchReport(Batch $batch)
    {
        $reports=ReportBooking::all()
            ->where('batch_id','=',$batch->id)
            ->sortBy('status');
        return view('admin.reports.batch.batchBookings',compact('reports','batch'));
    }

    public function batchPendingReport(Batch $batch)
    {
        $reports=(ReportBooking::all()
            ->where('batch_id','=',$batch->id))
            ->whereIn('status',['Unverified','Processing'])
            ->sortBy('updated_at');
        return view('admin.reports.batch.batchPendingBookings',compact('reports','batch'));
    }

    public function batchVerifiedReport(Batch $batch)
    {
        $reports=ReportBooking::all()
            ->where('batch_id','=',$batch->id)
            ->where('status','=','Verified')
            ->sortBy('updated_at');
        return view('admin.reports.batch.batchVerifiedBookings',compact('reports','batch'));
    }



    public function exportBatchReport(Batch $batch): BinaryFileResponse
    {
        return Excel::download(new BatchBookingsExport($batch), 'BatchBookings.xlsx');
    }

    public function exportBatchPendingReport(Batch $batch): BinaryFileResponse
    {
        return Excel::download(new BatchPendingBookingsExport($batch), 'PendingBatchBookings.xlsx');
    }

    public function exportBatchVerifiedReport(Batch $batch): BinaryFileResponse
    {
        return Excel::download(new BatchVerifiedBookingsExport($batch), 'VerifiedBatchBookings.xlsx');
    }
}
