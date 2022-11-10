<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Vendors\Vendor;
use App\Models\Teams\TeamAssignVendorForm;

class VendorForm extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function($form) {

            $slug = Str::slug($form->title);
            $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
            $form->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(VendorFormApplicant::class, 'form_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(VendorFormGroup::class, 'group_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function assignedTeams(): HasMany
    {
        return $this->hasMany(TeamAssignVendorForm::class, 'form_id');
    }  
}
