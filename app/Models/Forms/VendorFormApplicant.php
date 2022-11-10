<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Vendors\Vendor;

class VendorFormApplicant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function form(): BelongsTo
    {
        return $this->belongsTo(VendorForm::class, 'form_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
