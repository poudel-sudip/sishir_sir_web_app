<?php

namespace App\Models\Reports;

use App\Models\Batch;
use App\Models\Tutor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use function Symfony\Component\Translation\t;

class ReportTutorBatches extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function mytutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class,'tutor');
    }

    public function mybatch(): BelongsTo
    {
        return $this->belongsTo(Batch::class,'batch');
    }
}
