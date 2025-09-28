<?php

namespace App\Http\Controllers\User\Galery\Other;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOtherController extends Controller
{
    private const KIND = 'other';

    public function index(): View
    {
        $photos = Photo::query()
            ->where('kind', self::KIND)
            ->with('user')
            ->latest('id')
            ->paginate(12);

        return view('gallery.other.index', compact('photos'));
    }

    public function create(): View
    {
        return view('gallery.other.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:5120'],
            'description' => ['nullable', 'string'],
        ]);

        $userId = Auth::id();
        if (!$userId) {
            abort(403);
        }

        $path = $request->file('image')->store('photos', 'public');

        Photo::query()->create([
            'title' => $validated['title'],
            'image_path' => $path,
            'description' => $validated['description'] ?? null,
            'user_id' => $userId,
            'kind' => self::KIND,
        ]);

        return redirect()->route('gallery.other.index');
    }

    public function show(Photo $photo): View
    {
        abort_unless($photo->kind === self::KIND, 404);
        $photo->load('user');
        return view('gallery.other.show', compact('photo'));
    }

    public function edit(Photo $photo): View
    {
        abort_unless($photo->kind === self::KIND, 404);
        $user = Auth::user();
        if (!$user || ($user->id !== $photo->user_id && $user->role !== 'admin')) {
            abort(403);
        }

        return view('gallery.other.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo): RedirectResponse
    {
        abort_unless($photo->kind === self::KIND, 404);
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
            'description' => ['nullable', 'string'],
        ]);

        $user = Auth::user();
        if (!$user || ($user->id !== $photo->user_id && $user->role !== 'admin')) {
            abort(403);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('photos', 'public');
            $photo->image_path = $path;
        }

        $photo->title = $validated['title'];
        $photo->description = $validated['description'] ?? $photo->description;
        $photo->save();

        return redirect()->route('gallery.other.show', $photo);
    }

    public function destroy(Photo $photo): RedirectResponse
    {
        abort_unless($photo->kind === self::KIND, 404);
        $user = Auth::user();
        if (!$user || ($user->id !== $photo->user_id && $user->role !== 'admin')) {
            abort(403);
        }

        $photo->delete();
        return redirect()->route('gallery.other.index');
    }
}


