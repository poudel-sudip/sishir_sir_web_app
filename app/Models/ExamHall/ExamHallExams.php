<?php

namespace App\Models\ExamHall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Exams\Exam;
use App\Models\ExamHall\ExamHallCategories;
use App\Models\ExamHall\ExamHallEvaluation;
use App\Models\ExamHall\ExamHallResults;

class ExamHallExams extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ExamHallCategories::class, 'category_id');
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    
}
