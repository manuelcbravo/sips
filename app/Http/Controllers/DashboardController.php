<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index_general(){
        return view('pages.dashboard.general.index', ['active' => 'dash_general']);
    }
}
