<?php

namespace App\Models;

use App\Models\User;
use App\Models\Reports\ReportTutor;
use App\Models\Reports\ReportTutorBatches;
use App\Models\Tutors\SpecialCourse;
use App\Models\Tutors\TutorCoursePayment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use function Symfony\Component\Translation\t;
use App\Models\VideoCourse\VideoTutor;

class Tutor extends Model
{
    use HasFactory;
    protected $guarded=[];


    protected static function boot()
    {
        parent::boot();

        static::creating(function($tutor) {

            // produce a slug based on the tutor name
            $slug = Str::slug($tutor->name);

            // check to see if any other slugs exist that are the same & count them
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            // if other slugs exist that are the same, append the count to the slug
            $tutor->slug = $count ? "{$slug}-{$count}" : $slug;

        });

        static::created(function($tutor) {
            $batches=Batch::find(request()->courses);
            $courses='';
            if($batches)
            {
                foreach ($batches as $batch)
                {
                    $courses .=$batch->course->name.' '.$batch->name.',';
                    ReportTutorBatches::create([
                        'tutor'=>$tutor->id,
                        'batch'=>$batch->id,
                        'price'=>0,
                        'status'=>'Active',
                    ]);
                }
            }

            ReportTutor::create([
                'tutor_id'=>$tutor->id,
                'name'=>$tutor->name,
                'email'=>$tutor->user->email ?? '',
                'contact'=>$tutor->user->contact ?? '',
                'qualification'=>$tutor->qualification ?? '',
                'experience'=>$tutor->experience,
                'courses'=>$courses,
                'status'=>'Inactive',
            ]);
        });

        static::updated(function($tutor) {
            $batches=Batch::find(request()->courses);
            $courses='';
            if($batches)
            {
                ReportTutorBatches::where('tutor','=',$tutor->id)->delete();
                foreach ($batches as $batch)
                {
                    $courses .=$batch->course->name.' '.$batch->name.',';
                    ReportTutorBatches::create([
                        'tutor'=>$tutor->id,
                        'batch'=>$batch->id,
                        'price'=>0,
                        'status'=>'Active',
                    ]);
                }
            }

            ReportTutor::where('tutor_id',$tutor->id)
                ->update([
                    'name'=>$tutor->name,
                    'email'=>$tutor->user->email ?? '',
                    'contact'=>$tutor->user->contact ?? '',
                    'qualification'=>$tutor->qualification,
                    'experience'=>$tutor->experience,
                    'courses'=>$courses,
                    'status'=>'Active',
                ]);
        });

        static::deleted(function ($tutor) {
            ReportTutor::where('tutor_id',$tutor->id)
                ->update(['status'=>'Deleted']);

            ReportTutorBatches::where('tutor','=',$tutor->id)->update(['status'=>'Deleted']);
        });
    }

    public function batches(): BelongsToMany
    {
        return $this->belongsToMany(Batch::class)->orderBy('name')->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(TutorReview::class)->orderByDesc('id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(TutorPost::class)->orderByDesc('id');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function specialCourses(): HasMany
    {
        return $this->hasMany(SpecialCourse::class)->orderByDesc('id');
    }

    public function paymentRequests(): HasMany
    {
        return $this->hasMany(TutorCoursePayment::class)->orderByDesc('id');
    }

    public function videoCourses(): HasMany
    {
        return $this->hasMany(VideoTutor::class, 'tutor_id')->orderByDesc('id');
    }
    
}
