<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Teams\TeamAssignAdminForm;

class DynamicFormCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($cat) {

            $slug = Str::slug($cat->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $cat->slug = $count ? "{$slug}-{$count}" : $slug;

        });

    }

    public function form(): HasOne
    {
        return $this->hasOne(DynamicForm::class, 'category_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(DynamicFormGroup::class, 'group_id');
    }

    public function subCategories(): HasMany
    {
        return $this->hasMany(DynamicFormSubCategory::class, 'category_id');
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(FormApplicant::class, 'category_id');
    }

    public function assignedTeams(): HasMany
    {
        return $this->hasMany(TeamAssignAdminForm::class, 'category_id');
    }  

}
