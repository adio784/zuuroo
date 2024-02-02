<?php

namespace App\Http\Controllers;



use App\Repositories\LoanHistoryRepository;
use App\Repositories\HistoryRepository;
use App\Repositories\WalletRepository;
use App\Repositories\DataRepository;
use App\Repositories\UserRepository;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;


use App\Models\Country;
use App\Models\Kyc;
use App\Models\Plan;
use App\Models\Product;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{

    private $DataRepository;
    private $HistoryRepository;
    private $LoanHistoryRepository;
    private $UserRepository;
    private $WalletRepository;

    public function __construct(DataRepository $DataRepository,
                                HistoryRepository $HistoryRepository,
                                LoanHistoryRepository $LoanHistoryRepository,
                                UserRepository $UserRepository,
                                WalletRepository $WalletRepository)
    {
        $this->DataRepository = $DataRepository;
        $this->HistoryRepository = $HistoryRepository;
        $this->LoanHistoryRepository = $LoanHistoryRepository;
        $this->UserRepository = $UserRepository;
        $this->WalletRepository = $WalletRepository;
    }


    public function createData(Request $request)
    {
        // -----------------------VARIABLE RE_DELARATION --------------------------------------------------------------
        $uid = Auth::user()->id;
        $uemail = Auth::user()->email;
        $repayment = date('Y-m-d');
        $uname = Auth::user()->name;
        $Username = Auth::user()->username;
        $uphone = Auth::user()->mobile;
        $UserPlan = $Username.' weekly loan';
        $LoanAmount = $request->repayment;
        $originalDate = date('Y-m-d'); // Your original date
        $daysToAdd = $request->loan_term; // Number of days to add
        $newDate = date("Y-m-d", strtotime("+" . $daysToAdd . " days"));
        // GLNG | MTNG | ZANG | ETNG
        $network = "";
        $customer_ref = 'ZR_'.rand(99, 999999);
        $destributor_ref = 'TRN' . strtoupper(uniqid()); //$request->DistributorRef

        // ---------------------------------NETWORK MANAGEMENT -------------------------------------------------------
        if($request->network_operator == 'mtn'){ $network = 1;}
        elseif($request->network_operator == 'airtel'){ $network = 4;}
        elseif($request->network_operator == 'glo'){ $network = 2;}
        elseif($request->network_operator == 'etisalat'){ $network = 3;}
        else{ $network = $request->network_operator; }
        // ------------------------------------------------------------------------------------------------------------

        // -----------------------------------GET PROUCT DETAILS --------------------------------------------------------
        if($request->country == 'NG'){
            $prdD = Product::where('product_code', $request->data_plan)->first();
            $skuCode = $prdD->product_code;
            $product_price =$prdD->product_price;
            $sendValue =$prdD->send_value;
            $product_name =$prdD->product_name;
        }
        else{
            // return $request->data_plan;
            $arrayData = explode(",", $request->data_plan);
            $skuCode = $arrayData[0];
            $product_price = $arrayData[1];
            $sendValue = $arrayData[2];
            $data_plan = $arrayData[2];
            // return $request->country;
        }
        // ------------------------------------------------------------------------------------------------------------

        // -------------------------------WALLET BALANCE ------------------------------------------------------------

        $req_Account_process = $this->WalletRepository->getWalletBalance($uid);
        $req_bal_process = $req_Account_process->balance;
        $req_loanBal_process = $req_Account_process->loan_balance;

        // -------------------------------USER / LOAN ----------------------------------------------------------------
        $user = $this->UserRepository->getUserById($uid);
        $LoanCountry = Country::where('is_loan', true)->where('country_code', $request->country)->first();
        // -----------------------------------------------------------------------------------------------------------

        // -------------------------------- KYC ------------------------------------------------------------------------
        $Kyc = Kyc::where('user_id', $uid)->first();

        // -----------------------------------------------------------------------------------------------------------

        // ------------------------------- CHECK KYC DETAILS ------------------------------------------------------------

        // Check if user complete email verification -----------------------------------------------------------------------

        if(Hash::check($request->pin, $user->create_pin)){
            if($user->email_verified_at !="" && $user->number_verify_at != "")
            {

                // Check what user want to purchase loan/topup --------------------------------------------------------------------------
                // Topup Service ------------------------------------------
                if($request->top_up == 1){

                    $request->validate([
                        'top_up'            =>  'required',
                        'country'           =>  'required',
                        'phoneNumber'       =>  'required',
                        'network_operator'  =>  'required',
                        'data_plan'         =>  'required'
                    ]);

                    // $network
                    // Processing Nigeria Data
                    if($request->country == 'NG'){

                        if($req_bal_process < $product_price){

                            return response()->json([
                                'success'       => false,
                                'statusCode'    => 500,
                                'message'       => 'Insufficient fund !!!'
                            ]);

                        }else{

                            // Update Wallet Balance ---------------------------------------------------
                            $new_bal_process = $req_bal_process - $product_price;
                            $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                            $this->WalletRepository->updateWallet($uid, $walletDetails);
                            // -------------------------------------------------------------------------

                            $phoneNumber = str_replace('234', '0', $request->phoneNumber);
                            $DataDetails = [
                                'network'       => $network, //1
                                'mobile_number' => $phoneNumber, //"09037346247",
                                'plan'          => $skuCode,//6,
                                'Ported_number' => true
                            ];

                            $createNigData = json_decode( $this->DataRepository->createNgData($DataDetails) );
                            // return $createNigData;
                            if( !$createNigData ){

                                // If error occur from APi --------------------------------------------------
                                $new_bal_process = $req_bal_process + $product_price;
                                $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                $this->WalletRepository->updateWallet($uid, $walletDetails);

                                return response()->json([
                                    'success'       => false,
                                    'statusCode'    => 500,
                                    'message'       => 'Internal Server Error, Please Try Later !!!'
                                ]);

                                // --------------------------------------------------------------------------

                            }else{
                                // return $createNigData;
                                // Store returned data in DB ---------------------------------------------------
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
                                // ------------------------------------------------------------------------------

                                if($query){

                                    return response()->json([
                                        'success'       => true,
                                        'statusCode'    => 200,
                                        'message'       => 'Your recharge of '. $createNigData->plan_name . ' has been sent to '. $createNigData->mobile_number
                                    ]);

                                }else{

                                    return response()->json([
                                        'success'       => false,
                                        'statusCode'    => 500,
                                        'message'       => 'Transaction Failed !!!'
                                    ]);

                                }
                            }

                        }
                    }
                    // Processing Other Countries Data
                    else{

                        // Check wallet balance ------------------------------------------------------------
                        if($req_bal_process < $product_price){

                            return response()->json([
                                'success'       => false,
                                'statusCode'    => 500,
                                'message'       => 'Insufficient fund !!!'
                            ]);

                        }else{

                            $new_bal_process = $req_bal_process - $product_price;
                            $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                            $wallet_update = $this->WalletRepository->updateWallet($uid, $walletDetails);

                            // return $new_bal_process;
                            if($wallet_update)
                            {

                                // Data Api Arrays
                                $DataDetails = [
                                    'SkuCode'           => $skuCode,
                                    'SendValue'         => $product_price,
                                    'SendCurrencyIso'   => 'USD',
                                    'AccountNumber'     => $request->phoneNumber,
                                    'DistributorRef'    => $destributor_ref,
                                    'ValidateOnly'      => false,
                                    'RegionCode'        => $network
                                ];
                                // return $data_plan;
                                $response = json_decode( $this->DataRepository->createIntData($DataDetails) );

                                if( isset($response->ResultCode) && $response->ResultCode ==1 ){
                                    // return $request->data_plan;
                                    $HistoryDetails = [
                                        'user_id'               =>  $uid,
                                        'plan'                  =>  $data_plan, //$response->TransferRecord->ReceiptText,
                                        'purchase'              =>  'data',
                                        'country_code'          =>  $request->country,
                                        'operator_code'         =>  $network,
                                        'product_code'          =>  $skuCode,
                                        'transfer_ref'          =>  $response->TransferRecord->TransferId->TransferRef,
                                        'phone_number'          =>  $request->phoneNumber,
                                        'distribe_ref'          =>  $response->TransferRecord->TransferId->DistributorRef,
                                        'selling_price'         =>  '',
                                        'receive_value'         =>  $response->TransferRecord->Price->ReceiveValue,
                                        'send_value'            =>  $response->TransferRecord->Price->SendValue,
                                        'receive_currency'      =>  $response->TransferRecord->Price->SendCurrencyIso,
                                        'commission_applied'    =>  $response->TransferRecord->CommissionApplied,
                                        'startedUtc'            =>  $response->TransferRecord->StartedUtc,
                                        'completedUtc'          =>  $response->TransferRecord->CompletedUtc,
                                        'processing_state'      =>  $response->TransferRecord->ProcessingState,
                                    ];
                                    $query = $this->HistoryRepository->createHistory($HistoryDetails);
                                    if($query){
                                        // use Alert;
                                        return response()->json([
                                            'success'       => true,
                                            'statusCode'    => 200,
                                            'message'       => 'You\'ve Purchase '.$request->phoneNumber. ' With '. $product_name

                                        ]);

                                    }else{

                                        return response()->json([
                                            'success'       => false,
                                            'statusCode'    => 500,
                                            'message'       => 'Transaction Failed !!!'
                                        ]);

                                    }

                                }else{

                                    $new_bal_process = $req_bal_process + $product_price;
                                    $walletDetails = [ 'balance' => $new_bal_process, 'updated_at'=> NOW() ];
                                    $this->WalletRepository->updateWallet($uid, $walletDetails);

                                    return response()->json([
                                        'success'       => false,
                                        'statusCode'    => 400,
                                        'message'       => 'Request Could Not Be Completed !!!'
                                    ]);

                                }
                            }else{

                                return response()->json([
                                    'success'       => false,
                                    'statusCode'    => 500,
                                    'message'       => 'Internal Server Error, Try Later !!!'
                                ]);

                            }

                        }
                    }
                }

                // Loan Service ----------------------------------------------
                elseif($request->top_up == 2){

                    $request->validate([
                        'top_up'            =>  'required',
                        'country'           =>  'required',
                        'phoneNumber'       =>  'required',
                        'network_operator'  =>  'required',
                        'data_plan'         =>  'required',
                        'loan_term'         =>  'required',
                        'repayment'         =>  'required',
                    ]);

                    // check if user complete Kyc---------------------------------------------------------------------------
                    if($Kyc){
                        if($Kyc->verificationStatus == 1)
                        {
                            // Check if user already exist in loan table ---------------------------------------------------
                            $isLoan = $this->LoanHistoryRepository->getUserLoan($uid);
                            // --------------------------------------------------------------------------------------------
                            if ( empty($isLoan) ) {

                                if($req_bal_process >= 40){

                                    return response()->json([
                                        'success'       => false,
                                        'statusCode'    => 500,
                                        'message'       => 'Your Balance Is Still High, You Cannot Loan At This Time !!!'
                                    ]);

                                }else{

                                    if($request->country == 'NG'){

                                        // Update wallet balance -----------------------------------------------------------------
                                        $new_loanBal_process = $req_loanBal_process + $product_price;
                                        $walletDetails = [ 'loan_balance' => $new_loanBal_process, 'updated_at'=> NOW() ];
                                        $this->WalletRepository->updateWallet($uid, $walletDetails);
                                        // ----------------------------------------------------------------------------------------

                                        $phoneNumber = str_replace('234', '0', $request->phoneNumber);

                                        $DataDetails = [
                                            'network'       => $network, //1
                                            'mobile_number' => $phoneNumber, //"09037346247",
                                            'plan'          => $skuCode,//6,
                                            'Ported_number' => true
                                        ];

                                        $createNigData = json_decode($this->DataRepository->createNgData($DataDetails));
                                        // return $createNigData;
                                        // return response()->json([
                                        //             'success'       => false,
                                        //             'statusCode'    => 500,
                                        //             'message'       => $createNigData
                                        //         ]);

                                        if( $createNigData && isset($createNigData->plan_name) ){
                                            // Store returned data in DB ------------------------------------------------------------

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
                                                'repayment'             =>  $newDate,
                                                'loan_amount'           =>  $LoanAmount,
                                                'due_date'              =>  $daysToAdd . " days",
                                                'payment_status'        =>  'pending'
                                            ];
                                            $query = $this->LoanHistoryRepository->createLoanHistory($HistoryDetails);
                                            // -------------------------------------------------------------------------------------

                                            if($query){

                                                return response()->json([
                                                    'success'       => true,
                                                    'statusCode'    => 200,
                                                    'message'       => 'Your loan of '. $createNigData->plan_name . ' has been sent to '. $createNigData->mobile_number
                                                ]);

                                            }else{

                                                return response()->json([
                                                    'success'       => false,
                                                    'statusCode'    => 500,
                                                    'message'       => 'Loan Request Failed !!!'
                                                ]);

                                            }

                                        }else{

                                            $new_loanBal_process = $req_loanBal_process - $product_price;
                                            $walletDetails = [ 'loan_balance' => $new_loanBal_process, 'updated_at'=> NOW() ];
                                            $this->WalletRepository->updateWallet($uid, $walletDetails);

                                            return response()->json([
                                                'success'       => false,
                                                'statusCode'    => 500,
                                                'message'       => 'Your request could not be completed, try later !!!'
                                            ]);

                                        }
                                    }else{
                                        $DataDetails = [
                                            'SkuCode'           => $skuCode,
                                            'SendValue'         => $product_price ,
                                            'SendCurrencyIso'   => 'USD',
                                            'AccountNumber'     => $request->phoneNumber,
                                            'DistributorRef'    => $destributor_ref,
                                            'ValidateOnly'      => false,
                                            'RegionCode'        => $network
                                        ];

                                        $response = json_decode( $this->DataRepository->createIntData($DataDetails) );


                                        if( isset($response->ResultCode) && $response->ResultCode ==1 ){

                                            $HistoryDetails = [
                                                'user_id'               =>  $uid,
                                                'plan'                  =>  $data_plan,//$response->TransferRecord->ReceiptText,
                                                'purchase'              =>  'Data',
                                                'country_code'          =>  $request->country,
                                                'operator_code'         =>  $network,
                                                'product_code'          =>  $skuCode,
                                                'transfer_ref'          =>  $response->TransferRecord->TransferId->TransferRef,
                                                'phone_number'          =>  $request->phoneNumber,
                                                'distribe_ref'          =>  $response->TransferRecord->TransferId->DistributorRef,
                                                'selling_price'         =>  '',
                                                'receive_value'         =>  $response->TransferRecord->Price->ReceiveValue,
                                                'send_value'            =>  $response->TransferRecord->Price->SendValue,
                                                'receive_currency'      =>  $response->TransferRecord->Price->SendCurrencyIso,
                                                'commission_applied'    =>  $response->TransferRecord->CommissionApplied,
                                                'startedUtc'            =>  $response->TransferRecord->StartedUtc,
                                                'completedUtc'          =>  $response->TransferRecord->CompletedUtc,
                                                'processing_state'      =>  $response->TransferRecord->ProcessingState,
                                                'repayment'             =>  $newDate,
                                                'loan_amount'           =>  $LoanAmount,
                                                'payment_status'        =>  'pending',
                                                'due_date'              =>  $daysToAdd . " days",
                                            ];
                                            $query = $this->LoanHistoryRepository->createLoanHistory($HistoryDetails);

                                            if($query){

                                                return response()->json([
                                                    'success'       => true,
                                                    'statusCode'    => 200,
                                                    'message'       => 'You\'ve Loan '.$request->phoneNumber. ' With '. $response['TransferRecord']['ReceiptText']
                                                ]);

                                            }else{

                                                return response()->json([
                                                    'success'       => false,
                                                    'statusCode'    => 500,
                                                    'message'       => 'Loan Request Failed !!!'
                                                ]);

                                            }


                                        }
                                    }

                                }

                            }
                            else{

                                return response()->json([
                                    'success'       => false,
                                    'statusCode'    => 500,
                                    'message'       => 'You have an outstanding debt !!!'
                                ]);

                            }
                        }
                        else
                        {

                            return response()->json([
                                'success'       => false,
                                'statusCode'    => 500,
                                'message'       => 'Verification Status Is Still Pending !!!'
                            ]);
                        }
                    }
                    else {

                        return response()->json([
                            'success'       => false,
                            'statusCode'    => 500,
                            'message'       => 'Kindly proceed to kyc page !!!'
                        ]);

                    }
                }
                else{

                    return response()->json([
                        'success'       => false,
                        'statusCode'    => 500,
                        'message'       => 'Invalid Selection, Please Make a Choice !!!'
                    ]);
                }
            }
            else{

                return response()->json([
                    'success'       => false,
                    'statusCode'    => 500,
                    'message'       => 'Complete Account Verification !!!'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success'       => false,
                'statusCode'    => 500,
                'message'       => 'Incorrect PIN !!!'
            ]);
        }


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
// PLN_vd60whbohphe495
