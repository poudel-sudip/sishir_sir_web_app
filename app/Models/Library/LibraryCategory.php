<?php

namespace App\Models\Library;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = ['total_materials', 'active_materials'];

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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(LibraryCategory::class, 'parent_id');
    }

    public function childs(): HasMany
    {
        return $this->hasMany(LibraryCategory::class, 'parent_id');
    }

    public function getTotalMaterialsAttribute()
    {
        return $this->countLibraryMaterialsRecursive($this, 'all');
    }

    public function getActiveMaterialsAttribute()
    {
        return $this->countLibraryMaterialsRecursive($this, 'Active');
    }

    protected function countLibraryMaterialsRecursive(LibraryCategory $category,$stat): int
    {
        if(in_array($stat, ['Active', 'Inactive']))
        {
            $count = $category->materials()->where('status','=',$stat)->count();
        }        
        else
        {
            $count = $category->materials()->count();
        }


        foreach ($category->childs as $child) {
            $count += $this->countLibraryMaterialsRecursive($child, $stat);
        }

        return $count;
    }
}
