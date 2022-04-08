<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use App\Models\Menus;
use App\Models\Roles;
use App\Models\Settings;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;

class SettingsController extends Controller
{
    //

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getRoles(){
        $roles = Roles::get();
        return response()->json([
            'status'    => true,
            'data'      => $roles,
        ], 200);
    }

    public function index(){
        $settings = Settings::firstorfail();
        return response()->json($settings);
    }

    public function search(Request $request)
    {
        if ($request->q) {
            $result = Accounts::with('roles')
            ->where('name', 'LIKE', "%{$request->q}%")
            ->orWhere('email', 'LIKE', "%{$request->q}%")
            ->orWhere('username', 'LIKE', "%{$request->q}%")
            ->orWhere('role_id', 'LIKE', "%{$request->q}%")
            ->get();
        }

        if ($request->c) {
            $result = Accounts::with('roles')
            ->whereHas('roles', function($q) use($request) {
                $q->where('name', $request->c);
            })->get();
        }
            return response()->json($result);

        // return SearchResource::collection($result);
    }

    public function userExport(Request $request)
    {

        if ($request->filter != 0) {
            $users = Accounts::with('roles')->where('role_id', $request->filter)->get();
        } else {
            $users = Accounts::with('roles')->get();
        }
        // $users = Accounts::get();
        $pdf = PDF::loadView('userexport', compact('users'))->setPaper('a4', '');
        Storage::put('public/pdf/User-Table-Dukcapil-' . Carbon::now()->toDateString() . '.pdf', $pdf->output());
        return  $pdf->download('User-Table-Dukcapil-' . Carbon::now()->toDateString() . '.pdf');
    }

    public function menuExport()
    {
        $menus = Menus::with('roles')->get();

        $pdf = PDF::loadView('menuexport', compact('menus'))->setPaper('a4', 'potrait');
        Storage::put('public/pdf/Portal-Tableau-Dukcapil-' . Carbon::now()->toDateString() .'.pdf', $pdf->output());
        return  $pdf->download('Portal-Tableau-Dukcapil-' . Carbon::now()->toDateString() .'.pdf');
        // return response()->json($menus);

        // return view('menuexport', compact('menus'));
    }

    public function alluser()
    {
        # code...
        $users = Accounts::get();

        return response()->json($users);
    }

}
