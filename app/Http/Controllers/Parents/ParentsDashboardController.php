<?php

namespace App\Http\Controllers\Parents;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ParentsDashboardController extends Controller
{
    public function index()
    {
        return view('parents.dashboard');
    }
}
