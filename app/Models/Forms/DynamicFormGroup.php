<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class DynamicFormGroup extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($group) {

            $slug = Str::slug($group->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $group->slug = $count ? "{$slug}-{$count}" : $slug;

        });
    }

    public function categories(): HasMany
    {
        return $this->hasMany(DynamicFormCategory::class, 'group_id');
    }

    public function applicants(): HasManyThrough
    {
        return $this->hasManyThrough(FormApplicant::class, DynamicFormCategory::class, 'group_id', 'category_id');
    }

}
