<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $page_option = ['main' => 'user', 'sub' => 'user_index'];
        $page_name = "User Management";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'User', 'url' => route('user.index')],
        ];

        return view('page.user.index', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_option = ['main' => 'user', 'sub' => 'user_create'];
        $page_name = "Create New User";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'User', 'url' => route('user.create')],
            ['name' => 'New' ,'url' => '#']
        ];

        return view('page.user.create', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    public function profile() {

        $page_option = ['main' => 'null', 'sub' => 'null'];
        $page_name = "My Profile";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'My Profile', 'url' => "#"],
        ];

        return view('page.user.profile', compact('page_name', 'breadcrumbs', 'page_option'));

    }
}
