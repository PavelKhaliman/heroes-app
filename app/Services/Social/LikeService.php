<?php

namespace App\Services\Social;

use App\Models\Guide;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class LikeService
{
    public function toggle(string $type, int $id): void
    {
        $userId = Auth::id();
        if (!$userId) abort(403);

        $likeable = $type === 'guide' ? Guide::findOrFail($id) : Photo::findOrFail($id);
        $existing = $likeable->likes()->where('user_id', $userId)->first();
        if ($existing) {
            $existing->delete();
        } else {
            $likeable->likes()->create(['user_id' => $userId]);
        }
    }
}


