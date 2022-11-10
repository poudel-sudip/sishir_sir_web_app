<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\OrientationParticipant;

class Orientation extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function($ori) {
            $slug = Str::slug($ori->course);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $ori->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    public function participants(): HasMany
    {
        return $this->hasMany(OrientationParticipant::class, 'class_id');
    }
}
