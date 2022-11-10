<?php

namespace App\Models;

use App\Models\Reports\ReportCourseBatches;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\Exams\BatchExam;
use App\Models\Exams\Result;
use App\Models\Exams\WrittenExam;
use App\Models\Assignments\Assignment;
use App\Models\BatchCQC;
use App\Models\ClassSchedule;
use App\Models\ClassUnit;

class Batch extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($batch) {

            $slug = Str::slug($batch->name);

            // check to see if any other slugs exist that are the same & count them
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            // if other slugs exist that are the same, append the count to the slug
            $batch->slug = $count ? "{$slug}-{$count}" : $slug;

        });

        static::created(function($batch) {
            ReportCourseBatches::create([
                'course_id'=>$batch->course->id,
                'batch_id'=>$batch->id,
                'name'=>$batch->name,
                'start'=>$batch->startDate,
                'end'=>$batch->endDate,
                'fee'=>$batch->fee,
                'discount'=>$batch->discount,
                'time'=>$batch->timeSlot,
                'status'=>$batch->status,
                'totalstds'=>'0',
                'verifiedstds'=>'0'
            ]);
        });

        static::updated(function($batch) {
            ReportCourseBatches::where('batch_id','=',$batch->id)
                ->update([
                    'course_id'=>$batch->course->id,
                    'name'=>$batch->name,
                    'start'=>$batch->startDate,
                    'end'=>$batch->endDate,
                    'fee'=>$batch->fee,
                    'discount'=>$batch->discount,
                    'time'=>$batch->timeSlot,
                    'status'=>$batch->status,
                ]);
        });

        static::deleted(function($batch) {
            ReportCourseBatches::where('batch_id','=',$batch->id)
                ->update(['status'=>'Deleted']);
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function classDiscussions(): HasMany
    {
        return $this->hasMany(ClassDiscussion::class)->orderBy('created_at');
    }

    // public function privateChats(): HasMany
    // {
    //     return $this->hasMany(PrivateChat::class);
    // }

    public function classFiles(): HasMany
    {
        return $this->hasMany(ClassFiles::class)->orderBy('created_at');
    }

    public function classVideos(): HasMany
    {
        return $this->hasMany(ClassVideos::class)->orderBy('created_at');
    }

    public function tutors(): BelongsToMany
    {
        return $this->belongsToMany(Tutor::class)->orderBy('name')->withTimestamps();
    }

    public function followup(): HasMany
    {
        return $this->hasMany(Followup::class);
    }

    public function batchExams(): HasMany
    {
        return $this->hasMany(BatchExam::class, 'batch_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'batch_id');
    }

    public function writtenExams(): HasMany
    {
        return $this->hasMany(WrittenExam::class, 'batch_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class, 'batch_id');
    }

    public function cqcs(): HasMany
    {
        return $this->hasMany(BatchCQC::class, 'batch_id')->orderByDesc('id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class, 'batch_id');
    }

    public function units(): HasMany
    {
        return $this->hasMany(ClassUnit::class, 'batch_id');
    }
}
