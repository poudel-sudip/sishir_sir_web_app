<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Models\Books\Book;
use App\Models\ExamHall\ExamHallCategories;

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

    public function pub_categories(): HasMany
    {
        return$this->hasMany(Categories::class,'parent_id')->where('type','=','book_category');
    }

    public function pub_books(): HasMany
    {
        return$this->hasMany(Book::class,'publisher_id');
    }

    public function cat_books(): HasMany
    {
        return$this->hasMany(Book::class,'category_id');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'parent_id')->where('type','=','book_publisher');
    }

    public function imp_links(): HasMany
    {
        return$this->hasMany(ImportantLink::class,'category_id');
    }

    public function premium_exams(): HasMany
    {
        return$this->hasMany(ExamHallCategories::class,'group_id');
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
