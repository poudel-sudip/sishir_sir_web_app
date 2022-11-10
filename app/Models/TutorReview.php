<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TutorReview extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class);
    }
}
