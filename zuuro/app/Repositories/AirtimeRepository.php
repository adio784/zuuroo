<?php

namespace App\Repositories;

use App\Interfaces\AirtimeRepositoryInterface;
use App\Models\SimServer;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\RequestException;

class AirtimeRepository implements AirtimeRepositoryInterface
{
    private $ApiKey;
    private $Secrete_Key;

    public function __construct()
    {
        $getCredentials = SimServer::where('sim_server', 'Airtime_vtpass')->first();
        $this->ApiKey = $getCredentials->access_token;
        $this->Secrete_Key = $getCredentials->secret_key;
        // https://api-service.vtpass.com/api/
    }

    public static function getToken(){
        $AirtimeDetails = [
            'client_id'=> '919c366c-4645-46f8-80cc-35c77040014b',
            'client_secret' => '71apN0bg3CXO7ACVWe9mjjaibZu6sd4uC0VA2rH10GI=',
            'grant_type' => 'client_credentials'
        ];
        $response = Http::asForm()->post('https://idp.ding.com/connect/token', $AirtimeDetails);
        return $response['access_token'];
    }

    public function createNgAirtime(array $AirtimeDetails)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Token 7449197381ad06f36b660461759a4f4d9c3ead05',
            'Content-Type' => 'application/json'
        ])->post('https://tentendata.com.ng/api/topup/', $AirtimeDetails);
        return $response;
    }

    public function createVTPassAirtime(array $AirtimeDetails)
    {
        $response = Http::withHeaders([
            'api-key'       => $this->ApiKey,
            'secret-key'    => $this->Secrete_Key,
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json'
        ])->post('https://api-service.vtpass.com/api/pay', $AirtimeDetails);
        return $response;
        //https://sandbox.vtpass.com/api/pay
    }

    public function createIntAirtime(array $AirtimeDetails)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer '. $this->getToken(),
            'Content-Type' => 'application/json'
        ])->post('https://api.dingconnect.com/api/V1/SendTransfer', $AirtimeDetails);
        return $response;
    }

    public function findUser()
    {
        //$response = Http::withToken('Token 7449197381ad06f36b660461759a4f4d9c3ead05')->get('https://tentenAirtime.com.ng/api/user');
        $response = Http::withHeaders([
            'Authorization' => 'Token 7449197381ad06f36b660461759a4f4d9c3ead05',
            'Content-Type' => 'application/json'
        ])->get('https://tentenAirtime.com.ng/api/user');

        return $response;
    }

}
