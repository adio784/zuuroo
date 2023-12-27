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

class HourlyBackup extends Command
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

    public function handle1()
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
                                            ->where('loan_histories.payment_status', 'pending')
                                            ->orWhere('loan_histories.payment_status', 'partially')
                                            ->whereDate('repayment', '>=', $currentDate )
                                            ->select('loan_histories.user_id', 'loan_histories.loan_amount', 'recurring_charges.authorization_code', 'recurring_charges.user_email')
                                            ->distinct()
                                            ->get();
                                            // return Log::info($recurrUsers);
                                            
                                            
        if($recurrUsers != [] ){

            foreach( $recurrUsers  as $user)
            {
                
                $details    =   [
                    "authorization_code"    => $user->authorization_code,
                    "email"                 => $user->user_email,
                    "amount"                => $user->loan_amount,
                ];
                
                $response   =   $this->PaystackRepository->charge_recurring($details);
                $data       =   json_decode( $response ); return Log::info([$data]);
                $uemail     =   $data->data->customer->email;
                // $user       =   User::where('email', $uemail)->first();
 
                $uid    =   $user->user_id; //$user->id;
                Payment::create([
                    'user_id'       =>  $uid,
                    'currency'      =>  $data->data->currency,
                    'reference'     =>  $data->data->reference,
                    'amount'        =>  $data->data->amount,
                    'payment_id'    =>  $data->data->id,
                    'message'       =>  'Loan Repayment',
                    'payment_mode'  =>  'Paystack',
                ]);
                return Log::info($user->user_email);

                LoanHistory::where('user_id', $uid)->update([ 'payment_status' => 'paid', ]);
                // Logger(['Reccuring Hour Charge' => $data]);
                // Log::info('Recurring Hour Charge', ['data' => $data]);
                
    
            }
        }
            $this->info('Hourly charge command executed successfully.');

        return Command::SUCCESS;
    }
}
