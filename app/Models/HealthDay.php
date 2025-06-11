<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class HealthDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'date',
        'title',
        'pdf_file',
        'description',
        'author_name',
        'author_image',
        'thumbnail_image',
    ];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
   
    public function slogans(): HasMany
    {
        return $this->hasMany(Categories::class, 'parent_id')->where('type','=','health-day-slogan');
    }
}
