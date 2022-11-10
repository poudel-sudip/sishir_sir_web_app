<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Forms\VendorFormApplicant;

class TeamFollowupVendorForm extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(VendorFormApplicant::class, 'applicant_id');
    }
}
