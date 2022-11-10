<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DynamicForm extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($form) {

            $slug = Str::slug($form->title);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $form->slug = $count ? "{$slug}-{$count}" : $slug;

        });
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(FormApplicant::class, 'form_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DynamicFormCategory::class, 'category_id');
    }

}
