<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TutorPostComment;

class TutorPost extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function tutor(): BelongsTo
    {
        return $this->belongsTo(Tutor::class, 'tutor_id');
    }

    public function incrementReadCount() {
        $this->views++;
        return $this->save();
    }

    public function likes(): HasMany
    {
        return $this->hasMany(TutorPostLikes::class, 'post_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(TutorPostComment::class, 'post_id')->orderByDesc('created_at');
    }
}
