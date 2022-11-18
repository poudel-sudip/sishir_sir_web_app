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

    public function batchExams(): HasMany
    {
        return $this->hasMany(BatchExam::class, 'batch_id');
    }

    public function results(): HasMany
    {
        return $this->hasMany(Result::class, 'batch_id');
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
