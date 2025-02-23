<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\ExamHall\ExamHallCategories as ExamCategory;
use App\Models\ExamHall\ExamHallBookings as ExamBooking;
use App\Models\Ebook\Ebook as PdfGroup;
use App\Models\Ebook\EbookBooking as PdfBooking;

class WalletCollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $data = [];

        $exam_bookings = ExamBooking::where('status','=','Verified')
        ->select('verificationMode', DB::raw('count(*) as count'), DB::raw('sum(paymentAmount) as amount'))
        ->groupBy('verificationMode')
        ->get('verificationMode','paymentAmount')
        ->map(function($g){
            return (object)[
                'type' => $g->verificationMode,
                'count' => $g->count,
                'amount' => $g->amount,
            ];
        });

        $pdf_bookings = PdfBooking::where('status','=','Verified')
        ->select('verificationMode', DB::raw('count(*) as count'), DB::raw('sum(paymentAmount) as amount'))
        ->groupBy('verificationMode')
        ->get('verificationMode','paymentAmount')
        ->map(function($g){
            return (object)[
                'type' => $g->verificationMode,
                'count' => $g->count,
                'amount' => $g->amount,
            ];
        });

        $combined_data = $exam_bookings->concat($pdf_bookings);
        $aggregate_data = $combined_data->groupBy('type')->map(function($items, $key) {
            return (object)[
                'type' => $key,
                'count' => $items->sum('count'),
                'amount' => $items->sum('amount'),
            ];
        })->values();

        $data['wallet_type'] = $aggregate_data;
        
        $data['booking_type'] = collect([
            (object)[
                'type' => 'Exam',
                'count' => $exam_bookings->sum('count'),
                'amount' => $exam_bookings->sum('amount'),
                'link' => '/admin/wallet-collection/booking-type/exam',
            ],
            (object)[
                'type' => 'PDF Bank',
                'count' => $pdf_bookings->sum('count'),
                'amount' => $pdf_bookings->sum('amount'),
                'link' => '/admin/wallet-collection/booking-type/pdf-bank',
            ],
        ]);

        // dd($data);
        return view('admin.collection.index',$data);
    }

    public function bookingTypeExamCollection()
    {
        $exam_bookings = ExamBooking::where('status','=','Verified')
        ->with('category:id,title')
        ->select(
            'category_id',
            'verificationMode', 
            DB::raw('count(*) as count'), 
            DB::raw('sum(paymentAmount) as amount')
        )
        ->groupBy('verificationMode','category_id')
        ->get('category_id','verificationMode','paymentAmount')
        ->map(function($g){
            return (object)[
                'exam_id' => $g->category->id ?? '',
                'exam_name' => $g->category->title ?? 'Exam Undefined',
                'mode' => $g->verificationMode,
                'count' => $g->count,
                'amount' => $g->amount,
            ];
        });
        
        $data['exam_bookings_wallet'] = $exam_bookings->groupBy('mode')
        ->map(function($g){
            return (object)[
                'mode' => $g->min('mode'),
                'count' => $g->sum('count'),
                'amount' => $g->sum('amount'),
            ];
        })->values();

        $data['exam_bookings_category'] = $exam_bookings->groupBy('exam_id')
        ->map(function($g){
            return (object)[
                'exam_id' => $g->min('exam_id'),
                'exam_name' => $g->min('exam_name'),
                'count' => $g->sum('count'),
                'amount' => $g->sum('amount'),
            ];
        })->values();

        // dd($data);
        return view('admin.collection.exam_index',$data);
    }

    public function bookingTypeExamCollectionFilter(Request $request)
    {
        $exam_categories = ExamCategory::whereHas('bookings')->get(['id','title']);
        $fetchdata = false;
        $filterkeys = null;

        $start = null;
        $end = null;
        $exam = null;
        $mode = null;
        $data_type = null;

        if(isset($request->start_date) && trim($request->start_date))
        {
            $start = Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($request->start_date)))->startOfDay();
            if(!isset($request->end_date))
            {
                $end = Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($request->start_date)))->endOfDay();
            }
            $fetchdata = true;
            $filterkeys .= '<span class="mx-1">Start: '.$start->format('Y-m-d').'</span>';
        }

        if(isset($request->end_date) && trim($request->end_date))
        {
            $end = Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($request->end_date)))->endOfDay();
            $fetchdata = true;
            $filterkeys .= '<span class="mx-1">End: '.$end->format('Y-m-d').'</span>';
        }

        if(isset($request->exam_id) && trim($request->exam_id))
        {
            $exam = ExamCategory::find($request->exam_id,['id','title']);
            $fetchdata = true;
            $filterkeys .= '<span class="mx-1">Exam: '.$exam->title.'</span>';
        }

        if(isset($request->wallet) && trim($request->wallet))
        {
            $mode = trim($request->wallet);
            $fetchdata = true;
            $filterkeys .= '<span class="mx-1">Wallet: '.$mode.'</span>';
        }

        if(isset($request->data_type) && trim($request->data_type))
        {
            $data_type = trim($request->data_type);
        }

        // dd($fetchdata,$start,$end,$exam,$mode,$data_type);

        $data = [];
        $data['exam_categories'] = $exam_categories;
        $data['fetchdata'] = $fetchdata;
        $data['filterkeys'] = $filterkeys;

        if($fetchdata)
        {
            $exam_bookings = ExamBooking::where('status','=','Verified');

            if($start)
            {
                $exam_bookings = $exam_bookings->where('created_at','>',$start);
            }

            if($end)
            {
                $exam_bookings = $exam_bookings->where('created_at','<',$end);
            }

            if($exam)
            {
                $exam_bookings = $exam_bookings->where('category_id','=',$exam->id);
            }

            if($mode)
            {
                $exam_bookings = $exam_bookings->where('verificationMode','=',$mode);
            }


            if($data_type == 'details' || $data_type == 'wallet-details' || $data_type == 'exam-details' || $data_type == 'all')
            {
                $bookings = clone($exam_bookings);
                $data['exam_bookings_details'] = $bookings->with('user:id,name,contact','category:id,title')
                ->get(['id','user_id','category_id','verificationMode','paymentAmount','created_at','updated_at']);
            }

            $exam_bookings = $exam_bookings
            ->with('category:id,title')
            ->select(
                'category_id',
                'verificationMode', 
                DB::raw('count(*) as count'), 
                DB::raw('sum(paymentAmount) as amount')
            )
            ->groupBy('verificationMode','category_id')
            ->get('category_id','verificationMode','paymentAmount')
            ->map(function($g){
                return (object)[
                    'exam_id' => $g->category->id ?? '',
                    'exam_name' => $g->category->title ?? 'Exam Undefined',
                    'mode' => $g->verificationMode,
                    'count' => $g->count,
                    'amount' => $g->amount,
                ];
            });


            if($data_type == 'wallet' || $data_type == 'wallet-details' || $data_type == 'wallet-exam' || $data_type == 'all')
            {
                $data['exam_bookings_wallet'] = $exam_bookings->groupBy('mode')
                ->map(function($g){
                    return (object)[
                        'mode' => $g->min('mode'),
                        'count' => $g->sum('count'),
                        'amount' => $g->sum('amount'),
                    ];
                })->values();
            }

            if($data_type == 'exam' || $data_type == 'exam-details' || $data_type == 'wallet-exam' || $data_type == 'all')
            {
                $data['exam_bookings_category'] = $exam_bookings->groupBy('exam_id')
                ->map(function($g){
                    return (object)[
                        'exam_id' => $g->min('exam_id'),
                        'exam_name' => $g->min('exam_name'),
                        'count' => $g->sum('count'),
                        'amount' => $g->sum('amount'),
                    ];
                })->values();
            }           
            
        }

        // dd($data);
        return view('admin.collection.exam_filter',$data);
        
    }

    public function bookingTypePdfBankCollection()
    {
        // dd('pdf bank collection');
        $pdf_bookings = PdfBooking::where('status','=','Verified')
        ->with('book:id,title')
        ->select(
            'book_id',
            'verificationMode', 
            DB::raw('count(*) as count'), 
            DB::raw('sum(paymentAmount) as amount')
        )
        ->groupBy('verificationMode','book_id')
        ->get('book_id','verificationMode','paymentAmount')
        ->map(function($g){
            return (object)[
                'pdf_bank_id' => $g->book->id ?? '',
                'pdf_bank_name' => $g->book->title ?? 'Pdf Bank Undefined',
                'mode' => $g->verificationMode,
                'count' => $g->count,
                'amount' => $g->amount,
            ];
        });
        
        $data['pdf_bookings_wallet'] = $pdf_bookings->groupBy('mode')
        ->map(function($g){
            return (object)[
                'mode' => $g->min('mode'),
                'count' => $g->sum('count'),
                'amount' => $g->sum('amount'),
            ];
        })->values();

        $data['pdf_bookings_bank'] = $pdf_bookings->groupBy('pdf_bank_id')
        ->map(function($g){
            return (object)[
                'pdf_bank_id' => $g->min('pdf_bank_id'),
                'pdf_bank_name' => $g->min('pdf_bank_name'),
                'count' => $g->sum('count'),
                'amount' => $g->sum('amount'),
            ];
        })->values();

        // dd($data);
        return view('admin.collection.pdf_bank_index',$data);
    }


    public function bookingTypePdfBankCollectionFilter(Request $request)
    {
        $pdf_bank_groups = PdfGroup::whereHas('bookings')->get(['id','title']);
        $fetchdata = false;
        $filterkeys = null;

        $start = null;
        $end = null;
        $pdf_bank = null;
        $mode = null;
        $data_type = null;

        if(isset($request->start_date) && trim($request->start_date))
        {
            $start = Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($request->start_date)))->startOfDay();
            if(!isset($request->end_date))
            {
                $end = Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($request->start_date)))->endOfDay();
            }
            $fetchdata = true;
            $filterkeys .= '<span class="mx-1">Start: '.$start->format('Y-m-d').'</span>';
        }

        if(isset($request->end_date) && trim($request->end_date))
        {
            $end = Carbon::createFromFormat('Y-m-d', date('Y-m-d',strtotime($request->end_date)))->endOfDay();
            $fetchdata = true;
            $filterkeys .= '<span class="mx-1">End: '.$end->format('Y-m-d').'</span>';
        }

        if(isset($request->pdf_bank_id) && trim($request->pdf_bank_id))
        {
            $pdf_bank = PdfGroup::find($request->pdf_bank_id,['id','title']);
            $fetchdata = true;
            $filterkeys .= '<span class="mx-1">Pdf Bank: '.$pdf_bank->title.'</span>';
        }

        if(isset($request->wallet) && trim($request->wallet))
        {
            $mode = trim($request->wallet);
            $fetchdata = true;
            $filterkeys .= '<span class="mx-1">Wallet: '.$mode.'</span>';
        }

        if(isset($request->data_type) && trim($request->data_type))
        {
            $data_type = trim($request->data_type);
        }

        // dd($fetchdata,$start,$end,$pdf_bank,$mode,$data_type);

        $data = [];
        $data['pdf_bank_groups'] = $pdf_bank_groups;
        $data['fetchdata'] = $fetchdata;
        $data['filterkeys'] = $filterkeys;

        if($fetchdata)
        {
            $pdf_bookings = PdfBooking::where('status','=','Verified');

            if($start)
            {
                $pdf_bookings = $pdf_bookings->where('created_at','>',$start);
            }

            if($end)
            {
                $pdf_bookings = $pdf_bookings->where('created_at','<',$end);
            }

            if($pdf_bank)
            {
                $pdf_bookings = $pdf_bookings->where('book_id','=',$pdf_bank->id);
            }

            if($mode)
            {
                $pdf_bookings = $pdf_bookings->where('verificationMode','=',$mode);
            }


            if($data_type == 'details' || $data_type == 'wallet-details' || $data_type == 'pdf-bank-details' || $data_type == 'all')
            {
                $bookings = clone($pdf_bookings);
                $data['pdf_bank_bookings_details'] = $bookings->with('user:id,name,contact','book:id,title')
                ->get(['id','user_id','book_id','verificationMode','paymentAmount','created_at','updated_at']);
            }

            $pdf_bookings = $pdf_bookings
            ->with('book:id,title')
            ->select(
                'book_id',
                'verificationMode', 
                DB::raw('count(*) as count'), 
                DB::raw('sum(paymentAmount) as amount')
            )
            ->groupBy('verificationMode','book_id')
            ->get('book_id','verificationMode','paymentAmount')
            ->map(function($g){
                return (object)[
                    'pdf_bank_id' => $g->book->id ?? '',
                    'pdf_bank_name' => $g->book->title ?? 'PDF Bank Undefined',
                    'mode' => $g->verificationMode,
                    'count' => $g->count,
                    'amount' => $g->amount,
                ];
            });


            if($data_type == 'wallet' || $data_type == 'wallet-details' || $data_type == 'wallet-pdf-bank' || $data_type == 'all')
            {
                $data['pdf_bank_bookings_wallet'] = $pdf_bookings->groupBy('mode')
                ->map(function($g){
                    return (object)[
                        'mode' => $g->min('mode'),
                        'count' => $g->sum('count'),
                        'amount' => $g->sum('amount'),
                    ];
                })->values();
            }

            if($data_type == 'pdf-bank' || $data_type == 'pdf-bank-details' || $data_type == 'wallet-pdf-bank' || $data_type == 'all')
            {
                $data['pdf_bank_bookings_groups'] = $pdf_bookings->groupBy('pdf_bank_id')
                ->map(function($g){
                    return (object)[
                        'pdf_bank_id' => $g->min('pdf_bank_id'),
                        'pdf_bank_name' => $g->min('pdf_bank_name'),
                        'count' => $g->sum('count'),
                        'amount' => $g->sum('amount'),
                    ];
                })->values();
            }           
            
        }

        // dd($data);
        return view('admin.collection.pdf_bank_filter',$data);
        
    }
}
