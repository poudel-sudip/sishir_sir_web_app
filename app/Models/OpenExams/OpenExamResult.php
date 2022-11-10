<?php

namespace App\Models\OpenExams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenExamResult extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    public function exam(): BelongsTo
    {
        return $this->belongsTo(OpenExam::class, 'exam_id');
    }
}
