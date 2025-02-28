<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:other_systemNotifications')->only('showSystemNotifications');
    }

    public function showUserNotification()
    {
        $page_option = ['main' => 'dash', 'sub' => 'dash'];
        $page_name = "User Notifications";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '#'],
            ['name' => 'Dashboard', 'url' => '#'],
        ];

        return view('page.notification.user', compact('page_name', 'breadcrumbs','page_option'));
    }

    public function showSystemNotifications()
    {
        $page_option = ['main' => 'dash', 'sub' => 'dash'];
        $page_name = "System Notifications";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '#'],
            ['name' => 'Dashboard', 'url' => '#'],
        ];

        return view('page.notification.system', compact('page_name', 'breadcrumbs','page_option'));
    }
}
