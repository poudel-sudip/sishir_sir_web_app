<?php

namespace App\Models\Ebook;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Ebook\EbookChapter;
use App\Models\Ebook\EbookCategory;

class Ebook extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($book)
        {
            $slug = Str::slug($book->title);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $book->slug = $count ? "{$slug}-{$count}" : $slug;
        });

    }

    public function chapters(): HasMany
    {
        return $this->hasMany(EbookChapter::class, 'book_id')->orderBy('name');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(EbookBooking::class, 'book_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(EbookCategory::class, 'category_id');
    }

}
