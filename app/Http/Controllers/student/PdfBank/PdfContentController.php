<?php

namespace App\Http\Controllers\Student\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\Ebook as PDFBank;
use App\Models\Ebook\EbookBooking as Booking;
use App\Models\Ebook\EbookChapter as PDFContent;

class PdfContentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Booking $booking)
    {
        $data = [];
        $pdfbank = $booking->book;
        $contents = $pdfbank->chapters()->where('status','=','Active')->get();

        $data['booking'] = $booking;
        $data['pdfbank'] = $pdfbank;
        $data['contents'] = $contents;
        
        return view('student.pdf_bank.content.index',$data);
    }

    public function show(Booking $booking, PDFContent $content)
    {
        $pdfbank = $booking->book;
        // $contents = $pdfbank->chapters()->where('status','=','Active')->get();

        $data['booking'] = $booking;
        $data['pdfbank'] = $pdfbank;
        // $data['contents'] = $contents;
        $data['content'] = $content;
        
        return view('student.pdf_bank.content.show',$data);
    }

}
