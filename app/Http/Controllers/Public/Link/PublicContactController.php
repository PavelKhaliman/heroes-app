<?php

namespace App\Http\Controllers\Public\Link;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\View\View;

class PublicContactController extends Controller
{
    public function index(): View
    {
        $contact = Contact::query()->latest('id')->first();
        return view('link.index', compact('contact'));
    }
}


