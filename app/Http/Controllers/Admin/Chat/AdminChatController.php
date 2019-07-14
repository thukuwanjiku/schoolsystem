<?php

namespace App\Http\Controllers\Admin\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminChatController extends Controller
{
    public function index()
    {
        return view('admin.chat');
    }
}
