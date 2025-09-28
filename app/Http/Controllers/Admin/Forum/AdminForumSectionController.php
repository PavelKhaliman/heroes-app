<?php

namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\StoreSectionRequest;
use App\Http\Requests\Forum\UpdateSectionRequest;
use App\Models\ForumSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminForumSectionController extends Controller
{
    public function index(): View
    {
        $sections = ForumSection::with('subsections')->orderBy('position')->get();
        return view('admin.forum.sections.index', compact('sections'));
    }

    public function create(): View
    {
        return view('admin.forum.sections.create');
    }

    public function store(StoreSectionRequest $request): RedirectResponse
    {
        ForumSection::create($request->validated());
        return redirect()->route('admin.forum.sections.index');
    }

    public function edit(ForumSection $section): View
    {
        return view('admin.forum.sections.edit', compact('section'));
    }

    public function update(UpdateSectionRequest $request, ForumSection $section): RedirectResponse
    {
        $section->update($request->validated());
        return redirect()->route('admin.forum.sections.index');
    }

    public function destroy(ForumSection $section): RedirectResponse
    {
        $section->delete();
        return redirect()->route('admin.forum.sections.index');
    }
}


