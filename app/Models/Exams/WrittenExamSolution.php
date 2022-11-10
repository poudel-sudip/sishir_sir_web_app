<?php

namespace App\Models\Exams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class WrittenExamSolution extends Model
{
    use HasFactory;
    protected $guarded=[];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    
    public function question(): BelongsTo
    {
        return $this->belongsTo(WrittenExam::class, 'exam_id');
    }
}
