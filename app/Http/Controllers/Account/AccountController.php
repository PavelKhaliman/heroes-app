<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Account\UpdateAvatarRequest;
use App\Http\Requests\Account\UpdateProfileRequest;
use App\Http\Requests\Account\UpdatePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }
        $notifications = $user->notifications()->latest('id')->limit(20)->get();
        $comments = Comment::query()
            ->where('user_id', $user->id)
            ->latest('id')
            ->paginate(4);

        $photos = $user->photos()->latest('id')->paginate(9);

        return view('account.index', compact('user', 'notifications', 'comments', 'photos'));
    }

    public function updateProfile(UpdateProfileRequest $request): RedirectResponse
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }
        $validated = $request->validated();
        $user->update($validated);
        return back()->with('success', 'Профиль обновлен');
    }

    public function updateAvatar(UpdateAvatarRequest $request): RedirectResponse
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        if ($user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar_path' => $path]);

        return back()->with('success', 'Аватар обновлен');
    }

    public function updatePassword(UpdatePasswordRequest $request): RedirectResponse
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }
        $user->password = bcrypt($request->input('password'));
        $user->save();
        return back()->with('success', 'Пароль обновлен');
    }

    public function markNotificationRead(int $id): RedirectResponse
    {
        /** @var User|null $user */
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }
        $notification = $user->notifications()->where('id', $id)->firstOrFail();
        $notification->update(['read_at' => now()]);
        return back();
    }
}


