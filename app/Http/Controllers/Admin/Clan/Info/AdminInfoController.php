<?php

namespace App\Http\Controllers\Admin\Clan\Info;

use App\Http\Controllers\Controller;
use App\Models\Clan;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Clan\Info\StoreRequest;


class AdminInfoController extends Controller
{
    public function index(): View
    {
        $clan = Clan::query()
            ->select(['id', 'info', 'regulation'])
            ->latest('id')
            ->first();

        return view('admin.clan.info.index', compact('clan'));
    }

    public function create(): View
    {
        $clan = Clan::query()
            ->select(['id', 'info', 'regulation'])
            ->latest('id')
            ->first();

        return view('admin.clan.info.create', compact('clan'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $latestId = Clan::query()->latest('id')->value('id');

        Clan::query()->updateOrCreate(
            ['id' => $latestId],
            [
                'info' => $data['info'],
                'regulation' => $data['info'],
            ]
        );

        return redirect()->route('admin.clan.info.index');
    }
}