<?php

namespace App\Services\Gallery;

use App\Models\Photo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PhotoService
{
    public function paginateByKind(string $kind, int $perPage = 12): LengthAwarePaginator
    {
        return Photo::query()
            ->where('kind', $kind)
            ->with('user')
            ->withCount(['likes','comments'])
            ->latest('id')
            ->paginate($perPage);
    }

    public function create(string $title, string $description = null, $imageFile = null, string $kind = 'photo'): Model
    {
        $userId = Auth::id();
        if (!$userId) {
            abort(403);
        }

        $path = $imageFile ? $imageFile->store('photos', 'public') : null;

        return Photo::query()->create([
            'title' => $title,
            'image_path' => $path,
            'description' => $description,
            'user_id' => $userId,
            'kind' => $kind,
        ]);
    }

    public function prepareShow(Photo $photo): Photo
    {
        $photo->load('user','comments.user')
              ->loadCount(['likes','comments']);
        return $photo;
    }

    public function authorizeManage(Photo $photo): void
    {
        $user = Auth::user();
        if (!$user || ($user->id !== $photo->user_id && $user->role !== 'admin')) {
            abort(403);
        }
    }

    public function update(Photo $photo, string $title, ?string $description = null, $imageFile = null): Photo
    {
        $this->authorizeManage($photo);
        if ($imageFile) {
            $photo->image_path = $imageFile->store('photos', 'public');
        }
        $photo->title = $title;
        if ($description !== null) {
            $photo->description = $description;
        }
        $photo->save();
        return $photo;
    }

    public function delete(Photo $photo): void
    {
        $this->authorizeManage($photo);
        $photo->delete();
    }
}


