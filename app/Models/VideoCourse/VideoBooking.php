<?php

namespace App\Models\VideoCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\VideoCourse\VideoCourse;
use App\Models\Vendors\VendorVideoBooking;

class VideoBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(VideoCourse::class, 'course_id');
    }

    public function vendorBooking(): HasOne
    {
        return $this->hasOne(VendorVideoBooking::class, 'booking_id');
    }
}
