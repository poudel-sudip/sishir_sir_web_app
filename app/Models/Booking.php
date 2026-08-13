<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;
use App\Models\Course;
use App\Models\Batch;

class Booking extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function course(): BelongsTo
    {
        return$this->belongsTo(Course::class,'course_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class,'batch_id');
    }

    public function payment_invoices(): HasMany
    {
        return $this->hasMany(PaymentInvoice::class, 'booking_id')->where('type', 'course');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($data) {
            $data->payment_invoices()->delete();
        });

    }
}
