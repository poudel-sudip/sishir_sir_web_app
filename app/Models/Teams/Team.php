<?php

namespace App\Models\Teams;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Vendors\Vendor;
use App\Models\ManualBooking;

class Team extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function manualBookings(): HasMany
    {
        return $this->hasMany(ManualBooking::class, 'team_id');
    }

    public function followupRegisteredUsers(): HasMany
    {
        return $this->hasMany(TeamFollowupRegisteredUser::class, 'team_id');
    }

    public function assignedAdminForms(): HasMany
    {
        return $this->hasMany(TeamAssignAdminForm::class, 'team_id');
    }

    public function followupAdminForms(): HasMany
    {
        return $this->hasMany(TeamFollowupAdminForm::class, 'team_id');
    }

    public function assignedVendorForms(): HasMany
    {
        return $this->hasMany(TeamAssignVendorForm::class, 'team_id');
    }

    public function followupVendorForms(): HasMany
    {
        return $this->hasMany(TeamFollowupVendorForm::class, 'team_id');
    }
}
