<?php

namespace App\Http\Controllers;

use Monolog\Logger;
use App\Interfaces\PaystackRepositoryInterface;
use App\Interfaces\PaymentRepositoryInterface;
use App\Interfaces\WalletRepositoryInterface;
use App\Notifications\WebhookNotification;
use App\Models\RecurringCharge;
use App\Models\User;
use App\Models\Wallet;
use App\Models\History;
use App\Models\LoanHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;


use App\Models\Payment;
use Carbon\Carbon;


class PaystackController extends Controller
{
    private PaystackRepositoryInterface $PaystackRepository;
    private PaymentRepositoryInterface $PaymentRepository;
    private WalletRepositoryInterface $WalletRepository;

    public function __construct(PaystackRepositoryInterface $PaystackRepository, PaymentRepositoryInterface $PaymentRepository, WalletRepositoryInterface $WalletRepository)
    {
        $this->PaystackRepository = $PaystackRepository;
        $this->PaymentRepository = $PaymentRepository;
        $this->WalletRepository = $WalletRepository;
    }

    public function processPayment(Request $request)
    {
        $amount = $request->pay_amount * 100;
        $reference = rand();
        $PaymentDetails = [
            'email'         =>  $request->email,
            'amount'        =>  $amount,
            'reference'     =>  $reference,
            'trxref'        =>  ''
        ];
        $response = $this->PaystackRepository->processPayment($PaymentDetails);
        // return $response;
        if($response['status'] == true)
        {
            $payment_url = $response['data']['authorization_url'] ;
            return redirect($payment_url);
        }else{
            return back()->with('fail', 'Something went wrong, payment could not be processed');
        }

        // Store returned data in DB
    }

    public function verfifyPayment(Request $request)
    {
        $PaymentRef = $request->reference;
        $response = $this->PaystackRepository->verifyPayment($PaymentRef);
        if($response['status'] == true)
        {
            return redirect('funds')->with('success', 'Payment Processed ...');
            // return redirect('/verify_webhook_payment');
        }else{
            return back()->with('fail', 'Something went wrong, payment could not be processed');
        }

    }

    public function verifyWebhookPaystack(Request $request)
    {

        $body = $request->all();

        // Log::debug('An informational message.');
        // Log::debug(['Data Received' => $body]) ;
         //amount //email prevent multiple pending payments
        // $email = $request->input('data.customer.email');
        // $amountpaid = ($request->input('data.amount'))/100;

        // $user_id = User::where('email', $email)->firstOrFail()->id;
        // $user = User::find($user_id);
        // Log::error($email);

        $response = json_encode($body);
        $data = json_decode($response);
        if ($data->event == "charge.success") {

            $PaymentRef = $data->data->reference;
            $deposit = $this->PaymentRepository->getPaymentByRef($PaymentRef);
            if ($deposit == null) {
                // Logger(['Data Receieved' => $body]);
                $email      = $data->data->customer->email; //$request->input('data.customer.email');
                $amt        = ($data->data->amount / 100);

                if ( $amt > 50 ) {

                    $amount     = $amt- 50;
                    $user       = User::where('email', $email)->first();
                    $user_id    = $user->id;
                    $userWallet = Wallet::where('user_id', $user_id)->first();
                    $newBal     = $amount + $userWallet->balance;

                    $userLoan   = LoanHistory::where('user_id', $user_id)
                                               ->where('payment_status', 'pending')
                                               ->orWhere('payment_status', 'partially')
                                               ->where('processing_state', 'successful')
                                               ->first();

                    if ( $user ) {

                        //Deposit Payment amount to Deposit
                        $PaymentDetails = [
                            'user_id'       =>  $user_id,
                            'currency'      =>  $data->data->currency,
                            'reference'     =>  $data->data->reference,
                            'amount'        =>  $amount,
                            'payment_id'    =>  $data->data->id,
                            'message'       =>  $data->data->gateway_response,
                            'payment_mode'  =>  'Paystack',
                            'status'        =>  $data->data->status
                        ];
                        $deposited = $this->PaymentRepository->createPayment($PaymentDetails);
                        if($deposited){

                            // Check if user is oweing ...................................................
                            if( $userLoan != "" )
                            {
                                Logger(['AmountFund'=>$amount]);
                                Logger(['LoanRecord'=>$userLoan]);
                                $loanAmountToPay = $userLoan->loan_amount;
                                if( $amount > $loanAmountToPay )
                                {
                                    $new_loanBal = $amount - $loanAmountToPay;
                                    LoanHistory::where('user_id', $user_id)->update(['payment_status' => 'paid', 'loan_amount'=> 0, 'amount_paid'=>$userLoan->amount_paid+$loanAmountToPay ]);
                                    $WalletDetails = [
                                        'loan_balance'   => 0,
                                        'balance'        => $userWallet->balance + $new_loanBal,
                                    ];
                                    $this->WalletRepository->updateWallet($user_id, $WalletDetails);
                                    return back()->with('success', 'Payment Successful And Used To Settle Your Outstanding Loan' );
                                }
                                else
                                {

                                    $new_loanBal = $loanAmountToPay - $amount;
                                    LoanHistory::where('user_id', $user_id)->update(['payment_status' => 'partially', 'loan_amount'=> $new_loanBal, 'amount_paid'=>$userLoan->amount_paid+$amount ]);
                                    return back()->with('success', 'Payment Successful And Used To Cover Part Of Your Outstanding Loan. You Are Still Oweing'.$new_loanBal );
                                }
                            }
                            else
                            {
                                $WalletDetails = [
                                    'balance'   => $newBal
                                ];
                                $this->WalletRepository->updateWallet($user_id, $WalletDetails);
                                return back()->with('success', 'Payment Successful, account credited');
                            }

                        }else{
                            return back()->with('fail', 'Payment could not be completed');
                        }
                        http_response_code(200);
                    }
                }
            }

        }
        else{
            http_response_code(200);
        }
    }


    // Verify Monnify Webhook Payment
    public function verifyMonifyWebhookPayment(Request $request)
    {

        $body = $request->all();


        $response = json_encode($body);
        $data = json_decode($response);
        if ($data->eventType == 'SUCCESSFUL_TRANSACTION') {
            Log::debug(['Data Received' => $body]) ;
            $PaymentRef = $data->eventData->product->reference;
            $deposit    = $this->PaymentRepository->getPaymentByRef($PaymentRef);
            if ( Payment::where('reference', $PaymentRef)->count() < 1 ) {
                Log::debug(['Data Sucess' => 'Reference DO Not Exist'.$deposit ]) ;
                $uid        = $data->eventData->customer->email; //$request->input('eventData.customer.email');
                $amt        = ($data->eventData->amountPaid / 100);

                if ( $amt > 50 ) {
                    Log::debug(['Data Sucess' => 'Amount Greater than 50 Naira']) ;
                    $amount     = $amt - 50;
                    $user       = User::where('email', $uid)->first();


                    if ( $user ) {
                        Log::debug(['Data Received' => $body]) ;

                        $Userid     = $user->id;
                        $userWallet = Wallet::where('user_id', $Userid)->first();
                        $newBal     = $userWallet->balance + $amount;


                        //Deposit Payment amount to Deposit
                        $PaymentDetails = [
                            'user_id'       =>  $Userid ,
                            'currency'      =>  $data->eventData->currency,
                            'reference'     =>  $data->eventData->transactionReference,
                            'amount'        =>  $amount,
                            'payment_id'    =>  $data->eventData->paymentReference,
                            'message'       =>  $data->eventData->paymentMethod,
                            'payment_mode'  =>  'Monnify',
                            'status'        =>  $data->eventData->paymentStatus
                        ];
                        $deposited = $this->PaymentRepository->createPayment($PaymentDetails);

                        if ($deposited) {
                            Log::debug(['Data Sucess' => 'User Payment Deposited']) ;

                            // Check if user is oweing ...................................................
                            $userLoan = LoanHistory::where('user_id', $Userid)
                                                ->where('payment_status', 'pending')
                                                ->orWhere('payment_status', 'partially')
                                                ->where('processing_state', 'successful')
                                                ->first();

                            if( $userLoan != "[]" )
                            {

                                Log::debug(['Data Success' => 'User is Oweing us']) ;
                                $loanAmountToPay = $userLoan->loan_amount;
                                if( $amount > $loanAmountToPay )
                                {
                                    Log::debug(['Data Success' => 'Payment Successful And Used To Settle Your Outstanding Loan' ]) ;
                                    $new_loanBal = $amount - $loanAmountToPay;
                                        LoanHistory::where('user_id', $Userid)->update(['payment_status' => 'paid', 'loan_amount'=> 0, 'amount_paid'=>$userLoan->amount_paid+$loanAmountToPay ]);
                                    $WalletDetails = [
                                        'loan_balance'   => 0,
                                        'balance'        => $userWallet->balance + $new_loanBal,
                                    ];
                                    $this->WalletRepository->updateWallet($Userid, $WalletDetails);
                                }
                                else
                                {

                                    $new_loanBal = $loanAmountToPay - $amount;
                                    LoanHistory::where('user_id', $Userid)->update(['payment_status' => 'partially', 'loan_amount'=> $new_loanBal, 'amount_paid'=>$userLoan->amount_paid+$amount ]);
                                    Log::debug(['Data Error' => 'Payment Successful And Used To Cover Part Of Your Outstanding Loan. You Are Still Oweing'.$new_loanBal]) ;

                                }
                            }
                            else
                            {
                                $WalletDetails = [
                                    'balance'   => $newBal
                                ];
                                $this->WalletRepository->updateWallet($Userid, $WalletDetails);
                                Log::debug(['Data Error' => 'User Not Oweing Us, ANd Payment Successful, account credited']) ;

                            }


                        }else{

                            Log::debug(['Data Error' => 'Payment could not be completed']) ;

                        }
                        http_response_code(200);
                    } else {
                        Log::debug(['Data Error' => 'User not found !!!']) ;
                    }
                } else {
                    Log::debug(['Data Error' => 'Amout less than 50 Naira']) ;
                }
            } else {
                Log::debug(['Data ' => $body]) ;
                Log::debug(['Data Not Received' => $deposit ]) ;
            }

        }
        else{
            http_response_code(200);
        }
    }



// Verify recuring iitialization
    public function verifyRecurryInit(Request $request)
    {
        $body       =   $request->all();
        $PaymentRef =   $request->reference;
        $response   =   $this->PaystackRepository->verifyPayment($PaymentRef);
        $data       =   json_decode($response);
        $uemail     =   $data->data->customer->email;
        $uid        =   Auth::user()->id;
        // return $data;
        Logger(['Reccuring Data Receieved' => $data]);
        if ($data->status == true)
        {
            // return $data;
            $checkRecc = RecurringCharge::where('user_email', $uemail)->where('status', 0)->first();

            if( $checkRecc == null )
            {

                $Details =   [
                    'user_id'               =>  $uid ,
                    'user_email'            =>  $uemail,
                    'authorization_code'    =>  $data->data->authorization->authorization_code,
                    'account_name'          =>  $data->data->authorization->account_name,
                    'account_number'        =>  $data->data->authorization->bin,
                    'bank_name'             =>  $data->data->authorization->bank,
                    'country_code'          =>  $data->data->authorization->country_code,
                    'card_type'             =>  $data->data->authorization->card_type,
                    'last4'                 =>  $data->data->authorization->last4,
                    'exp_month'             =>  $data->data->authorization->exp_month,
                    'exp_year'              =>  $data->data->authorization->exp_year,
                    'bin'                   =>  $data->data->authorization->bin,
                    'channel'               =>  $data->data->authorization->channel,
                    'signature'             =>  $data->data->authorization->signature,
                    'reusable'              =>  $data->data->authorization->reusable,
                    'status'                =>  $data->status,
                ];

                $saveReccur =   RecurringCharge::create($Details);

                if($saveReccur)
                {
                    return redirect('/home')->with('success', 'Successfully Added !!!');
                }
                else
                {
                    return redirect('/home')->with('fail', 'Unable to add record !!!');
                }

            }
            else
            {
                return redirect('/home')->with('fail', 'An Error Occured !!!');
            }

        }
    }


    public function checkRecurring(){

        date_default_timezone_set("Africa/Lagos");
        $requestID  = date('YmdHi').rand(99, 9999999);
        $currentDate    =   Carbon::now()->toDateString();
        $recurrUsers    =  History::join('operators', 'histories.operator_code', 'operators.operator_code')
                            ->join('countries', 'histories.country_code', 'countries.country_code')
                            ->select(
                                'histories.id as history_id', // Use an alias to distinguish between IDs
                                'histories.plan',
                                'histories.phone_number',
                                'histories.selling_price',
                                'histories.receive_currency',
                                'histories.purchase',
                                'histories.transfer_ref',
                                'histories.selling_price',
                                'histories.receive_value',
                                'histories.commission_applied',
                                'histories.processing_state',
                                'histories.created_at',
                                 DB::raw('CAST(histories.created_at AS DATETIME) as created_at'), // Cast created_at to DATETIME
                                'operators.operator_name',
                                'countries.country_name'
                            )
                            ->groupBy('history_id')
                            ->distinct()
                            ->orderBy('created_at', 'DESC')
                            ->get();

                            // RecurringCharge::join('loan_histories', 'loan_histories.user_id', 'recurring_charges.user_id')
                            // ->where(function ($query) {
                            //     $query->where('loan_histories.payment_status', 'pending')
                            //         ->orWhere('loan_histories.payment_status', 'partially');
                            // })
                            // ->whereDate('repayment', '<=', $currentDate)
                            // ->select('loan_histories.user_id', 'loan_histories.loan_amount', 'recurring_charges.authorization_code', 'recurring_charges.user_email', 'loan_histories.repayment')
                            // ->distinct()
                            // ->get();
        echo $requestID;
        // RecurringCharge::join('loan_histories', 'loan_histories.user_id', 'recurring_charges.user_id')
        //                                     ->where('loan_histories.payment_status', 'pending')
        //                                     ->orWhere('payment_status', 'partially')
        //                                     // ->orWhere('loan_histories.payment_status', 'partially')
        //                                     ->whereDate('repayment', '<=', $currentDate )
        //                                     ->select('loan_histories.user_id', 'loan_histories.loan_amount', 'recurring_charges.authorization_code', 'recurring_charges.user_email', 'loan_histories.repayment')
        //                                     ->distinct()
        //                                     ->get();
                // echo $currentDate;
                // return $recurrUsers;
        $allDetails = [];
        // if($recurrUsers != [] ){

        //     foreach ($recurrUsers as $rUser) {

        //         $details    =   [
        //             "authorization_code"    => $rUser->authorization_code,
        //             "email"                 => $rUser->user_email,
        //             "amount"                => $rUser->loan_amount * 100,
        //         ];

        //         $allDetails = $details;

        //         return $recurrUsers;
        //         $response   =   $this->PaystackRepository->charge_recurring($details);
        //         $data       =   json_decode( $response );
        //         $uid        =   $rUser->user_id;

        //         if( $data->status == true) {

        //             Payment::create([
        //             'user_id'       =>  $uid,
        //             'currency'      =>  $data->data->currency,
        //             'reference'     =>  $data->data->reference,
        //             'amount'        =>  $data->data->amount / 100,
        //             'payment_id'    =>  $data->data->id,
        //             'message'       =>  'Loan Repayment',
        //             'payment_mode'  =>  'Paystack',
        //             ]);
        //             // return Log::info($recurrUsers->user_email);

        //             LoanHistory::where('user_id', $uid)->update([ 'payment_status' => 'paid', 'amount_paid' => $data->data->amount / 100, 'loan_amount' => 0  ]);
        //             // Logger(['Reccuring Hour Charge' => $data]);
        //             Log::info('Recurring Hour Charged', ['data' => $data]);
        //             echo "Success";

        //         }

        //     }


        // }

    }



}
