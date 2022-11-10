<?php

namespace App\Models\VideoCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\VideoCourse\VideoCategory;
use App\Models\VideoCourse\VideoChapter;
use App\Models\VideoCourse\VideoBooking;
use App\Models\VideoCourse\VideoTutor;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\VideoCourse\VideoPost;
 
class VideoCourse extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($course)
        {
            $slug = Str::slug($course->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $course->slug = $count ? "{$slug}-{$count}" : $slug;
        });

    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(VideoCategory::class, 'category_id');
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(VideoChapter::class, 'course_id')->orderBy('sn');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(VideoBooking::class, 'course_id');
    }

    public function exams(): HasMany
    {
        return $this->hasMany(VideoExam::class, 'course_id');
    }

    public function cqcs(): HasMany
    {
        return $this->hasMany(VideoCQC::class, 'course_id')->orderByDesc('id');
    }

    public function tutors(): HasMany
    {
        return $this->hasMany(VideoTutor::class, 'course_id')->orderByDesc('id');
    }

    public function videos(): HasManyThrough
    {
        return $this->hasManyThrough(VideoPost::class, VideoChapter::class,'course_id','chapter_id')->where('video_posts.status','=','Active');
    }

    public function publicVideos(): HasManyThrough
    {
        return $this->hasManyThrough(VideoPost::class, VideoChapter::class,'course_id','chapter_id')->where('video_posts.status','=','Active')->where('video_posts.isPublic','=','Yes');
    }
}
