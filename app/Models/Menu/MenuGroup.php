<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class MenuGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subGroups(): HasMany
    {
        return $this->hasMany(MenuSubGroup::class, 'group_id');
    }

    public function items(): HasManyThrough
    {
        return $this->hasManyThrough(MenuItem::class, MenuSubGroup::class,'group_id','subgroup_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function($group){
            $slug = Str::slug($group->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $group->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }
}
