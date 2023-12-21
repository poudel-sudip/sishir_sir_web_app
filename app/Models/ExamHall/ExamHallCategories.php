<?php

namespace App\Models\ExamHall;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\ExamHall\ExamHallExams;
use App\Models\ExamHall\ExamHallBookings;
use App\Models\User;

class ExamHallCategories extends Model
{
    use HasFactory;
    protected $guarded=[];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($cat) {

            $slug = Str::slug($cat->title);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $cat->slug = $count ? "{$slug}-{$count}" : $slug;

        });
    }

    
    public function category_exams(): HasMany
    {
        return $this->hasMany(ExamHallExams::class, 'category_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(ExamHallBookings::class, 'category_id');
    }

    public function cqcs(): HasMany
    {
        return $this->hasMany(ExamHallCQC::class, 'category_id')->orderByDesc('id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
