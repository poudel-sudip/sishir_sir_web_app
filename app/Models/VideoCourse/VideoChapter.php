<?php

namespace App\Models\VideoCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\VideoCourse\VideoCourse;
use App\Models\VideoCourse\VideoPost;

class VideoChapter extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($chapter)
        {
            $slug = Str::slug($chapter->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $chapter->slug = $count ? "{$slug}-{$count}" : $slug;
        });

    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(VideoCourse::class, 'course_id');
    }

    public function videos(): HasMany
    {
        return $this->hasMany(VideoPost::class, 'chapter_id');
    }
}
