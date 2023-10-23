<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NotificationRepository;


class DashboardController extends Controller
{
    public function __construct(private NotificationRepository $notif){
        $this->notif=$notif;
    }

    public function index(Request $request)
    {
        $notif=$this->notif->getNotif((int) $request->user()->id);

        return view('dashboard.dashboard',compact('notif'));
    }
}