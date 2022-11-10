<?php

namespace App\Models\Provience;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Provience\Provience;

class DistrictCity extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function provience(): BelongsTo
    {
        return $this->belongsTo(Provience::class, 'provience_id');
    }
}
