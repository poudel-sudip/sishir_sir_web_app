<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTicket extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(UserTicketContent::class, 'ticket_id');
    }

    public function unreadCount()
    {
        return $this->contents()->where('read','=',0)->count();
    }

    public function adminUnreadCount()
    {
        return $this->contents()
        ->where('read','=',0)
        ->where('user_id','=',$this->user_id)
        ->count();
    }

    public function userUnreadCount()
    {
        return $this->contents()
        ->where('read','=',0)
        ->where('user_id','!=',$this->user_id)
        ->count();
    }
}
