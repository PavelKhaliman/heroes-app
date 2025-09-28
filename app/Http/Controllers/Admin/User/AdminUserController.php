<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->select(['id','nickname','name','role'])
            ->orderBy('id','desc')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        // Moderators cannot change admin users
        if ($request->user() && $request->user()->isModerator() && $user->isAdmin()) {
            abort(403);
        }
        $actor = $request->user();
        if (!$actor || (!$actor->isAdmin() && !$actor->isModerator())) {
            abort(403);
        }

        $allowedRoles = $actor->isAdmin() ? 'admin,moderator,member,authorized' : 'moderator,member,authorized';

        $data = $request->validate([
            'role' => ["required","in:$allowedRoles"],
        ]);

        $user->role = $data['role'];
        $user->save();

        return redirect()->route('admin.users.show', $user)->with('success','Роль обновлена');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        // Moderators cannot delete admin users
        if ($request->user() && $request->user()->isModerator() && $user->isAdmin()) {
            abort(403);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success','Пользователь удалён');
    }
}


