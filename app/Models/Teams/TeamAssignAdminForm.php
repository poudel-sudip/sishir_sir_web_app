<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Teams\Team;
use App\Models\Forms\DynamicForm;
use App\Models\Forms\DynamicFormCategory;

class TeamAssignAdminForm extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(DynamicForm::class, 'form_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(DynamicFormCategory::class, 'category_id');
    }
}
