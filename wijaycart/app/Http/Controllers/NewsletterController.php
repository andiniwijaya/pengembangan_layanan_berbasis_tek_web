<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscribeRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class NewsletterController extends Controller
{
    public function subscribe(NewsletterSubscribeRequest $request): RedirectResponse
    {
        NewsletterSubscriber::subscribe($request->email);

        return back()->with('success', 'Terima kasih! Anda berhasil berlangganan newsletter.');
    }

    public function unsubscribe(string $token): View|RedirectResponse
    {
        $subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->firstOrFail();

        $subscriber->update(['is_active' => false]);

        return redirect()->route('home')->with('success', 'Anda telah berhenti berlangganan newsletter.');
    }
}
