<?php

namespace App\Http\Controllers\Public\Clan\Coslist;

use App\Http\Controllers\Controller;
use App\Models\Coslist;
use Illuminate\Contracts\View\View;

class PublicCoslistController extends Controller
{
    public function index(): View
    {
        $coslists = Coslist::query()
            ->select(['id', 'nicname', 'guild', 'master', 'reason', 'repayment'])
            ->latest('id')
            ->get();

        return view('clan.coslist.coslist', compact('coslists'));
    }
}


