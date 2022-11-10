<?php

namespace App\Models\Ebook;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Ebook\Ebook;
use App\Models\Ebook\ChapterFiles;

class EbookChapter extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($chapter)
        {
            $slug = Str::slug($chapter->title);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $chapter->slug = $count ? "{$slug}-{$count}" : $slug;
        });

    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Ebook::class, 'book_id');
    }
    
    public function chapterfiles(): HasMany
    {
        return $this->hasMany(ChapterFiles::class, 'chapter_id');
    }
}
