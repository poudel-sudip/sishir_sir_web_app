<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassUnit extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function batch(): BelongsTo
    {
        return$this->belongsTo(Batch::class,'batch_id');
    }

    public function classFiles(): HasMany
    {
        return $this->hasMany(ClassFiles::class,'unit_id');
    }

    public function classVideos(): HasMany
    {
        return $this->hasMany(ClassVideos::class,'unit_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ClassUnit::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ClassUnit::class, 'parent_id');
    }
}
