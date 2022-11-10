<?php

namespace App\Models\VideoCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Exams\Exam;
use App\Models\VideoCourse\VideoCourse;

class VideoExamResult extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function course(): BelongsTo
    {
        return $this->belongsTo(VideoCourse::class, 'course_id');
    }

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
