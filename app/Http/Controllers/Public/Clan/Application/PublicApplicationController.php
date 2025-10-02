<?php

namespace App\Http\Controllers\Public\Clan\Application;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Clan\StoreRequest;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;


class PublicApplicationController extends Controller
{
    public function create(): View|RedirectResponse
    {
        $user = Auth::user();
        if ($user && in_array($user->role, ['member','moderator','admin'], true)) {
            return redirect()->route('member.applications.index');
        }
        return view('clan.application.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $user = Auth::user();
        if ($user && in_array($user->role, ['member','moderator','admin'], true)) {
            return redirect()->route('member.applications.index');
        }

        $data = $request->validated();
        $data['status'] = 'new';
        Application::create($data);

        return redirect()->route('clan.application')->with('success', 'Заявка отправлена');
    }
}