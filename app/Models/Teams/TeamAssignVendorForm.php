<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Teams\Team;
use App\Models\Forms\VendorForm;
use App\Models\Vendors\Vendor;

class TeamAssignVendorForm extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(VendorForm::class, 'form_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}
