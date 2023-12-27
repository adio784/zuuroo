<?php

namespace App\Http\Controllers;



use App\Interfaces\LoanHistoryRepositoryInterface;
use App\Interfaces\HistoryRepositoryInterface;
use App\Interfaces\WalletRepositoryInterface;
use App\Interfaces\DataRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


use App\Models\Country;
use App\Models\Product;

class DataController extends Controller
{

    private DataRepositoryInterface $DataRepository;
    private HistoryRepositoryInterface $HistoryRepository;
    private LoanHistoryRepositoryInterface $LoanHistoryRepository;
    private UserRepositoryInterface $UserRepository;
    private WalletRepositoryInterface $WalletRepository;

    public function __construct(DataRepositoryInterface $DataRepository,
                                HistoryRepositoryInterface $HistoryRepository,
                                LoanHistoryRepositoryInterface $LoanHistoryRepository,
                                UserRepositoryInterface $UserRepository,
                                WalletRepositoryInterface $WalletRepository)
    {
        $this->DataRepository = $DataRepository;
        $this->HistoryRepository = $HistoryRepository;
        $this->LoanHistoryRepository = $LoanHistoryRepository;
        $this->UserRepository = $UserRepository;
        $this->WalletRepository = $WalletRepository;
    }

    public function createData(Request $request)
    //: JsonResponse
    {
        $uid = Auth::user()->id;
        $uemail = Auth::user()->email;
        $repayment = date('Y-m-d');

        $req_Account_process = $this->WalletRepository->getWalletBalance($uid);
        $req_bal_process = $req_Account_process->balance;
        $req_loanBal_process = $req_Account_process->loan_balance;
        $user = $this->UserRepository->getUserById($uid);
        $LoanCountry = Country::where('is_loan', true)
                                ->where('country_code', $request->country)
                                ->get();

        // GLNG | MTNG | ZANG | ETNG
        $network = "";
        $customer_ref = 'ZR_'.rand(99, 999999);
        // dd($request->data_plan);
            if($request->network_operator == 'MTNG'){ $network = 1;}
            elseif($request->network_operator == 'ZANG'){ $network = 2;}
            elseif($request->network_operator == 'GLNG'){ $network = 3;}
            elseif($request->network_operator == 'ETNG'){ $network = 4;}
            else{ $network = $request->network_operator; }

            $prdD = Product::where('product_code', $request->data_plan)->first();
            $skuCode = $prdD->product_code;
            $product_price =$prdD->product_price;
            $sendValue =$prdD->send_value;
            $product_name =$prdD->product_name;
            // foreach($request->data_plan as $value){
                // $data_arr = explode(',', $value);
                // $skuCode = $data_arr[0];
                // $product_price = $data_arr[1];
                // $sendValue = $data_arr[2];
                // $product_name = $data_arr[3];
            // }
            // return $product_price ;
        // Validate Account Verification
        if($user->email_verified_at !="" && $user->number_verify_at != "")
        {
            if(Hash::check($request->pin, $user->create_pin)){
                // dd($request->top_up);
                if($request->top_up == 1){
                    // dd($request->all());
                    $request->validate([
                        'top_up'            =>  'required',
                        'country'           =>  'required',
                        'phoneNumber'       =>  'required',
                        'network_operator'  =>  'required',
                        'data_plan'         =>  'required'
                    ]);

                    // Processing Nigeria Data
                    if($request->country == 'NG'){
                        if($user->country_verify_at != ""){

                            if($req_bal_process < $product_price){
                                return back()->with('fail', ' Insufficient fund');
                            }else{
                                $new_bal_process = $req_bal_process - $product_price;
                                $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                $this->WalletRepository->updateWallet($uid, $walletDetails);

                                $phoneNumber = str_replace('234', '0', $request->phoneNumber);
                                // dd($data_plan);
                                $DataDetails = [
                                    'network'       => $network, //1
                                    'mobile_number' => $phoneNumber, //"09037346247",
                                    'plan'          => $skuCode,//6,
                                    'Ported_number' => true
                                ];
                                // Store returned data in DB
                                $createNigData = json_decode( $this->DataRepository->createNgData($DataDetails) );
                                if($createNigData->error){

                                    $new_bal_process = $req_bal_process + $product_price;
                                    $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                    $this->WalletRepository->updateWallet($uid, $walletDetails);
                                    // return back()->with('fail', 'Error Occured, try later');

                                    Alert::error('Error!', 'Internal Server Error, Please Try Later');
                                    return back();
                                }else{
                                    // return $createNigData ;
                                    $HistoryDetails = [
                                        'user_id'               =>  $uid,
                                        'plan'                  =>  $createNigData->plan_name,
                                        'purchase'              =>  'Data',
                                        'country_code'          =>  $request->country,
                                        'operator_code'         =>  $request->network_operator,
                                        'product_code'          =>  $skuCode,
                                        'transfer_ref'          =>  $createNigData->ident,
                                        'phone_number'          =>  $createNigData->mobile_number,
                                        'distribe_ref'          =>  $customer_ref,
                                        'selling_price'         =>  $product_price,
                                        'receive_value'         =>  $createNigData->plan_name,
                                        'send_value'            =>  $createNigData->plan_name,
                                        'receive_currency'      =>  'NGN',
                                        'commission_applied'    =>  0.0,
                                        'startedUtc'            =>  NOW(),
                                        'completedUtc'          =>  $createNigData->create_date,
                                        'processing_state'      =>  $createNigData->Status,
                                    ];
                                    $query = $this->HistoryRepository->createHistory($HistoryDetails);
                                    if($query){
                                        Alert::success('Success', 'You\'ve Purchase '. $createNigData->mobile_number. ' With '. $createNigData->plan_name.' Data');
                                        return back();
                                    }else{
                                        return back()->with('fail', 'Transaction Failed !!!');
                                    }

                                    // return back()->with('success', 'Successfully purchase '.$product_name.' to: '. $createNigData->mobile_number);
                                }

                            }
                        }else{ return back()->with('fail', 'Please complete your KYC !'); }
                    }
                    // Processing Other Countries Data
                    else{

                        // Check wallet balance
                        if($req_bal_process < $product_price){
                            return back()->with('fail', ' Insufficient fund');
                        }else{

                            $new_bal_process = $req_bal_process - $product_price;
                            $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];


                            if($this->WalletRepository->updateWallet($uid, $walletDetails))
                            {

                                // Data Api Arrays
                                $DataDetails = [
                                    'SkuCode'           => $skuCode,
                                    'SendValue'         => $sendValue ,
                                    'SendCurrencyIso'   => 'USD',
                                    'AccountNumber'     => $request->phoneNumber,
                                    'DistributorRef'    => $request->DistributorRef,
                                    'ValidateOnly'      => false,
                                    'RegionCode'        => $network
                                ];
                                $response = $this->DataRepository->createIntData($DataDetails);
                                // return $response;
                                if($response['ResultCode'] ==1){
                                    $HistoryDetails = [
                                        'user_id'               =>  $uid,
                                        'plan'                  =>  $response['TransferRecord']['ReceiptText'],//$data_plan,
                                        'purchase'              =>  'data',
                                        'country_code'          =>  $request->country,
                                        'operator_code'         =>  $network,
                                        'product_code'          =>  $skuCode,
                                        'transfer_ref'          =>  $response['TransferRecord']['TransferId']['TransferRef'],
                                        'phone_number'          =>  $request->phoneNumber,
                                        'distribe_ref'          =>  $response['TransferRecord']['TransferId']['DistributorRef'],
                                        'selling_price'         =>  '',
                                        'receive_value'         =>  $response['TransferRecord']['Price']['ReceiveValue'],
                                        'send_value'            =>  $response['TransferRecord']['Price']['SendValue'],
                                        'receive_currency'      =>  $response['TransferRecord']['Price']['SendCurrencyIso'],
                                        'commission_applied'    =>  $response['TransferRecord']['CommissionApplied'],
                                        'startedUtc'            =>  $response['TransferRecord']['StartedUtc'],
                                        'completedUtc'          =>  $response['TransferRecord']['CompletedUtc'],
                                        'processing_state'      =>  $response['TransferRecord']['ProcessingState'],
                                    ];
                                    $query = $this->HistoryRepository->createHistory($HistoryDetails);
                                    if($query){
                                        // use Alert;
                                        Alert::success('Success', 'You\'ve Purchase '.$request->phoneNumber. ' With '. $product_name);
                                        return back();
                                    }else{
                                        return back()->with('fail', 'Transaction Failed !!!');
                                    }

                                }else{
                                    $new_bal_process = $req_bal_process + $product_price;
                                    $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                    $this->WalletRepository->updateWallet($uid, $walletDetails);
                                    return back()->with('fail', 'Error Occured, try later');
                                }
                            }else{
                                return back()->with('fail', 'Internal Server Error, Please Retry');
                            }

                        }

                        // return $response;
                    }

                }elseif($request->top_up ==2){
                    // return back()->with('fail', 'Sorry, loan not available at the moment');
                    if($LoanCountry){
                        // return ('Loan');
                        // Processing Loan Nigeria Data
                        if($request->country == 'NG'){

                            $new_loanBal_process = $req_loanBal_process + $product_price;
                            $walletDetails = [ 'loan_balance' => $new_loanBal_process, 'updated_at'=> NOW() ];
                            $this->WalletRepository->updateWallet($uid, $walletDetails);

                            $phoneNumber = str_replace('234', '0', $request->phoneNumber);
                            // dd($data_plan);
                            $DataDetails = [
                                'network'       => $network, //1
                                'mobile_number' => $phoneNumber, //"09037346247",
                                'plan'          => $skuCode,//6,
                                'Ported_number' => true
                            ];
                            // return $this->DataRepository->createNgData($DataDetails);
                            // Store returned data in DB
                                $createNigData = json_decode( $this->DataRepository->createNgData($DataDetails) );
                                if($createNigData->error ==''){
                                    // return $createNigData ;
                                    $HistoryDetails = [
                                        'user_id'               =>  $uid,
                                        'plan'                  =>  $createNigData->plan_name,
                                        'purchase'              =>  'Data',
                                        'country_code'          =>  $request->country,
                                        'operator_code'         =>  $request->network_operator,
                                        'product_code'          =>  $skuCode,
                                        'transfer_ref'          =>  $createNigData->ident,
                                        'phone_number'          =>  $createNigData->mobile_number,
                                        'distribe_ref'          =>  $customer_ref,
                                        'selling_price'         =>  $product_price,
                                        'receive_value'         =>  $createNigData->plan_name,
                                        'send_value'            =>  $createNigData->plan_name,
                                        'receive_currency'      =>  'NGN',
                                        'commission_applied'    =>  0.0,
                                        'startedUtc'            =>  NOW(),
                                        'completedUtc'          =>  $createNigData->create_date,
                                        'processing_state'      =>  $createNigData->Status,
                                    ];
                                    $query = $this->LoanHistoryRepository->createLoanHistory($HistoryDetails);
                                    if($query){

                                        Alert::success('Success', 'You\'ve Loan '. $createNigData->mobile_number. ' With '. $createNigData->plan_name.' Data');
                                        return back();
                                    }else{

                                        return back()->with('fail', 'Loan Request Failed !!!');
                                    }

                                    // return back()->with('success', 'Successfully purchase '.$product_name.' to: '. $createNigData->mobile_number);
                                }else{
                                    $new_loanBal_process = $req_loanBal_process - $product_price;
                                    $walletDetails = [ 'loan_balance' => $new_loanBal_process, 'updated_at'=> NOW() ];
                                    $this->WalletRepository->updateWallet($uid, $walletDetails);
                                    Alert::success('Oops', 'Your request could not be completed, try later !!!');
                                    return back();
                                }
                        }else{
                            $DataDetails = [
                                'SkuCode'           => $skuCode,
                                'SendValue'         => $sendValue,
                                'SendCurrencyIso'   => 'USD',
                                'AccountNumber'     => $request->phoneNumber,
                                'DistributorRef'    => $request->DistributorRef,
                                'ValidateOnly'      => false,
                                'RegionCode'        => $network
                            ];
                            $response = $this->DataRepository->createIntData($DataDetails);
                            // return $response;
                            if($response['ResultCode'] ==1){
                                $HistoryDetails = [
                                    'user_id'               =>  $uid,
                                    'plan'                  =>  $response['TransferRecord']['ReceiptText'],//$product_name,
                                    'purchase'              =>  'Data',
                                    'country_code'          =>  $request->country,
                                    'operator_code'         =>  $network,
                                    'product_code'          =>  $skuCode,
                                    'transfer_ref'          =>  $response['TransferRecord']['TransferId']['TransferRef'],
                                    'phone_number'          =>  $request->phoneNumber,
                                    'distribe_ref'          =>  $response['TransferRecord']['TransferId']['DistributorRef'],
                                    'selling_price'         =>  '',
                                    'receive_value'         =>  $response['TransferRecord']['Price']['ReceiveValue'],
                                    'send_value'            =>  $response['TransferRecord']['Price']['SendValue'],
                                    'receive_currency'      =>  $response['TransferRecord']['Price']['SendCurrencyIso'],
                                    'commission_applied'    =>  $response['TransferRecord']['CommissionApplied'],
                                    'startedUtc'            =>  $response['TransferRecord']['StartedUtc'],
                                    'completedUtc'          =>  $response['TransferRecord']['CompletedUtc'],
                                    'processing_state'      =>  $response['TransferRecord']['ProcessingState'],
                                    'repayment'             =>  $repayment,
                                    'payment_status'        =>  'pending',
                                    'due_date'              =>  $request->loan_term
                                ];
                                $query = $this->LoanHistoryRepository->createLoanHistory($HistoryDetails);
                                if($query){
                                    Alert::success('Success', 'You\'ve Loan '.$request->phoneNumber. ' With '. $response['TransferRecord']['ReceiptText']);
                                    return back();
                                }else{
                                    return back()->with('fail', 'Loan Request Failed !!!');
                                }

                            }
                        }

                    }else{
                        return back()->with('fail', 'Sorry, loan is not available in the selected country');
                    }


                    if($req_bal_process >= 100){
                        return back()->with('fail', 'Your Balance Is Still High, You Cannot Loan At This Time ...');
                    }else{

                    }
                    return $request->top_up;
                }else{
                    return back()->with('fail', 'Invalid Selection, Please Make a Choice');
                }

            }else{
                return back()->with('fail', 'Incorrect PIN');
            }
        }
        else
        {
            return back()->with('fail', 'Complete Account Verification !!!');
        }
        // PIN Validation



    }


    public function findUser()
    // :JsonResponse
    {
        return $this->DataRepository->findUser();
        // return response()->json(null, Response::HTTP_NO_CONTENT);
        // return response()->json([
        //     'data' => $this->DataRepository->findUser()
        // ]);


    }

    public function token()
    {
        $DataDetails = [
            'client_id'=> '919c366c-4645-46f8-80cc-35c77040014b',
            'client_secret' => '71apN0bg3CXO7ACVWe9mjjaibZu6sd4uC0VA2rH10GI=',
            'grant_type' => 'client_credentials'
        ];
        return $this->DataRepository->getToken($DataDetails);
    }
}
