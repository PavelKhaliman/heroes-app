<?php

namespace App\Http\Controllers\Public\Clan\Application;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Clan\StoreRequest;
use App\Models\Application;


class PublicApplicationController extends Controller
{
    public function create(): View
    {
        return view('clan.application.create');
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['status'] = 'new';

        Application::create($data);

        return redirect()->route('clan.application')->with('success', 'Заявка отправлена');
    }
}