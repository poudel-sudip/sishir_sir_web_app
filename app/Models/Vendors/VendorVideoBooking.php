<?php

namespace App\Models\Vendors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Vendors\Vendor;
use App\Models\VideoCourse\VideoBooking;
use App\Models\Teams\Team;

class VendorVideoBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(VideoBooking::class, 'booking_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
