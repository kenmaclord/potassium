<?php

namespace Potassium\App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Potassium\App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('potassium::admin.pages.dashboard.index');
    }
}
