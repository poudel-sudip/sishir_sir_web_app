<?php

namespace App\Models\ExamHall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\Vendors\VendorExamBooking;

class ExamHallBookings extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExamHallCategories::class, 'category_id');
    }

    public function vendorBooking(): HasOne
    {
        return $this->hasOne(VendorExamBooking::class, 'booking_id');
    }
}
