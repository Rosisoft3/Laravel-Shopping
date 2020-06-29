<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) 
    { 
        $notifications = $request->user()->unreadNotifications()->get();
        $newUsers = 0;
        $newOrders = 0;
        foreach($notifications as $notification) {
            if($notification->type === 'App\Notifications\NewUser') {
                ++$newUsers;
            } elseif($notification->type === 'App\Notifications\NewOrder'){
                ++$newOrders;
            }
        }       

        return view('back.index', compact('notifications', 'newUsers', 'newOrders'));
    }

    /**
     * Unread notifications
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $type
     * @return \Illuminate\Http\Response
     */
    public function read(Request $request, $type) 
    { 
        if($type === 'orders') {
            $type = 'App\Notifications\NewOrder';
        } else if($type === 'users') {
            $type = 'App\Notifications\NewUser';
        }

        $request->user()->unreadNotifications->where('type', $type)->markAsRead();

        return redirect(route('admin'));
    } 
}
