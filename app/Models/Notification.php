<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable=[
        'sender_id',
        'receiver_id',
        'type',
        'notifiable_type',
        'notifiable_id',
        'data',
        'read_at',
    ];
}