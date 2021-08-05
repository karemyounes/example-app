<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Notifications\Offer;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{

    use Notifiable;

    public function getuser()
    {
        $user = User::get();
        //$user->notify(new Offer());
        Notification::send($user, new Offer());
    }
}
