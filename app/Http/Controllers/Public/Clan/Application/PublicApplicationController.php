<?php

namespace App\Http\Controllers\Public\Clan\Application;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Clan\StoreRequest;
use App\Models\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Exceptions\ThrottleRequestsException;


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

        // Cooldown: prevent same IP or nickname from spamming
        $ip = (string) $request->ip();
        $nick = strtolower(trim((string) ($data['nic_name'] ?? '')));
        $cooldownKeyIp = "app_submit_ip:".$ip;
        $cooldownKeyNick = "app_submit_nick:".$nick;
        $ttl = now()->addMinutes(10);

        if (Cache::has($cooldownKeyIp) || ($nick !== '' && Cache::has($cooldownKeyNick))) {
            throw new ThrottleRequestsException('Слишком часто. Повторите попытку позже.');
        }
        $data['status'] = 'new';
        Application::create($data);

        Cache::put($cooldownKeyIp, 1, $ttl);
        if ($nick !== '') {
            Cache::put($cooldownKeyNick, 1, $ttl);
        }

        return redirect()->route('clan.application')->with('success', 'Заявка отправлена');
    }
}