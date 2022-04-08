<?php

namespace App\Http\Controllers;

use App\Models\Menus;
use Illuminate\Http\Request;

class ViewdashboardController extends Controller
{
    //
    public function index($menuId)
    {
        $menus = Menus::where('id', $menuId)->firstOrFail();

        $server =  env('DUK_HOST');
        $ticket = $this->getTicket();

        return view('viewdashboard', compact('menus', 'ticket', 'server'));
    }

    public function getTicket(){
        $user   = 'Administrator';
        $server =  env('DUK_HOST');
        $targetsite = null;

        //extract data from the post
        // extract($_POST);

        //set POST variables
        $url = $server.'/trusted';

        if($targetsite != "" && $targetsite != null)
        {
            $fields_string ='username='.$user.'&target_site='.$targetsite;
        }
        else
        {
            $fields_string ='username='.$user;
        }

        // open connection
        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $fields_string,
            CURLOPT_RETURNTRANSFER => 1
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);

        curl_close($ch);

        return $response;
    }

}
