<?php

namespace App\Models\VideoCourse;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\VideoCourse\VideoCourse;

class VideoCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($category)
        {
            $slug = Str::slug($category->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $category->slug = $count ? "{$slug}-{$count}" : $slug;
        });

    }

    public function courses(): HasMany
    {
        return $this->hasMany(VideoCourse::class, 'category_id');
    }
}
