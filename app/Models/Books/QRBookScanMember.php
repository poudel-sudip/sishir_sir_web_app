<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRBookScanMember extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function book(): BelongsTo
    {
        return $this->belongsTo(QRBook::class, 'book_id');
    }
}
