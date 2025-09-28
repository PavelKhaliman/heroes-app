<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Services\Social\CommentService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Social\StoreCommentRequest;
use App\Http\Requests\Social\UpdateCommentRequest;
use Illuminate\Http\Request;


class CommentController extends Controller
{
    public function __construct(private readonly CommentService $commentsService) {}
    public function store(StoreCommentRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $this->commentsService->store($data['type'], (int)$data['id'], $data['body']);

        return redirect($data['redirect'] ?? url()->previous());
    }

    public function update(UpdateCommentRequest $request, Comment $comment): RedirectResponse
    {
        $data = $request->validated();

        $this->commentsService->update($comment, $data['body']);

        return redirect($data['redirect'] ?? url()->previous());
    }

    public function destroy(Request $request, Comment $comment): RedirectResponse
    {
        $redirect = $request->input('redirect', url()->previous());
        $this->commentsService->delete($comment);
        return redirect($redirect);
    }
}


