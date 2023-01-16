<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class MenuSubGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($group){
            $slug = Str::slug($group->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $group->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(MenuGroup::class, 'group_id');
    }

    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(MenuItem::class, MenuItemCategory::class,'subgroup_id','category_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(MenuItemCategory::class, 'subgroup_id');
    }
}
