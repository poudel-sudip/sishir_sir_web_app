<?php

namespace App\Models\Provience;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Provience\DistrictCity;

class Provience extends Model
{
    use HasFactory;
    protected $guarded = [];
    
    public function cities(): HasMany
    {
        return $this->hasMany(DistrictCity::class, 'provience_id')->orderBy('name');
    }
}
