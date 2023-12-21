<?php

namespace App\Models\OpenExams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Exams\Exam;
use App\Models\User;

class OpenExam extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(OpenExamResult::class, 'exam_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
