<?php

namespace App\Models\Tutors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Tutors\SpecialCourse;

class SpecialCourseBooking extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function course(): BelongsTo
    {
        return $this->belongsTo(SpecialCourse::class, 'course_id');
    }

}
