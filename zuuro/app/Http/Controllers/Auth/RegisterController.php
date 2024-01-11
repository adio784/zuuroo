<?php

namespace App\Http\Controllers\Auth;

use App\Repositories\WalletRepository;
use App\Repositories\ActivityRepository;
use App\Repositories\UserRepository;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private WalletRepository $WalletRepository;
    private ActivityRepository $ActivityRepository;
    private UserRepository $UserRepository;

    private $monnify_baseUrl, $monnify_apiKey, $monnify_secretKey, $monnify_accNumber, $monnify_contactCode, $monnify_bvnNumber;

    public function __construct(WalletRepository $WalletRepository, ActivityRepository $ActivityRepository, UserRepository $UserRepository)
    {
        $this->middleware('guest');
        $this->WalletRepository = $WalletRepository;
        $this->ActivityRepository = $ActivityRepository;
        $this->UserRepository = $UserRepository;

        $this->monnify_baseUrl = "https://sandbox.monnify.com";//"https://api.monnify.com";
        $this->monnify_apiKey = "MK_TEST_94S53NRKEW";//"MK_PROD_0JNWWV5ZY6";
        $this->monnify_secretKey = "H7YQ0DYW5M2P50J0GR1MNUP4PKVDL3WR";//"A263P7DAA0TJ6BJQ5B37PU50Y9ZXWVJA";
        $this->monnify_contactCode = "5787668243";//"734720763871";
        $this->monnify_accNumber = "8024437726";
        $this->monnify_bvnNumber = "22318673488";
    }

    public function getToken(){
        $response = Http::withBasicAuth($this->monnify_apiKey, $this->monnify_secretKey)->post($this->monnify_baseUrl.'/api/v1/auth/login');
        //$token = json_decode($response)->responseBody->accessToken;
        return json_decode($response)->responseBody->accessToken;
    }
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'      => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'username'  => ['required', 'string', 'max:255'],
            'telephone' => ['required', 'numeric'],
            'dob'       => ['required', 'string', 'max:255'],
            'gender'    => ['required', 'string', 'max:255'],
            'address'   => ['required', 'string', 'max:255'],
            'country'   => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if($data['country'] == 'NG')
        {
            $ran = $data['telephone'].rand(99, 999999);
            $details = [
                "accountReference"=> $ran,
                "accountName"=> $data['name'],
                "currencyCode"=> "NGN",
                "contractCode"=> $this->monnify_contactCode,
                "customerEmail"=> $data['email'],
                "bvn"=> $this->monnify_bvnNumber,
                "customerName"=> $data['name'],
                "getAllAvailableBanks"=> true
            ];
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '. $this->getToken(),
                'Content-Type' => 'application/json'
            ])->post($this->monnify_baseUrl.'/api/v2/bank-transfer/reserved-accounts', $details);
            $return_data = json_decode($response);

            if($return_data->requestSuccessful == true)
            {
                foreach($return_data->responseBody->accounts as $account){

                    $bankDetails['res_reference'] = $return_data->responseBody->reservationReference;
                    $bankDetails['user_name'] = $return_data->responseBody->customerEmail;
                    $bankDetails['user_email'] = $return_data->responseBody->customerName;
                    $bankDetails['account_name'] = $account->accountName;
                    $bankDetails['account_number'] = $account->accountNumber;
                    $bankDetails['bank_name'] = $account->bankName;
                    $bankDetails['bank_code'] = $account->bankCode;
                    $bankDetails['account_status']= $return_data->responseBody->status;

                    $this->UserRepository->createUserAccountDetails($bankDetails);
                }
                $user = User::create([
                    'name'          => $data['name'],
                    'email'         => $data['email'],
                    'password'      => Hash::make($data['password']),
                    'mobile'        => $data['telephone'],
                    'dob'           => $data['dob'],
                    'username'      => $data['username'],
                    'gender'        => $data['gender'],
                    'address'       => $data['address'],
                    'country'       => $data['country'],
                ]);
                if($user)
                {
                    $user_info = User::where('email', $data['email'])->first();
                    $UserId = $user_info->id;
                    $WalletDetails = [ 'user_id' => $UserId, 'balance' => 0, 'email' => $user_info->email ];
                    $ActivityDetails = [ 'username' => $data['username'], 'report'   => 'just registered' ];

                    $wallet = $this->WalletRepository->createWallet($WalletDetails);
                    $activities = $this->ActivityRepository->createActivity($ActivityDetails);


                    return $user;
                    return $wallet;
                    return $activities;
                }else{
                    dd('Error creating Account');
                }
            }
            else{
                dd($return_data->requestSuccessful, $return_data);
            }
        }
        else{
            $user = User::create([
                'name'          => $data['name'],
                'email'         => $data['email'],
                'password'      => Hash::make($data['password']),
                'mobile'        => $data['telephone'],
                'dob'           => $data['dob'],
                'username'      => $data['username'],
                'gender'        => $data['gender'],
                'address'       => $data['address'],
                'country'       => $data['country'],
            ]);
            if($user)
            {
                $user_info = User::where('email', $data['email'])->first();
                $UserId = $user_info->id;
                $WalletDetails = [ 'user_id' => $UserId, 'balance' => 0, 'email' => $user_info->email ];
                $ActivityDetails = [ 'username' => $data['username'], 'report'   => 'just registered' ];

                $wallet = $this->WalletRepository->createWallet($WalletDetails);
                $activities = $this->ActivityRepository->createActivity($ActivityDetails);


                return $user;
                return $wallet;
                return $activities;
            }
        }

    }

}
