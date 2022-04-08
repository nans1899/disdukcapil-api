<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DashboardResource;
use App\Models\Dashboardhome;
use App\Models\MenuRoles;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function index()
    {

        $dashboardhomes = Dashboardhome::with('images')->whereHas('roles', function($q) {
            $q->where('roles_id', Auth()->user()->role_id);
        })->get();

        return DashboardResource::collection($dashboardhomes);

    }
}
