<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassDiscussion extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function batch(): BelongsTo
    {
        return$this->belongsTo(Batch::class);
    }


}
