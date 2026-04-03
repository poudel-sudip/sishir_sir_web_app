<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Number;
use App\Models\PaymentInvoice;
use App\Helpers\CustomPdfHelper;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $invoices = PaymentInvoice::where('user_id', auth()->user()->id)->orderByDesc('id')->get();
        return view('student.invoices.index', compact('invoices'));
    }

    public function show($invoice)
    {
        $invoice = PaymentInvoice::with('user:id,name,contact')->findOrFail($invoice);
        if($invoice->user_id != auth()->user()->id){
            abort(403);
        }
        $invoice->expiry_date = Carbon::parse($invoice->expiry_date)->format('Y-m-d');
        $invoice->payment_in_words = Number::spell(intval($invoice->payment_amount)).' rupees only';
        $invoice->logo = url('/images/logo.png');
        // $invoice->logo = '/images/logo.png';
        // dd($invoice->toArray());
        $html = view('exports.pdf.payment_invoice', compact('invoice'))->render();
        $title = 'Invoice #'.ucwords($invoice->type).'-'.$invoice->id;

        return CustomPdfHelper::createPdf($title,$html,$footer=false,$download=false);  
    }
}
