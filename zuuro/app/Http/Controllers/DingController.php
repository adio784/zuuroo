<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DingController extends Controller
{
    //
    public static function getToken(){
        $DataDetails = [
            'client_id'=> '919c366c-4645-46f8-80cc-35c77040014b',
            'client_secret' => '71apN0bg3CXO7ACVWe9mjjaibZu6sd4uC0VA2rH10GI=',
            'grant_type' => 'client_credentials'
        ];
        $response = Http::asForm()->post('https://idp.ding.com/connect/token', $DataDetails);
        return $response['access_token'];
    }


    public function dingconnect_record(){

        $today = NOW();
        $response = Http::withHeaders([
                        'Authorization' => 'Bearer '. $this->getToken(),
                        'Content-Type' => 'application/json'
                    ])->get('https://api.dingconnect.com/api/V1/GetBalance');
        $data = [
              'Balance' => json_decode($response)
        ];
        
        return view('app.admin.dingconnect_record', $data);
    }



}
