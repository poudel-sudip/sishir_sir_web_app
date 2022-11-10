<?php

namespace App\Models\Vendors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Vendors\Vendor;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\Teams\Team;

class VendorExamBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(ExamHallBookings::class, 'booking_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
