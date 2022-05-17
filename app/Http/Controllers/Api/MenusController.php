<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenusResource;
use App\Models\Menus;
use App\Models\Roles;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;

class MenusController extends Controller
{

    public function allMenus(){
        $menus = Menus::with('childs.childs.childs')->where('id', 6)->whereHas('menuroles', function ($q){
            $q->where('role_id', Auth()->user()->role_id);
        })->where('hide', 0)->get();

        return response()->json($menus);
    }

    public function getMenus(){
        $menus = Menus::with('childs')->where('id', 6)->whereHas('menuroles', function ($q){
            $q->where('id', Auth()->user()->id);
        })->orderBy('no', 'asc')->where('hide', 0)->get();
        return MenusResource::collection($menus);
    }

    public function getSubmenus($id){
        $menus = null;
        if ($id) {
            # code...
            $menus = Menus::with('childs')->where('parent_id', $id)->whereHas('menuroles', function ($q){
                $q->where('role_id',Auth()->user()->role_id);
            })->orderBy('no', 'asc')->get();

            if (empty($menus->toArray())) {
                $server =  env('DUK_HOST_TRUSTED');
                $ticket = $this->getTicket();

                return response()->json([
                    'urlview'   => route('viewdashboard', $id),
                    'ticket'    => $ticket
                ]);
            }
        }
        return MenusResource::collection($menus->where('hide', 0));

    }

    public function getRole(){
        $roles =  Roles::with('menus')->get();
        return MenusResource::collection($roles);
    }

    public function getTicket()
    {
        $setting    =   Settings::firstOrFail();
        $user       =   Auth::user()->name;
        $server     =   $setting->tableauserverexternal;
        $targetsite = null;


        extract($_POST);
        $ch = curl_init();

        $certificate_location = asset('/storage/CA.crt');

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $certificate_location);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $certificate_location);
        curl_setopt($ch, CURLOPT_URL, $server);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=". $user ."&submittable=Get Ticket");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,  "username=". $user ."&submittable=Get Ticket");

        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

        // dd($result);
        return $result;

    }
}
