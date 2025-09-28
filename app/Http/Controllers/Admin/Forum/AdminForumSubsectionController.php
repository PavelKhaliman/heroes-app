<?php

namespace App\Http\Controllers\Admin\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\StoreSubsectionRequest;
use App\Http\Requests\Forum\UpdateSubsectionRequest;
use App\Models\ForumSection;
use App\Models\ForumSubsection;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminForumSubsectionController extends Controller
{
    public function create(ForumSection $section): View
    {
        return view('admin.forum.subsections.create', compact('section'));
    }

    public function store(StoreSubsectionRequest $request, ForumSection $section): RedirectResponse
    {
        $section->subsections()->create($request->validated());
        return redirect()->route('admin.forum.sections.index');
    }

    public function edit(ForumSection $section, ForumSubsection $subsection): View
    {
        return view('admin.forum.subsections.edit', compact('section','subsection'));
    }

    public function update(UpdateSubsectionRequest $request, ForumSection $section, ForumSubsection $subsection): RedirectResponse
    {
        $subsection->update($request->validated());
        return redirect()->route('admin.forum.sections.index');
    }

    public function destroy(ForumSection $section, ForumSubsection $subsection): RedirectResponse
    {
        $subsection->delete();
        return redirect()->route('admin.forum.sections.index');
    }
}


