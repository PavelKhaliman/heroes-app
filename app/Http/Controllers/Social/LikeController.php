<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\Guide;
use App\Models\Like;
use App\Models\Photo;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Social\ToggleLikeRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\Social\LikeService;

class LikeController extends Controller
{
    public function __construct(private readonly LikeService $likes) {}

    public function toggle(ToggleLikeRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $this->likes->toggle($data['type'], (int)$data['id']);
        return redirect($data['redirect'] ?? url()->previous());
    }
}


