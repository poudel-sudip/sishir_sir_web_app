<?php

namespace App\Models\Tutors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tutor;
use App\Models\Tutors\SpecialCourseBooking;
use App\Models\Tutors\TutorClassChat;
use App\Models\Tutors\TutorClassFile;
use App\Models\Tutors\TutorClassVideo;
use App\Models\Tutors\TutorCoursePayments;

class SpecialCourse extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }
    
    public function bookings(): HasMany
    {
        return $this->hasMany(SpecialCourseBooking::class, 'course_id');
    }

    public function chats(): HasMany
    {
        return $this->hasMany(TutorClassChat::class, 'course_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(TutorClassFile::class, 'course_id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(TutorClassVideo::class, 'course_id');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(TutorCoursePayment::class, 'course_id');
    }

}
