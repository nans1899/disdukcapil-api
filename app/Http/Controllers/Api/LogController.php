<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LogResource;
use App\Models\Logs;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //
    public function index()
    {
        $logs = Logs::orderBy('module', 'asc')->orderBy('created_at', 'desc')->paginate(10);

        return LogResource::collection($logs);

    }
}
