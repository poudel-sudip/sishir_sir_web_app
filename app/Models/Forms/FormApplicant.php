<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormApplicant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function form(): BelongsTo
    {
        return $this->belongsTo(DynamicForm::class, 'form_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DynamicFormCategory::class, 'category_id');
    }
}
