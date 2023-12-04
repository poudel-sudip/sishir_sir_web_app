<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QRBook extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($book){
            $slug = Str::slug($book->title);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $book->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    public function scanMembers(): HasMany
    {
        return $this->hasMany(QRBookScanMember::class, 'book_id');
    }
}
