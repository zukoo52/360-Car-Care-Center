<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {

        $page_option = ['main' => 'permission', 'sub' => 'permission_index'];
        $page_name = "Roles and Permission Management";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Permissions', 'url' => route('permission.index')],
        ];

        return view('page.permission.index', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role = Role::find($id);
        $page_option = ['main' => 'permission', 'sub' => 'permission_index'];
        $page_name = "Permission for role";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Permissions', 'url' => route('permission.index')],
            ['name' => 'Role Overview', 'url' => '#'],
        ];

        return view('page.permission.show', compact('page_name', 'breadcrumbs', 'page_option', 'role'));
    }
}
