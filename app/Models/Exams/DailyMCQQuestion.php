<?php

namespace App\Models\Exams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\PostComment;

class DailyMCQQuestion extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id')->where('post_type','=','daily_mcq_question');
    }
}
