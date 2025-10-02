<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ForumSubsection extends Model
{
    use HasFactory;

    protected $fillable = [
        'forum_section_id',
        'title',
        'slug',
        'description',
        'position',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(ForumSection::class, 'forum_section_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(ForumReply::class)->orderByDesc('pinned')->latest();
    }
}


