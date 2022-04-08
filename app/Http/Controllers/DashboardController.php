<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Menus;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index(){
        $account = Accounts::with('roles')->where('id', 462)->first();
        return view('welcome', compact('account'));
    }
}
