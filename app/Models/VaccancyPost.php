<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\VaccancyApplicant;
use App\Models\Categories as Category;

class VaccancyPost extends Model
{
    use HasFactory;
    protected $guarded = [];   

    protected $casts = [
        'tag_ids' => 'array',
    ];

    protected $appends = ['related_tag_names'];   

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

    public function getRelatedTagNamesAttribute()
    {
        $tagIds = is_array($this->tag_ids)
            ? $this->tag_ids
            : (is_string($this->tag_ids) ? json_decode($this->tag_ids, true) : []);

        if (empty($tagIds)) {
            return [];
        }      

        return Category::whereIn('id', $tagIds)->where('type','=','vaccancy_tag')->pluck('name')->toArray();
    }

    public function relatedTags()
    {
        $tagIds = is_array($this->tag_ids)
            ? $this->tag_ids
            : (is_string($this->tag_ids) ? json_decode($this->tag_ids, true) : []);

        if (empty($tagIds)) {
            return collect([]);
        }  

        return Category::whereIn('id', $tagIds)->where('type','=','vaccancy_tag')->get();
    }
    
}
