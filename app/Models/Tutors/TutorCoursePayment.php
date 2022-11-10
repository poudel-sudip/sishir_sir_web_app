<?php

namespace App\Models\Tutors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tutor;
use App\Models\Batch;
use App\Models\Tutors\SpecialCourse;

class TutorCoursePayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }

    public function normalCourse(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'course_id');
    }
    
    public function specialCourse(): BelongsTo
    {
        return $this->belongsTo(SpecialCourse::class, 'course_id');
    }
}
