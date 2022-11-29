<?php

namespace App\Models;

use App\Models\Reports\ReportUser;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\Ebook\EbookBooking;
use function Symfony\Component\String\u;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded=[];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class)->orderBy('created_at','DESC');
    }

    public function exam_bookings():HasMany 
    {
        return $this->hasMany(ExamHallBookings::class,'user_id')->orderByDesc('id');
    }

    public function ebook_bookings():HasMany 
    {
        return $this->hasMany(EbookBooking::class,'user_id')->orderByDesc('id');
    }

    public function userNotifications(): BelongsToMany
    {
        return $this->belongsToMany(Notification::class)->withTimestamps();
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    
}
