<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        return view('pages.about');
    }

    public function help(): View
    {
        return view('pages.help');
    }

    public function privacy(): View
    {
        return view('pages.privacy');
    }

    public function terms(): View
    {
        return view('pages.terms');
    }

    public function contact(): View
    {
        return view('pages.contact');
    }

    public function storeContact(ContactRequest $request): RedirectResponse
    {
        ContactMessage::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        return back()->with('success', 'Pesan Anda telah terkirim. Kami akan segera merespons.');
    }
}
