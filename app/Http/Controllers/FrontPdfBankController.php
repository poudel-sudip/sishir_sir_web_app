<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ebook\Ebook as PDFBank;
use App\Models\Ebook\EbookCategory as PDFBankCategory;
use App\Helpers\Helper;

class FrontPdfBankController extends Controller
{
    public function index()
    {
        $data = [];
        $data['pdf_category'] = null;
        $data['pdf_banks'] = PDFBank::where('status','=','Active')
        ->orderByDesc('id')
        ->withCount(['chapters as pdf_count' => function($ch){
            $ch->where('status','=','Active');
        }])
        ->paginate(12);

        $data['pdf_bank_categories'] = PDFBankCategory::where('status','=','Active')->orderBy('order')->get();

        return view('front.pdf_bank.index',$data);
    }

    public function categoryPdfBanks($slug)
    {
        $category = PDFBankCategory::where('slug','=',$slug)->where('status','=','Active')->first();
        if(!$category)
        {
            abort(404,'PDF Bank Category Not Found');
        }

        $data = [];
        $data['pdf_category'] = $category;
        $data['pdf_banks'] = $category->ebooks()->where('status','=','Active')
        ->orderByDesc('id')
        ->withCount(['chapters as pdf_count' => function($ch){
            $ch->where('status','=','Active');
        }])
        ->paginate(12);

        $data['pdf_bank_categories'] = PDFBankCategory::where('status','=','Active')->orderByDesc('id')->get();

        return view('front.pdf_bank.index',$data);
    }

    public function singlePdfBankDetails($slug)
    {
        $pdf_bank = PDFBank::where('slug','=',$slug)
        ->where('status','=','Active')
        ->withCount(['chapters as pdf_count' => function($ch){
            $ch->where('status','=','Active');
        }])
        ->withCount(['chapters as video_count' => function($ch){
            $ch->where('status','=','Active')
            ->where('video_file','!=','');
        }])
        ->first();
        if(!$pdf_bank)
        {
            abort(404,'PDF Bank Not Found');
        }

        $pdf_bank->pdf_sets = $pdf_bank->chapters()->where('status','=','Active')->get()->sortByDesc('id')->values();
        
        // dd($pdf_bank);
        $data['pdf_bank'] = $pdf_bank;

        $pgurl = strtok($_SERVER['REQUEST_URI'], '?');
        $pgtype = 'article';
        $data['counterData'] = Helper::pageCounterCounts($pdf_bank->title,$pgurl,$pgtype);

        return view('front.pdf_bank.pdf_bank_single',$data);
    }
}
