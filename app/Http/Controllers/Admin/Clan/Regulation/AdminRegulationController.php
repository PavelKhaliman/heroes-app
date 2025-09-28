<?php

namespace App\Http\Controllers\Admin\Clan\Regulation;

use App\Http\Controllers\Controller;
use App\Models\Clan;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Requests\Admin\Clan\Regulation\StoreRequest;
use Illuminate\Http\RedirectResponse;


class AdminRegulationController extends Controller
{
    public function index(): View
    {
        $clan = Clan::query()
            ->select(['id', 'info', 'regulation'])
            ->latest('id')
            ->first();

        return view('admin.clan.regulation.index', compact('clan'));
    }

    public function create(): View
    {
        $clan = Clan::query()
            ->select(['id', 'info', 'regulation'])
            ->latest('id')
            ->first();

        return view('admin.clan.regulation.create', compact('clan'));
    }

    public function store(StoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $latestId = Clan::query()->latest('id')->value('id');

        Clan::query()->updateOrCreate(
            ['id' => $latestId],
            [
                'regulation' => $data['regulation'],
            ]
        );

        return redirect()->route('admin.clan.regulation.index');
    }
}