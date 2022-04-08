<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SubmenusResource;
use App\Models\Submenus;
use Illuminate\Http\Request;

class SubmenusController extends Controller
{
    //
    public function index(){
        $submenus = Submenus::get();
        return SubmenusResource::collection($submenus);
    }
}
