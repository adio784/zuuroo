<?php

namespace App\Console\Commands;

use App\Models\LoanHistory;
use App\Models\Payment;
use App\Models\RecurringCharge;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use App\Repositories\PaystackRepository;
use Illuminate\Support\Facades\Mail;

class HourlyCharge extends Command
{
    private $PaystackRepository;

    public function __construct(PaystackRepository $PaystackRepository)
    {
        $this->PaystackRepository = $PaystackRepository;
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hour:charge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Charge Recurring Hourly';

    /**
     * Execute the console command.
     *
     * @return int
     */


    public function handle12()
    {
        $currentDate    =   Carbon::now()->toDateString();
        $user = User::whereDate('created_at', '<=', $currentDate )->limit(10)->get();
        foreach ($user as $a)
        {
            $name   =   strtoupper($a->username);
            Mail::raw("Hello $name! This is automatically generated Hourly Update, Good Morning Everyone, Don't forget to check out our website today, for more deals. https://www.zuuroo.com/login", function($message) use ($a)
            {
                $message->from('ayotunde@zuuroo.com');
                $message->to($a->email)->subject('Hourly Update');
            });
        }
        $this->info('Hourly Update has been send successfully');
    }

    public function handle()
    {
        $currentDate    =   Carbon::now()->toDateString();
        $recurrUsers    =   RecurringCharge::join('loan_histories', 'loan_histories.user_id', 'recurring_charges.user_id')
                            ->where(function ($query) {
                                $query->where('loan_histories.payment_status', 'pending')
                                    ->orWhere('loan_histories.payment_status', 'partially');
                            })
                            ->whereDate('repayment', '<=', $currentDate)
                            ->select('loan_histories.user_id', 'loan_histories.loan_amount', 'recurring_charges.authorization_code', 'recurring_charges.user_email', 'loan_histories.repayment')
                            ->distinct()
                            ->get();
                                            
                                   
        if($recurrUsers != [] ){

            foreach ($recurrUsers as $rUser) {
            
                $details    =   [
                    "authorization_code"    => $rUser->authorization_code,
                    "email"                 => $rUser->user_email,
                    "amount"                => $rUser->loan_amount * 100,
                ];
                
                $allDetails = $details;
                
                // return $recurrUsers;
                $response   =   $this->PaystackRepository->charge_recurring($details);
                $data       =   json_decode( $response ); 
               
                $uid        =   $rUser->user_id;
                
                if( $data->status == true) {
                    
                    Payment::create([
                    'user_id'       =>  $uid,
                    'currency'      =>  $data->data->currency,
                    'reference'     =>  $data->data->reference,
                    'amount'        =>  $data->data->amount / 100,
                    'payment_id'    =>  $data->data->id,
                    'message'       =>  'Loan Repayment',
                    'payment_mode'  =>  'Paystack',
                    ]);

                    LoanHistory::where('user_id', $uid)->update([ 'payment_status' => 'paid', 'amount_paid' => $data->data->amount / 100, 'loan_amount' => 0  ]);
                    // Logger(['Reccuring Hour Charge' => $data]);
                    // Log::info('Recurring Hour Charged', ['data' => $data]);
                    // echo "Success";
                
                }
                
            }
            

        }
        $this->info('Hourly charge command executed successfully.');

        return Command::SUCCESS;
    }
}
