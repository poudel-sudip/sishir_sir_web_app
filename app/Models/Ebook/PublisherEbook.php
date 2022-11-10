<?php

namespace App\Models\Ebook;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublisherEbook extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ebook(): BelongsTo
    {
        return $this->belongsTo(Ebook::class, 'book_id');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }
}
