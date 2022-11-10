<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Teams\Team;

class ManualBooking extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class,'team_id');
    }
}
