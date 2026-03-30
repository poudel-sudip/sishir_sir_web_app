<?php

namespace App\Models\ExamHall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\Vendors\VendorExamBooking;
use App\Models\PaymentInvoice;

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

    public function payment_invoices(): HasMany
    {
        return $this->hasMany(PaymentInvoice::class, 'booking_id')->where('type', 'exam');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($data) {
            $data->payment_invoices()->delete();
        });

    }
   
}
