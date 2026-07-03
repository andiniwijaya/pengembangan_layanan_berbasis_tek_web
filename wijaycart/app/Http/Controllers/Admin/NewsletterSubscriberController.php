<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsletterSubscriberController extends Controller
{
    public function index(Request $request): View
    {
        $query = NewsletterSubscriber::query()->latest('subscribed_at');

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        if ($request->filled('search')) {
            $query->where('email', 'like', '%'.$request->search.'%');
        }

        $subscribers = $query->paginate(10)->withQueryString();

        $stats = [
            'total' => NewsletterSubscriber::count(),
            'active' => NewsletterSubscriber::where('is_active', true)->count(),
            'inactive' => NewsletterSubscriber::where('is_active', false)->count(),
        ];

        return view('admin.newsletters.index', compact('subscribers', 'stats'));
    }
}
