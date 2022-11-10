<?php

namespace App\Models\Reports;

use App\Models\Batch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportBooking extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function mybatch(): BelongsTo
    {
        return $this->belongsTo(Batch::class,'batch_id');
    }
}
