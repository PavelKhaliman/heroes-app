<?php

namespace App\Http\Controllers\Admin\Clan\Application;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;


class AdminApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $sort = $request->string('sort')->toString();
        $dir = strtolower($request->string('dir')->toString()) === 'asc' ? 'asc' : 'desc';

        $query = Application::query();

        if ($sort === 'status') {
            $caseOrder = "CASE status WHEN 'new' THEN 1 WHEN 'pending' THEN 2 WHEN 'accepted' THEN 3 WHEN 'rejected' THEN 4 ELSE 5 END";
            $query->orderByRaw($caseOrder . ' ' . ($dir === 'desc' ? 'DESC' : 'ASC'));
            $query->latest('id');
        } else {
            $query->latest('id');
        }

        $applications = $query->get();

        return view('admin.clan.application.index', compact('applications'));
    }

    public function show(Application $application): View
    {
        

        return view('admin.clan.application.show', compact('application'));
    }
    
    public function delete(Application $application): RedirectResponse
    {
        $application->delete();

        
        return redirect()->route('admin.clan.application.index');
    }

    public function update(Request $request, Application $application): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:accepted,rejected,pending,new',
        ]);

        $application->update(['status' => $validated['status']]);

        return redirect()
            ->route('admin.clan.application.show', $application)
            ->with('success', 'Статус обновлён');
    }
}