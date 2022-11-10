<?php

namespace App\Models\VideoCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Models\VideoCourse\VideoChapter;

class VideoPost extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($video)
        {
            $slug = Str::slug($video->title);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $video->slug = $count ? "{$slug}-{$count}" : $slug;
        });

    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(VideoChapter::class, 'chapter_id');
    }
}
