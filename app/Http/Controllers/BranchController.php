<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function create()
    {
        $page_option = ['main' => 'branch', 'sub' => 'branch_create'];
        $page_name = "Create New Branch";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Branch', 'url' => route('branch.create')],
            ['name' => 'New', 'url' => '#']
        ];

        return view('page.branch.create', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    public function index()
    {

        $page_option = ['main' => 'branch', 'sub' => 'branch_index'];
        $page_name = "Branch Overview";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Branch', 'url' => route('branch.index')],
            ['name' => 'View', 'url' => '#']
        ];

        return view('page.branch.index', compact('page_name', 'breadcrumbs', 'page_option'));
    }

    public function update($id)
    {
        $branch=Branch::find($id);
        $page_option = ['main' => 'branch', 'sub' => 'branch_index'];
        $page_name = "Update Branch";
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Branch', 'url' => route('branch.index')],
            ['name' => 'View', 'url' => '#']
        ];

        return view('page.branch.update', compact('page_name', 'breadcrumbs', 'page_option','branch'));
    }

}
