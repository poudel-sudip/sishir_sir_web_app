<?php

namespace App\Models\ExamHall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Exams\Question;
use App\Models\Exams\Exam;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\User;

class ExamHallEvaluation extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function getQuestion(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id');
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExamHallCategories::class, 'category_id');
    }
}
