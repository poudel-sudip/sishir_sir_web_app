<?php

namespace App\Models\Exams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Batch;
use App\Models\Exams\WrittenExamSolution;

class WrittenExam extends Model
{
    use HasFactory;
    protected $guarded=[];

    
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

   
    public function solutions(): HasMany
    {
        return $this->hasMany(WrittenExamSolution::class, 'exam_id');
    }

}
