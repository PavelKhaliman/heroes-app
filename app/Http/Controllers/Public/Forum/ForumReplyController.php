<?php

namespace App\Http\Controllers\Public\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\StoreReplyRequest;
use App\Http\Requests\Forum\UpdateReplyRequest;
use App\Models\ForumReply;
use App\Models\ForumSubsection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ForumReplyController extends Controller
{
    public function store(StoreReplyRequest $request, string $sectionSlug, string $subSlug): RedirectResponse
    {
        $subsection = ForumSubsection::whereHas('section', fn($q) => $q->where('slug', $sectionSlug))
            ->where('slug', $subSlug)
            ->firstOrFail();

        $reply = $subsection->replies()->create([
            'user_id' => Auth::id(),
            'title' => $request->string('title'),
            'body' => $request->string('body'),
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('forum/replies', 'public');
                $reply->attachments()->create([
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('forum.subsection', [$sectionSlug, $subSlug]);
    }

    public function update(UpdateReplyRequest $request, string $sectionSlug, string $subSlug, ForumReply $reply): RedirectResponse
    {
        $this->authorizeAction($reply);
        $reply->update($request->only(['title','body']));

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('forum/replies', 'public');
                $reply->attachments()->create([
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        return redirect()->route('forum.subsection', [$sectionSlug, $subSlug]);
    }

    public function destroy(string $sectionSlug, string $subSlug, ForumReply $reply): RedirectResponse
    {
        $this->authorizeAction($reply);
        foreach ($reply->attachments as $att) {
            Storage::disk('public')->delete($att->path);
        }
        $reply->delete();
        return redirect()->route('forum.subsection', [$sectionSlug, $subSlug]);
    }

    private function authorizeAction(ForumReply $reply): void
    {
        $user = Auth::user();
        abort_unless($user && ($user->id === $reply->user_id || $user->role === 'admin'), 403);
    }
}


