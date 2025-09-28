<?php

namespace App\Http\Controllers\Public\Forum;

use App\Http\Controllers\Controller;
use App\Models\ForumSection;
use App\Models\ForumSubsection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicForumController extends Controller
{
    public function index(): View
    {
        $sections = ForumSection::with('subsections')->orderBy('position')->get();
        return view('forum.index', compact('sections'));
    }

    public function subsection(string $sectionSlug, string $subSlug): View
    {
        $section = ForumSection::where('slug', $sectionSlug)->firstOrFail();
        $subsection = ForumSubsection::where('forum_section_id', $section->id)
            ->where('slug', $subSlug)
            ->firstOrFail();
        $subsection->load(['section','replies.user','replies.attachments']);
        return view('forum.subsection', compact('section','subsection'));
    }
}


