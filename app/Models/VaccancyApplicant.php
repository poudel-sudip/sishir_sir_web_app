<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\VaccancyPost;

class VaccancyApplicant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vaccancy(): BelongsTo
    {
        return $this->belongsTo(VaccancyPost::class, 'vaccancy_id');
    }
}
