<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

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

    public function forms(): HasMany
    {
        return $this->hasMany(DynamicForm::class, 'group_id');
    }
}
