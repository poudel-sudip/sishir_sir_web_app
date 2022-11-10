<?php

namespace App\Models\Exams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\OpenExams\OpenExam;
use App\Models\Exams\ExamCategory;

class Exam extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'exam_id')->orderBy('id');
    }

    public function batchExams(): HasMany
    {
        return $this->hasMany(BatchExam::class, 'exam_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'exam_id');
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class, 'exam_id');
    }

    public function openExams(): HasMany
    {
        return $this->hasMany(OpenExam::class, 'exam_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExamCategory::class, 'category_id');
    }
    
}
