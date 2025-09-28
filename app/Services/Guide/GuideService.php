<?php

namespace App\Services\Guide;

use App\Models\Guide;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class GuideService
{
    public function paginateByKind(string $kind, int $perPage = 12): LengthAwarePaginator
    {
        return Guide::query()
            ->where('kind', $kind)
            ->with('user')
            ->withCount(['likes','comments'])
            ->latest('id')
            ->paginate($perPage);
    }

    public function create(array $data, string $kind): Guide
    {
        $userId = Auth::id();
        if (!$userId) abort(403);

        $imagePath = null;
        if (!empty($data['image'])) {
            $imagePath = $data['image']->store('guides', 'public');
        }

        return Guide::create([
            'title' => $data['title'],
            'excerpt' => $data['excerpt'] ?? null,
            'body' => $data['body'],
            'image_path' => $imagePath,
            'kind' => $kind,
            'user_id' => $userId,
        ]);
    }

    public function prepareShow(Guide $guide): Guide
    {
        $guide->load('user','comments.user')
              ->loadCount(['likes','comments']);
        return $guide;
    }

    public function authorizeManage(Guide $guide): void
    {
        $user = Auth::user();
        if (!$user || ($user->id !== $guide->user_id && $user->role !== 'admin')) abort(403);
    }

    public function update(Guide $guide, array $data): Guide
    {
        $this->authorizeManage($guide);
        if (!empty($data['image'])) {
            $guide->image_path = $data['image']->store('guides', 'public');
        }
        $guide->title = $data['title'];
        $guide->excerpt = $data['excerpt'] ?? $guide->excerpt;
        $guide->body = $data['body'];
        $guide->save();
        return $guide;
    }

    public function delete(Guide $guide): void
    {
        $this->authorizeManage($guide);
        $guide->delete();
    }
}


