<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\VaccancyApplicant;

class VaccancyPost extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function($post) {

            $slug = Str::slug($post->title);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $post->slug = $count ? "{$slug}-{$count}" : $slug;

        });

    }

    public function applicants(): HasMany
    {
        return $this->hasMany(VaccancyApplicant::class, 'vaccancy_id');
    }
}
