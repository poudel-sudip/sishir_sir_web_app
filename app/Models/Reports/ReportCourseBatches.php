<?php

namespace App\Models\Reports;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportCourseBatches extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class,'course');
    }
}
