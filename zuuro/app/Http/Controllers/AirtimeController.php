<?php

namespace App\Http\Controllers;

use App\Interfaces\AirtimeRepositoryInterface;
use App\Interfaces\HistoryRepositoryInterface;
use App\Interfaces\LoanHistoryRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\WalletRepositoryInterface;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Country;

class AirtimeController extends Controller
{

    private AirtimeRepositoryInterface $AirtimeRepository;
    private HistoryRepositoryInterface $HistoryRepository;
    private LoanHistoryRepositoryInterface $LoanHistoryRepository;
    private UserRepositoryInterface $UserRepository;
    private WalletRepositoryInterface $WalletRepository;

    public function __construct(AirtimeRepositoryInterface $AirtimeRepository, HistoryRepositoryInterface $HistoryRepository, LoanHistoryRepositoryInterface $LoanHistoryRepository, UserRepositoryInterface $UserRepository, WalletRepositoryInterface $WalletRepository)
    {
        $this->AirtimeRepository = $AirtimeRepository;
        $this->HistoryRepository = $HistoryRepository;
        $this->LoanHistoryRepository = $LoanHistoryRepository;
        $this->UserRepository = $UserRepository;
        $this->WalletRepository = $WalletRepository;
    }

    public function createAirtime(Request $request)
    //: JsonResponse
    {
        date_default_timezone_set("Africa/Lagos");
        $uid        = Auth::user()->id;
        $uemail     = Auth::user()->email;
        $today      = date('Y-m-d');
        $daysToAdd  = $request->loan_term;
        $repayment  = date("Y-m-d", strtotime("+" . $daysToAdd . " days"));
        
        //date('Y-m-d', strtotime(date('Y-m-d'). ' +'. $dueDate));

        $requestID  = date('YmdHi').rand(99, 9999999);
        $req_Account_process    = $this->WalletRepository->getWalletBalance($uid);
        $req_bal_process        = $req_Account_process->balance;
        $req_loanBal_process    = $req_Account_process->loan_balance;
        $user                   = $this->UserRepository->getUserById($uid);
        $LoanCountry            = Country::where('is_loan', true)->where('country_code', $request->country)->get();

        // GLNG | MTNG | ZANG | ETNG

        // Validate Account Verification
        $amount         = strip_tags($request->total_price);
        $network        = strip_tags($request->network_operator);
        $customer_ref   = 'ZR_'.rand(99, 999999);
        $actAmt         = strip_tags($request->amount);

        if($user->email_verified_at !="" && $user->number_verify_at != "")
        {
            if(Hash::check($request->pin, $user->create_pin)){

                if($request->top_up == 1){

                    $request->validate([
                        'top_up'            =>  'required',
                        'country'           =>  'required',
                        'phoneNumber'       =>  'required',
                        'network_operator'  =>  'required',
                        'amount'            =>  'required'
                    ]);


                    // Processing Nigeria Data
                    if($request->country == 'NG'){

                        if($req_bal_process < $amount){

                            return response()->json([
                                'success'       => false,
                                'statusCode'    => 500,
                                'message'       => 'Insufficient fund !!!'
                            ]);

                        }else{

                            $new_bal_process = $req_bal_process - $amount;
                            $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                            $this->WalletRepository->updateWallet($uid, $walletDetails);

                            $phoneNumber = str_replace('234', '0', strip_tags($request->phoneNumber));

                            $DataDetails = [
                                'request_id'        => $requestID,
                                'serviceID'         => $network,
                                'phone'             => $phoneNumber,
                                'amount'            => $actAmt,

                            ];

                            // Store returned data in DB
                            $createNigData = json_decode( $this->AirtimeRepository->createVTPassAirtime($DataDetails) ); Log::error(['err' => $createNigData]);
                            // return response()->json([
                            //     'success'       => false,
                            //     'statusCode'    => 500,
                            //     'message'       => 'Message'
                            // ]);

                            if( $createNigData->code == '000' ){

                                $HistoryDetails = [
                                    'user_id'               =>  $uid,
                                    'plan'                  =>  $createNigData->content->transactions->product_name,
                                    'purchase'              =>  'Airtime',
                                    'country_code'          =>  $request->country,
                                    'operator_code'         =>  $network,
                                    'product_code'          =>  'VTU',
                                    'transfer_ref'          =>  $createNigData->content->transactions->transactionId,
                                    'phone_number'          =>  $createNigData->content->transactions->unique_element,
                                    'distribe_ref'          =>  $createNigData->requestId,
                                    'selling_price'         =>  $amount,
                                    'receive_value'         =>  $createNigData->amount,
                                    'send_value'            =>  $actAmt,
                                    'receive_currency'      =>  'NGN',
                                    'commission_applied'    =>  $createNigData->content->transactions->commission,
                                    'startedUtc'            =>  NOW(),
                                    'completedUtc'          =>  NOW(),
                                    'processing_state'      =>  $createNigData->content->transactions->status,
                                ];
                                $query = $this->HistoryRepository->createHistory($HistoryDetails);
                                if($query){

                                    return response()->json([
                                        'success'       => true,
                                        'statusCode'    => 200,
                                        'message'       => 'You\'ve Purchase '. $phoneNumber. ' With '. number_format($actAmt). ' NGN Airtime'
                                    ]);

                                    // Alert::success('Success', 'You\'ve Purchase '. $createNigData->mobile_number. ' With '. $amount. ' NGN Airtime');

                                }else{

                                    return response()->json([
                                        'success'       => false,
                                        'statusCode'    => 500,
                                        'message'       => 'Transaction Failed !!!'
                                    ]);

                                }

                            } else if ( $createNigData->code == '016' ) {

                                $new_bal_process = $req_bal_process + $amount;
                                $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                $this->WalletRepository->updateWallet($uid, $walletDetails);

                                return response()->json([
                                    'success'       => false,
                                    'statusCode'    => 500,
                                    'message'       => 'Transaction Failed, Please Try Later !!!'
                                ]);

                            } else {

                                $new_bal_process = $req_bal_process + $amount;
                                $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                $this->WalletRepository->updateWallet($uid, $walletDetails);

                                return response()->json([
                                    'success'       => false,
                                    'statusCode'    => 500,
                                    'Error'         => $createNigData,
                                    'message'       => 'Transaction Failed, Unknown Error Occurered, Try Later'
                                ]);
                            }

                        }

                    }

                    // Processing Other Countries Data
                    else{

                        // Check wallet balance
                        if($req_bal_process < $amount){

                            return response()->json([
                                'success'       => false,
                                'statusCode'    => 500,
                                'message'       => 'Insufficient fund !!!'
                            ]);

                        }else{

                            $new_bal_process = $req_bal_process - $amount;
                            $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];

                            if($this->WalletRepository->updateWallet($uid, $walletDetails) )
                            {
                                // Data Api Arrays
                                $DataDetails = [
                                    'SkuCode'           => $network,
                                    'SendValue'         => $actAmt,
                                    'SendCurrencyIso'   => 'USD',
                                    'AccountNumber'     => $request->phoneNumber,
                                    'DistributorRef'    => $request->DistributorRef,
                                    'ValidateOnly'      => false,
                                    'RegionCode'        => $network
                                ];
                                $response = $this->AirtimeRepository->createIntAirtime($DataDetails);
                                if($response['ResultCode'] ==1){
                                    $HistoryDetails = [
                                        'user_id'               =>  $uid,
                                        'plan'                  =>  $actAmt,
                                        'purchase'              =>  'data',
                                        'country_code'          =>  $request->country,
                                        'operator_code'         =>  $network,
                                        'product_code'          =>  $network,
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

                                        return response()->json([
                                            'success'       => true,
                                            'statusCode'    => 200,
                                            'message'       => 'Successful !!!'
                                        ]);

                                    }else{

                                        return response()->json([
                                            'success'       => false,
                                            'statusCode'    => 500,
                                            'message'       => 'Transaction Failed !!!'
                                        ]);

                                    }

                                }else{
                                    $new_bal_process = $req_bal_process + $amount;
                                    $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                    $this->WalletRepository->updateWallet($uid, $walletDetails);

                                    return response()->json([
                                        'success'       => false,
                                        'statusCode'    => 500,
                                        'message'       => 'Error Occured, try later !!!'
                                    ]);

                                }
                            }else{

                                return response()->json([
                                    'success'       => false,
                                    'statusCode'    => 500,
                                    'message'       => 'Internal Server Error, Please Retry !!!'
                                ]);

                            }

                        }

                        // return $response;
                    }

                }elseif($request->top_up ==2){

                    if($LoanCountry){

                        if($req_bal_process >= 100){

                            return response()->json([
                                'success'       => false,
                                'statusCode'    => 500,
                                'message'       => 'Your Balance Is Still High, You Cannot Loan At This Time !!!'
                            ]);

                        }else{

                            // Processing Loan Nigeria Data
                            if($request->country == 'NG'){

                                $new_loanBal_process = $req_loanBal_process + $amount;
                                $walletDetails = [ 'loan_balance' => $new_loanBal_process, 'updated_at'=> NOW() ];
                                $this->WalletRepository->updateWallet($uid, $walletDetails);
                                $phoneNumber = str_replace('234', '0', $request->phoneNumber);

                                // dd($amount);
                                $DataDetails = [
                                    'request_id'        => $requestID,
                                    'serviceID'         => $network,
                                    'amount'            => $actAmt,
                                    'phone'             => $phoneNumber,
                                ];
                                // dd($requestID);
                                // Store returned data in DB
                                $createNigData = json_decode( $this->AirtimeRepository->createVTPassAirtime($DataDetails) );
                                //  return $createNigData;

                                if ($createNigData->code == '000') {
                                    // Store returned data in DB
                                    $HistoryDetails = [
                                        'user_id'               =>  $uid,
                                        'plan'                  =>  $createNigData->content->transactions->product_name,
                                        'purchase'              =>  'Airtime',
                                        'country_code'          =>  $request->country,
                                        'operator_code'         =>  $network,
                                        'product_code'          =>  'VTU',
                                        'transfer_ref'          =>  $createNigData->content->transactions->transactionId,
                                        'phone_number'          =>  $createNigData->content->transactions->unique_element,
                                        'distribe_ref'          =>  $createNigData->requestId,
                                        'selling_price'         =>  $amount,
                                        'receive_value'         =>  $createNigData->amount,
                                        'send_value'            =>  $actAmt,
                                        'receive_currency'      =>  'NGN',
                                        'commission_applied'    =>  $createNigData->content->transactions->commission,
                                        'startedUtc'            =>  NOW(),
                                        'completedUtc'          =>  NOW(),
                                        'processing_state'      =>  $createNigData->content->transactions->status,
                                        'repayment'             =>  $repayment,
                                        'payment_status'        =>  'pending',
                                        'due_date'              =>  $request->loan_term
                                    ];
                                    $query = $this->LoanHistoryRepository->createLoanHistory($HistoryDetails);

                                    if($query){

                                        return response()->json([
                                            'success'       => true,
                                            'statusCode'    => 200,
                                            'message'       => 'You Loan '. $phoneNumber. ' With '. number_format($actAmt). ' NGN Airtime'
                                        ]);

                                    }else{

                                        return response()->json([
                                            'success'       => false,
                                            'statusCode'    => 500,
                                            'message'       => 'Transaction Failed !!!'
                                        ]);

                                    }

                                } else if( $createNigData->code == '016' ){

                                    $new_bal_process = $req_bal_process + $amount;
                                    $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                    $this->WalletRepository->updateWallet($uid, $walletDetails);

                                    return response()->json([
                                        'success'       => false,
                                        'statusCode'    => 500,
                                        'message'       => 'Transaction Failed, Please Try Later !!!'
                                    ]);

                                } else {

                                    $new_bal_process = $req_bal_process + $amount;
                                    $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                    $this->WalletRepository->updateWallet($uid, $walletDetails);

                                    return response()->json([
                                        'success'       => false,
                                        'statusCode'    => 500,
                                        'error'         => $createNigData,
                                        'message'       => 'Transaction Failed, Unknown Error Occurered, Try Later'
                                    ]);
                                }

                            }else{
                                $DataDetails = [
                                    'SkuCode'           => $network,
                                    'SendValue'         => $actAmt,
                                    'SendCurrencyIso'   => 'USD',
                                    'AccountNumber'     => $request->phoneNumber,
                                    'DistributorRef'    => $request->DistributorRef,
                                    'ValidateOnly'      => false,
                                    'RegionCode'        => $network
                                ];
                                $response = $this->AirtimeRepository->createIntAirtime($DataDetails);
                                // return $response;
                                if($response['ResultCode'] ==1){
                                    $HistoryDetails = [
                                        'user_id'               =>  $uid,
                                        'plan'                  =>  $actAmt,
                                        'purchase'              =>  'Airtime',
                                        'country_code'          =>  $request->country,
                                        'operator_code'         =>  $network,
                                        'product_code'          =>  $network,//$skuCode
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

                                        return response()->json([
                                            'success'       => true,
                                            'statusCode'    => 200,
                                            'message'       => 'Succeeded !!!'
                                        ]);

                                    }else{

                                        return response()->json([
                                            'success'       => false,
                                            'statusCode'    => 500,
                                            'message'       => 'ITransaction Failed !!!'
                                        ]);

                                    }

                                }
                            }

                        }

                    }else{

                        return response()->json([
                            'success'       => false,
                            'statusCode'    => 500,
                            'message'       => 'Sorry, loan is not available in the selected country !!!'
                        ]);

                    }


                }else{

                    return response()->json([
                        'success'       => false,
                        'statusCode'    => 500,
                        'message'       => 'Invalid Selection, Please Make a Choice !!!'
                    ]);

                }

            }else{

                return response()->json([
                    'success'       => false,
                    'statusCode'    => 500,
                    'message'       => 'Incorrect PIN !!!'
                ]);

            }
        }
        else
        {

            return response()->json([
                'success'       => false,
                'statusCode'    => 500,
                'message'       => 'Complete Account Verification !!!'
            ]);

        }
        // PIN Validation



    }

    public function findUser()
    // :JsonResponse
    {
        return $this->AirtimeRepository->findUser();
        // return response()->json(null, Response::HTTP_NO_CONTENT);
        // return response()->json([
        //     'data' => $this->AirtimeRepository->findUser()
        // ]);


    }

    public function token()
    {
        $DataDetails = [
            'client_id'=> '919c366c-4645-46f8-80cc-35c77040014b',
            'client_secret' => '71apN0bg3CXO7ACVWe9mjjaibZu6sd4uC0VA2rH10GI=',
            'grant_type' => 'client_credentials'
        ];
        return $this->AirtimeRepository->getToken($DataDetails);
    }
}
