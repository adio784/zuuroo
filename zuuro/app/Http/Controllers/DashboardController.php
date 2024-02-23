<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\LoanHistory;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{

    public function pre_report()
    {
        return view('app.admin.pre_report');
    }

    public function dailyMetrics(Request $request)
    {

        $request->validate([
            'from_date' => ['required', 'string', 'max:255'],
            'to_date'   => ['required', 'string', 'max:255'],
        ]);

        $fromDate       = $request->from_date;
        $toDate         = $request->to_date;

        // Simulated logic to get new customers for the day;
        $tnoCustomer    = User::get();
        $customers      = $tnoCustomer->count();

        // Carbon::now()
        $tdUser         = User::whereBetween('created_at', [$fromDate, $toDate])->get();
        $newCustomers   = $tdUser->count();

        // Simulated logic to calculate number of sales;
        $allSales       = History::whereBetween('created_at', [$fromDate, $toDate])
                            ->where(function ($query) {
                                $query->where('processing_state', 'successful')
                                    ->orWhere('processing_state', 'delivered')
                                    ->orWhere('processing_state', 'Complete');
                            })->get();
        $numberOfSales = $allSales->count('id');

        // Simulated logic to calculate revenue;
        $revenue        = $numberOfSales * 10; // Assuming $10 per sale;
        $productPrice   = $allSales->sum('selling_price');
        $totalCost      = $allSales->sum('cost_price');
        $totalSale      = $productPrice;

        // Simulated logic to calculate profit;
        $profit         = $productPrice - $totalCost;

        // Simulated logic to calculate cost;
        $cost           = $totalCost;

        // Simulated logic to calculate total loan taken for the day;
        $allLoan        = LoanHistory::whereBetween('created_at', [$fromDate, $toDate])
                                ->where(function ($query) {
                                        $query->where('processing_state', 'successful')
                                        ->orWhere('processing_state', 'delivered');
                                })
                                ->where(function ($query) {
                                         $query->where('payment_status', 'pending')
                                          ->orWhere('payment_status', 'partially');
                                })->get();

        $loan           = $allLoan->sum('loan_amount'); // Assuming loans are in multiples of $100;

        // Simulated logic to calculate total paid loan for the day;
        $ptdLoan        = LoanHistory::whereBetween('created_at', [$fromDate, $toDate])
                                ->where(function ($query) {
                                        $query->where('processing_state', 'successful')
                                        ->orWhere('processing_state', 'delivered');
                                })
                                ->where(function ($query) {
                                    $query->where('payment_status', 'paid')
                                     ->orWhere('payment_status', 'partially');
                                })->get();
        $paidLoan       = $ptdLoan->sum('amount_paid'); // Assuming payments in multiples of $100;

        // Simulated logic to calculate total unpaid loan for the day;

        $unpaidLoan     = $loan;

        // Total wallet fund
        $twallet        = Wallet::whereBetween('created_at', [$fromDate, $toDate])->get();
        $totalwallet    = $twallet->sum('balance');

        return view('app.admin.dashboard', compact(
            'customers',
            'newCustomers',
            'numberOfSales',
            'revenue',
            'profit',
            'cost',
            'loan',
            'paidLoan',
            'unpaidLoan',
            'totalwallet',
            'totalSale',
        ));
    }
}
