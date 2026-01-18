<?php

namespace App\Http\Controllers\Student\PdfBank;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ebook\Ebook as PDFBank;
use App\Models\Ebook\EbookBooking as Booking;
use App\Models\Ebook\EbookChapter as PDFContent;
use Storage;
use Number;

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
        if(!$pdfbank)
        {
            abort(403,'This Booking PDF Bank Has Been Deleted.');
        }
        
        $data['booking'] = $booking;
        $data['pdfbank'] = $pdfbank;
        
        if($pdfbank->type == 'single')
        {
            $pdf_size = "0 KB";
            try {
                $pdf_size = Storage::disk('public')->size($pdfbank->pdf_file);
                $pdf_size = Number::fileSize($pdf_size);
            } catch (\Throwable $th) {
                //throw $th;
            }

            $data['content'] = (object)[
                'id' => $pdfbank->id,
                'title' => $pdfbank->title,
                'download' => $pdfbank->download,
                'pdf_file' => $pdfbank->pdf_file,
                'video_file' => $pdfbank->video_file,
                'pdf_size' => $pdf_size,
            ];
            return view('student.pdf_bank.content.show',$data);
        }

        $contents = $pdfbank->chapters()->where('status','=','Active')->get();

        $data['contents'] = $contents;
        
        return view('student.pdf_bank.content.index',$data);
    }

    public function show(Booking $booking, PDFContent $content)
    {
        $pdfbank = $booking->book;
        // $contents = $pdfbank->chapters()->where('status','=','Active')->get();

        $pdf_size = "0 KB";
        try {
            $pdf_size = Storage::disk('public')->size($content->pdf_file);
            $pdf_size = Number::fileSize($pdf_size);
        } catch (\Throwable $th) {
            //throw $th;
        }
        $content->pdf_size = $pdf_size;

        $data['booking'] = $booking;
        $data['pdfbank'] = $pdfbank;
        // $data['contents'] = $contents;
        $data['content'] = $content;
        
        return view('student.pdf_bank.content.show',$data);
    }

}
