<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class StudentTutorChat extends Model
{
    use HasFactory;
    protected $guarded=[];

    
    public function from_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'from');
    }

    public function to_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'to');
    }
}
