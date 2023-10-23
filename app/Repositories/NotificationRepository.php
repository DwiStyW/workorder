<?php

namespace App\Repositories;

use App\Models\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class NotificationRepository
{
    public function getNotif(int $receiver_id)
    {
        return Notification::where('receiver_id',$receiver_id)
            ->whereNull('read_at')
            ->orderByDesc('id','DESC')
            ->get();
    }

    public function sendNotif(array $data):Notification
    {
        return Notification::create($data);
    }
}