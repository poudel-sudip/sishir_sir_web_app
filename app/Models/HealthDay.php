<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HealthDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'date',
        'title',
        'pdf_file',
        'description',
        'author',
        'image',
    ];
    
    public function category(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }
}
