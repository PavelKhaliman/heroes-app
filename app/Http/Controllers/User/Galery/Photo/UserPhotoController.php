<?php

namespace App\Http\Controllers\User\Galery\Photo;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Gallery\Photo\StorePhotoRequest;
use App\Http\Requests\Gallery\Photo\UpdatePhotoRequest;
use App\Services\Gallery\PhotoService;
use Illuminate\Support\Facades\Auth;

class UserPhotoController extends Controller
{
    public function __construct(private readonly PhotoService $photos) {}
    private const KIND = 'photo';
    public function index(): View
    {
        $photos = $this->photos->paginateByKind(self::KIND, 12);

        return view('gallery.photo.index', compact('photos'));
    }

    public function create(): View
    {
        return view('gallery.photo.create');
    }

    public function store(StorePhotoRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        // Prevent duplicate submissions
        $request->session()->put('photo.store.in_progress', true);

        $this->photos->create($validated['title'], $validated['description'] ?? null, $request->file('image'), self::KIND);

        // Clear in-progress flag
        $request->session()->forget('photo.store.in_progress');

        return redirect()->route('gallery.photo.index');
    }

    public function show(Photo $photo): View
    {
        abort_unless($photo->kind === self::KIND, 404);
        $photo = $this->photos->prepareShow($photo);
        return view('gallery.photo.show', compact('photo'));
    }

    public function edit(Photo $photo): View
    {
        $this->photos->authorizeManage($photo);

        return view('gallery.photo.edit', compact('photo'));
    }

    public function update(UpdatePhotoRequest $request, Photo $photo): RedirectResponse
    {
        $validated = $request->validated();

        $user = Auth::user();
        if (!$user || ($user->id !== $photo->user_id && $user->role !== 'admin')) {
            abort(403);
        }

        $this->photos->update($photo, $validated['title'], $validated['description'] ?? null, $request->file('image'));

        return redirect()->route('gallery.photo.show', $photo);
    }

    public function destroy(Photo $photo): RedirectResponse
    {
        $this->photos->delete($photo);
        return redirect()->route('gallery.photo.index');
    }
}