<?php

namespace App\Models\Assignments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Batch;
use App\Models\Assignments\AssignmentAnswer;

class Assignment extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    
    public function answers(): HasMany
    {
        return $this->hasMany(AssignmentAnswer::class, 'assignment_id');
    }
}
