<?php

namespace App\Models\Vendors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Vendors\VendorUser;
use App\Models\Vendors\VendorBooking;
use App\Models\Vendors\VendorVideoBooking;
use App\Models\Vendors\VendorEbookBooking;
use App\Models\Forms\VendorForm;
use App\Models\Forms\VendorFormGroup;

class Vendor extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function myusers(): HasMany
    {
        return $this->hasMany(VendorUser::class, 'vendor_id');
    }

    public function mybookings(): HasMany
    {
        //course bookings
        return $this->hasMany(VendorBooking::class, 'vendor_id');
    }

    public function examBookings(): HasMany
    {
        //exam bookings
        return $this->hasMany(VendorExamBooking::class, 'vendor_id');
    }

    public function videoBookings(): HasMany
    {
        //video bookings
        return $this->hasMany(VendorVideoBooking::class, 'vendor_id');
    }

    public function ebookBookings(): HasMany
    {
        //ebook bookings
        return $this->hasMany(VendorEbookBooking::class, 'vendor_id');
    }

    public function forms(): HasMany
    {
        return $this->hasMany(VendorForm::class, 'vendor_id');
    }

    public function formGroups(): HasMany
    {
        return $this->hasMany(VendorFormGroup::class, 'vendor_id');
    }

}
