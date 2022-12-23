<?php

namespace App\Models\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuItem extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($item){
            $slug = Str::slug($item->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $item->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    public function subgroup(): BelongsTo
    {
        return $this->belongsTo(MenuSubGroup::class, 'subgroup_id');
    }


}
