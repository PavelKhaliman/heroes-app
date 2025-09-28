<?php

namespace App\Http\Controllers\Public\Clan\Info;

use App\Http\Controllers\Controller;
use App\Models\Clan as ClanModel;
use Illuminate\Contracts\View\View;

class PublicInfoController extends Controller
{
    public function index(): View
    {
        $clan = ClanModel::query()
            ->select(['id', 'info', 'regulation'])
            ->latest('id')
            ->first();

        return view('clan.info.index', compact('clan'));
    }
}


