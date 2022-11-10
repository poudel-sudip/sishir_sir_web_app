<?php

namespace App\Models;

use App\Models\Reports\ReportUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Tutor;
use App\Models\Tutors\SpecialCourseBooking;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\Vendors\Vendor;
use App\Models\VideoCourse\VideoBooking;
use App\Models\Ebook\EbookBooking;
use function Symfony\Component\String\u;
use App\Models\Branch\Branch;
use App\Models\Branch\BranchMember;
use App\Models\Publisher;
use App\Models\Teams\Team;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */

    protected $guarded=[];

    //    protected $fillable = [
    //        'name',
    //        'email',
    //        'password',
    //        'role',
    //        'contact',
    //        'status',
    //    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($user) {
            ReportUser::create([
                'user_id'=>$user->id,
                'name'=>$user->name,
                'email'=>$user->email,
                'contact'=>$user->contact,
                'district'=>$user->district_city ?? '',
                'interests'=>$user->interests ?? '',
                'role'=>$user->role,
                'status'=>$user->status,
            ]);
        });

        static::updated(function($user){
            ReportUser::where('user_id',$user->id)
                ->update([
                    'name'=>$user->name,
                    'email'=>$user->email,
                    'contact'=>$user->contact,
                    'role'=>$user->role,
                    'district'=>$user->district_city ?? '',
                    'interests'=>$user->interests ?? '',
                    'status'=>$user->status,
                ]);
        });

        static::deleted(function($user) {
            ReportUser::where('user_id',$user->id)
                ->update([
                    'status'=>'Deleted',
                ]);
        });
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class)->orderBy('created_at','DESC');
    }

    public function specialCourseBookings(): HasMany
    {
        return $this->hasMany(SpecialCourseBooking::class)->orderBy('created_at','DESC');
    }

    public function userNotifications(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class)->withTimestamps();
    }

    public function followup(): HasMany
    {
        return $this->hasMany(Followup::class);
    }
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    
    public function tutorProfile(): HasOne
    {
        return $this->hasOne(Tutor::class,'user_id');
    }

    public function vendor(): HasOne
    {
        return $this->hasOne(Vendor::class,'user_id');
    }

    public function exam_bookings():HasMany 
    {
        return $this->hasMany(ExamHallBookings::class,'user_id')->orderByDesc('id');
    }

    public function video_bookings():HasMany 
    {
        return $this->hasMany(VideoBooking::class,'user_id')->orderByDesc('id');
    }

    public function ebook_bookings():HasMany 
    {
        return $this->hasMany(EbookBooking::class,'user_id')->orderByDesc('id');
    }

    public function branchProfile(): HasOne
    {
        return $this->hasOne(Branch::class,'user_id');
    }

    public function branchMemberProfile(): HasOne
    {
        return $this->hasOne(BranchMember::class,'user_id');
    }

    public function publisher(): HasOne
    {
        return $this->hasOne(Publisher::class,'user_id');
    }

    public function team(): HasOne
    {
        return $this->hasOne(Team::class,'user_id');
    }
}
