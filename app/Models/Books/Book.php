<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Categories;

class Book extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($book){
            $slug = Str::slug($book->title);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $book->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id')->where('type','=','book_category');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'publisher_id')->where('type','=','book_publisher');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(BookReview::class, 'book_id');
    }
}
