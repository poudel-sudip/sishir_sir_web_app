<?php

namespace App\Models\Ebook;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Ebook\Ebook;
use App\Models\Vendors\VendorEbookBooking;
use App\Models\PaymentInvoice;

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

    public function payment_invoices(): HasMany
    {
        return $this->hasMany(PaymentInvoice::class, 'booking_id')->where('type', 'ebook');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($data) {
            $data->payment_invoices()->delete();
        });

    }
}
