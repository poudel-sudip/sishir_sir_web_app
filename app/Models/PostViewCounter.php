<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostViewCounter extends Model
{
    use HasFactory;
    // protected $guarded = [];
    protected $fillable = ['title', 'url', 'view_count'];

    public static function getTotalViewCount()
    {
        return self::sum('view_count');
    }
}
