<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->read = true;
        $notification->save();

        return redirect($notification->link);
    }

    public function markAllRead()
{
    auth()->user()->notifications()
        ->where('read', false)
        ->update(['read' => true]);

    return redirect()->back()->with('success', 'All notifications marked as read.');
}

}
