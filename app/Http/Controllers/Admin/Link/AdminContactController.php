<?php

namespace App\Http\Controllers\Admin\Link;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function index(): View
    {
        $contact = Contact::query()->latest('id')->first();
        return view('admin.link.index', compact('contact'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'telegram' => ['nullable','string','max:255'],
            'teamspeak' => ['nullable','string','max:255'],
            'officers' => ['nullable','string'],
        ]);

        $latestId = Contact::query()->latest('id')->value('id');
        Contact::query()->updateOrCreate(
            ['id' => $latestId],
            $data
        );

        return redirect()->route('admin.link.index');
    }
}


