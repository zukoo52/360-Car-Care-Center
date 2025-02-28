<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $page_option = ['main' => 'dash', 'sub' => 'dash'];
        $page_name = "Dashboard";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => '#'],
            ['name' => 'Dashboard', 'url' => '#'],
        ];

        return view('home', compact('page_name', 'breadcrumbs','page_option'));
    }
}
