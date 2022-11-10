<?php

namespace App\Models\VideoCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\VideoCourse\VideoCourse;

class VideoCQC extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function course(): BelongsTo
    {
        return $this->belongsTo(VideoCourse::class, 'course_id');
    }
}
