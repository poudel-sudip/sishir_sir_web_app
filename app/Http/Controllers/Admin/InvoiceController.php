<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\PaymentInvoice;
use App\Helpers\CustomPdfHelper;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Admin');
    }

    public function show($invoice)
    {
        $invoice = PaymentInvoice::with('user:id,name,contact')->findOrFail($invoice);
        $invoice->expiry_date = Carbon::parse($invoice->expiry_date)->format('Y-m-d');
        // dd($invoice->toArray());
        $html = view('exports.pdf.payment_invoice', compact('invoice'))->render();
        $title = 'Invoice #'.ucwords($invoice->type).'-'.$invoice->id;

        return CustomPdfHelper::createPdf($title,$html,$footer=false,$download=false);  
    }

}
