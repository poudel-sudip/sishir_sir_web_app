<?php

namespace App\Models\Ebook;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\Ebook\Ebook;
use App\Models\Vendors\VendorEbookBooking;

class EbookBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Ebook::class, 'book_id');
    }

    public function vendorBooking(): HasOne
    {
        return $this->hasOne(VendorEbookBooking::class, 'booking_id');
    }

}
