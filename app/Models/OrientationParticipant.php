<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Orientation;

class OrientationParticipant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orientation(): BelongsTo
    {
        return $this->belongsTo(Orientation::class, 'class_id');
    }
}
