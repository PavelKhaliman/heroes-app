<?php

namespace App\Http\Controllers\User\Guide;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Guide\StoreGuideRequest;
use App\Http\Requests\Guide\UpdateGuideRequest;
use App\Services\Guide\GuideService;
use Illuminate\Support\Facades\Auth;

class UserGuideController extends Controller
{
    public function __construct(private readonly GuideService $guides) {}
    public function index(string $kind): View
    {
        $guides = $this->guides->paginateByKind($kind, 12);
        return view("guide.$kind.index", compact('guides','kind'));
    }

    public function create(string $kind): View
    {
        return view("guide.$kind.create", compact('kind'));
    }

    public function store(StoreGuideRequest $request, string $kind): RedirectResponse
    {
        $validated = $request->validated();

        $this->guides->create($validated, $kind);

        return redirect()->route("guide.$kind.index");
    }

    public function show(Guide $guide, string $kind): View
    {
        abort_unless($guide->kind === $kind, 404);
        $guide = $this->guides->prepareShow($guide);
        return view("guide.$kind.show", compact('guide','kind'));
    }

    public function edit(Guide $guide, string $kind): View
    {
        abort_unless($guide->kind === $kind, 404);
        $this->guides->authorizeManage($guide);
        return view("guide.$kind.edit", compact('guide','kind'));
    }

    public function update(UpdateGuideRequest $request, Guide $guide, string $kind): RedirectResponse
    {
        abort_unless($guide->kind === $kind, 404);
        $validated = $request->validated();
        $this->guides->update($guide, $validated);
        return redirect()->route("guide.$kind.show", $guide);
    }

    public function destroy(Guide $guide, string $kind): RedirectResponse
    {
        abort_unless($guide->kind === $kind, 404);
        $this->guides->delete($guide);
        return redirect()->route("guide.$kind.index");
    }
}


