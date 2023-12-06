<?php

namespace App\Models\Books;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QRBook extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // static::creating(function($book){
        //     $slug = Str::slug($book->title);
        //     $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        //     $book->slug = $count ? "{$slug}-{$count}" : $slug;
        // });

        static::deleting(function($book){
            $book->scanMembers()->delete();
        });
    }

    public function scanMembers(): HasMany
    {
        return $this->hasMany(QRBookScanMember::class, 'book_id');
    }

    public function winners(): HasMany
    {
        return $this->hasMany(QRBookScanMember::class, 'book_id')->where('is_main','=',true)->where('is_winner','=',true)->where('winner_remarks','!=',null);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
