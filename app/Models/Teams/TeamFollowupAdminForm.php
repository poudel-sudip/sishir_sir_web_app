<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Teams\Team;
use App\Models\Forms\FormApplicant;

class TeamFollowupAdminForm extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(FormApplicant::class, 'applicant_id');
    }
}
