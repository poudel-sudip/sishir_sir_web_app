<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Log;
use App\Models\Ebook\EbookBooking as PdfBankBooking;
use App\Models\ExamHall\ExamHallBookings as ExamBooking;

class BookingExpiryUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking-expiry-update:manage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the bookings based on given expiry date.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->examBookingExpiry();
        $this->pdfBankBookingExpiry();
        return 0;
        
    }

    private function examBookingExpiry()
    {
        $today = Carbon::now();
        $bookings = ExamBooking::query()
        ->where('status','=','Verified')
        ->where('expiry_date','!=','')
        ->whereDate('expiry_date','<',$today)
        ->get(['id','status','expiry_date']);

        foreach ($bookings as $b) {
            $b->update(['status'=>'Expired']);
        }

        Log::info("Total Exam Bookings Expired Today: ".$bookings->count());
    }

    private function pdfBankBookingExpiry()
    {
        $today = Carbon::now();
        $bookings = PdfBankBooking::query()
        ->where('status','=','Verified')
        ->where('expiry_date','!=','')
        ->whereDate('expiry_date','<',$today)
        ->get(['id','status','expiry_date']);

        foreach ($bookings as $b) {
            $b->update(['status'=>'Expired']);
        }
        
        Log::info("Total Ebook | Pdf Bank Bookings Expired Today: ".$bookings->count());
    }

}
