<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\WalletRepository;
use App\Repositories\HistoryRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\UserBankDetailsRepository;
use App\Models\RecurringCharge;
use App\Models\LoanHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $WalletRepository;
    private $HistoryRepository;
    private $PaymentRepository;
    private $UserBankDetailsRepository;

    public function __construct(WalletRepository $WalletRepository,
                                HistoryRepository $HistoryRepository,
                                PaymentRepository $PaymentRepository,
                                UserBankDetailsRepository $UserBankDetailsRepository)
    {
        $this->middleware(['auth', 'verified']);
        $this->HistoryRepository = $HistoryRepository;
        $this->WalletRepository = $WalletRepository;
        $this->PaymentRepository = $PaymentRepository;
        $this->UserBankDetailsRepository = $UserBankDetailsRepository;

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $uid = Auth::user()->id;
        $UserId = Auth::user()->email;
        $UserStatus = Auth::user()->status;
        $data = [
            'wallet' => $this->WalletRepository->getWalletBalance($uid),
            'TotalFund' => $this->PaymentRepository->getPaymentsById($uid),
            'Record' => $this->UserBankDetailsRepository->getDetailsById($UserId),
            'Recurring' => RecurringCharge::where('user_email', $UserId)->get(),
            'OutLoan' =>  LoanHistory::where(function($chek) {
                                            $chek->where('processing_state', 'successful')
                                                 ->orWhere('processing_state', 'delivered');
                                        })
                                       ->where(function ($query) {
                                            $query->where('payment_status', 'pending')
                                                ->orWhere('payment_status', 'partially');
                                        })
                                       ->where('user_id', $uid)
                                       ->get(),
            'TotalSpend' => DB::table('histories')
                            ->where('user_id', Auth::user()->id)
                            ->where('processing_state', '!=', 'failed')
                            ->orderBy('id', 'DESC')->get(),
        ];
        if( $UserStatus == 1 )
        {
            Alert::success('Congrats', 'You\'ve Successfully Registered');
            return view('home', $data);
        }
        else
        {
            return redirect('login')->with('fail', 'Account Suspended, Contact Administrator');
        }
    }
}
