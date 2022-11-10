<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Booking;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\VideoCourse\VideoBooking;
use App\Models\Ebook\EbookBooking;

class MerchantBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function courseBooking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function examBooking(): BelongsTo
    {
        return $this->belongsTo(ExamHallBookings::class, 'booking_id');
    }

    public function videoBooking(): BelongsTo
    {
        return $this->belongsTo(VideoBooking::class, 'booking_id');
    }

    public function ebookBooking(): BelongsTo
    {
        return $this->belongsTo(EbookBooking::class, 'booking_id');
    }
}
