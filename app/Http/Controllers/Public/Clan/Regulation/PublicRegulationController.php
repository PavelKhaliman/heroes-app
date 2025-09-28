<?php

namespace App\Http\Controllers\Public\Clan\Regulation;

use App\Http\Controllers\Controller;
use App\Models\Clan;
use Illuminate\Contracts\View\View;

class PublicRegulationController extends Controller
{
    public function index(): View
    {
        $clan = Clan::query()
            ->select(['id', 'info', 'regulation'])
            ->latest('id')
            ->first();

        return view('clan.regulation.index', compact('clan'));
    }
}


