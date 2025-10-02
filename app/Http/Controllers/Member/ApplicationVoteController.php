<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\ApplicationVote;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationVoteController extends Controller
{
    public function index(): View
    {
        $applications = Application::whereIn('status', ['new','pending'])
            ->with(['votes.user'])
            ->latest('id')
            ->get();

        $userId = Auth::id();
        $userVotes = ApplicationVote::where('user_id', $userId)
            ->pluck('vote', 'application_id');

        return view('member.application.index', compact('applications','userVotes'));
    }

    public function vote(Request $request, Application $application): RedirectResponse
    {
        $validated = $request->validate([
            'vote' => 'required|in:for,against',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }
        if (!in_array($user->role, ['member','moderator','admin'], true)) {
            abort(403);
        }

        $record = ApplicationVote::updateOrCreate(
            ['application_id' => $application->id, 'user_id' => $user->id],
            ['vote' => $validated['vote']]
        );

        $application->recalcTallies();

        return redirect()->route('member.applications.index')->with('success', 'Голос учтён');
    }
}
