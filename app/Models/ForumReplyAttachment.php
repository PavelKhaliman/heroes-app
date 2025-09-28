<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ForumReplyAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_reply_id',
        'path',
        'original_name',
    ];

    public function reply(): BelongsTo
    {
        return $this->belongsTo(ForumReply::class, 'forum_reply_id');
    }
}


