<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Str;

class Categories extends Model
{
    use HasFactory;
    protected $guarded=[];


    protected static function boot()
    {
        parent::boot();

        static::creating(function($category) {

            $slug = Str::slug($category->name);

            // check to see if any other slugs exist that are the same & count them
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();

            // if other slugs exist that are the same, append the count to the slug
            $category->slug = $count ? "{$slug}-{$count}" : $slug;

        });

    }

    public function courses(): HasMany
    {
        return$this->hasMany(Course::class,'category_id','id')->orderBy('name','ASC');
    }

    public function batches(): HasManyThrough
    {
        return $this->hasManyThrough(Batch::class,Course::class,'category_id','course_id','id');
    }

    public function bookings(): HasManyThrough
    {
        return $this->hasManyThrough(Booking::class,Course::class,'category_id','course_id','id');
    }

}
