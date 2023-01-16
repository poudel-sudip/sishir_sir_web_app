<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItemCategory extends Model
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

    public function subgroup(): BelongsTo
    {
        return $this->belongsTo(MenuSubGroup::class, 'subgroup_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'category_id');
    }
}
