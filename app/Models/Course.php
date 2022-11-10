<?php

namespace App\Models;

use App\Models\Reports\ReportCourse;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

use function Symfony\Component\Translation\t;

class Course extends Model
{
    use HasFactory;

    // Either comment out $guarded variable or $fillable variable only one should be commented

    protected $guarded=[];

    //    protected $fillable = [
    //        'name',
    //        'description',
    //        'fee',
    //        'duration',
    //        'durationType',
    //        'startDate',
    //        'endDate',
    //        'timeSlot',
    //        'status',
    //    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($course) {

            $slug = Str::slug($course->name);

            // check to see if any other slugs exist that are the same & count them
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            // if other slugs exist that are the same, append the count to the slug
            $course->slug = $count ? "{$slug}-{$count}" : $slug;

        });

        static::created(function ($course) {
            ReportCourse::create([
                'category'=>$course->category_id,
                'course_id'=>$course->id,
                'course'=>$course->name,
                'slug'=>$course->slug,
                'isPopular'=>$course->isPopular,
                'status'=>$course->status,
            ]);
        });

        static::updated(function($course) {
            ReportCourse::where('course_id',$course->id)
                ->update([
                    'category'=>$course->category_id,
                    'course'=>$course->name,
                    'isPopular'=>$course->isPopular,
                    'status'=>$course->status,
                ]);
        });

        static::deleted(function ($course) {
            ReportCourse::where('course_id',$course->id)
                ->update([
                    'status'=>'Deleted',
                ]);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class);
    }

    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class)->orderBy('created_at','DESC');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class)->orderBy('created_at','DESC');
    }

    public function features(): HasMany
    {
        return $this->hasMany(CourseFeatures::class);
    }

    public function normalFeatures(): HasMany
    {
        return $this->hasMany(CourseFeatures::class)->where('isUnique','=','No');
    }

    public function uniqueFeatures(): HasMany
    {
        return $this->hasMany(CourseFeatures::class)->where('isUnique','=','Yes');
    }
    public function manualBookings(): HasMany
    {
        return $this->hasMany(ManualBooking::class);
    }
}
