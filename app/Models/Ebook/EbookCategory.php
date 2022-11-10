<?php

namespace App\Models\Ebook;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use App\Models\Ebook\Ebook;

class EbookCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function($data)
        {
            $slug = Str::slug($data->name);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $data->slug = $count ? "{$slug}-{$count}" : $slug;
        });

    }

    public function ebooks(): HasMany
    {
        return $this->hasMany(Ebook::class, 'category_id');
    }

    public function pub_books(): HasManyThrough
    {
        return $this->hasManyThrough(PublisherEbook::class, Ebook::class,'category_id','book_id');
    }
    
}
