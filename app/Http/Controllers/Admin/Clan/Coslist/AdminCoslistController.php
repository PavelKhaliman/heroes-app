<?php

namespace App\Http\Controllers\Admin\Clan\Coslist;

use App\Http\Controllers\Controller;
use App\Models\Coslist;
use App\Http\Requests\Admin\Clan\Coslist\StoreGuildRequest;
use App\Http\Requests\Admin\Clan\Coslist\StorePersonalRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Clan\Coslist\StoreRequest;


class AdminCoslistController extends Controller
{
    public function index(): View
    {
        $coslists = Coslist::query()
            ->select(['id', 'nicname', 'guild', 'master', 'reason', 'repayment'])
            ->latest('id')
            ->get();

        return view('admin.clan.coslist.index', compact('coslists'));
    }

    public function createPersonal(): View
    {
        return view('admin.clan.coslist.createPersonal');
    }

    public function createGuild(): View
    {
        return view('admin.clan.coslist.createGuild');
    }

    public function storePersonal(StorePersonalRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Coslist::query()->create([
            'nicname' => $validated['nicname'],
            'guild' => $validated['guild'],
            'master' => '-',
            'reason' => $validated['reason'],
            'repayment' => $validated['repayment'],
        ]);

        return redirect()->route('admin.clan.coslist.index');
    }

    public function storeGuild(StoreGuildRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Coslist::query()->create([
            'nicname' => '-',
            'guild' => $validated['guild'],
            'master' => $validated['master'],
            'reason' => $validated['reason'],
            'repayment' => $validated['repayment'],
        ]);

        return redirect()->route('admin.clan.coslist.index');
    }

    public function delete(Coslist $coslist): RedirectResponse
    {
        $coslist->delete();

        
        return redirect()->route('admin.clan.coslist.index');
    }
}