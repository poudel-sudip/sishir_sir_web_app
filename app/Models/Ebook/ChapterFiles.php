<?php

namespace App\Models\Ebook;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Ebook\EbookChapter;

class ChapterFiles extends Model
{
    use HasFactory;
    protected $guarded = [];

    
    public function chapterfiles(): BelongsTo
    {
        return $this->belongsTo(EbookChapter::class, 'chapter_id');
    }
}
