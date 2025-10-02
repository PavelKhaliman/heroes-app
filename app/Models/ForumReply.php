<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_subsection_id',
        'user_id',
        'title',
        'body',
        'pinned',
    ];

    public function subsection(): BelongsTo
    {
        return $this->belongsTo(ForumSubsection::class, 'forum_subsection_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ForumReplyAttachment::class);
    }

    public function scopePinnedFirst($query)
    {
        return $query->orderByDesc('pinned')->latest('id');
    }
}


