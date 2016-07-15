<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ReferencesController extends Controller
{
    public function index()
    {
        $sidebar = array(
            'Users List' => array('url' => '/', 'icon' => '<i class="fa fa-users"></i>'),
            'Add New' => array('url' => '/', 'icon' => '<i class="fa fa-plus-circle"></i>'),
        );

        return view('admin.reference')->with(['sidebar_items' => $sidebar]);
    }
}
