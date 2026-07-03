<?php

namespace App\Http\Controllers;

use App\Models\UserNotification;
use Illuminate\Http\RedirectResponse;

class NotificationController extends Controller
{
    public function markRead(UserNotification $notification): RedirectResponse
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->update(['is_read' => true]);

        return back();
    }

    public function markAllRead(): RedirectResponse
    {
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return back();
    }
}
