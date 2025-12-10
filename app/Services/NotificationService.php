<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    public static function send($userId, $type, $message, $link = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'message' => $message,
            'link' => $link,
        ]);
    }
}
