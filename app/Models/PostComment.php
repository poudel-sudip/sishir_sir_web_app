<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Exams\DailyMCQQuestion;

class PostComment extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function dailyQuestion(): BelongsTo
    {
        return $this->belongsTo(DailyMCQQuestion::class,'post_id');
    }
}
