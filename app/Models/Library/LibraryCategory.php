<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LibraryCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($cat){
            $slug = Str::slug($cat->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $cat->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    public function materials(): HasMany
    {
        return $this->hasMany(LibraryMaterial::class, 'category_id');
    }
}
