<?php

namespace App\Http\Controllers;

use App\Models\History;
use App\Models\LoanHistory;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function dailyMetrics()
    {
        // Simulated logic to get new customers for the day;
        $tnoCustomer = User::get();
        $customers = $tnoCustomer->count();

        $tdUser = User::whereDate('created_at', Carbon::now())->get();
        $newCustomers = $tdUser->count();

        // Simulated logic to calculate number of sales;
        $allSales = History::whereDate('created_at', Carbon::now())
                       ->where(function ($query) {
                              $query->where('processing_state', 'successful')
                                  ->orWhere('processing_state', 'delivered');
                        })->get();
        $numberOfSales = $allSales->count('id');

        // Simulated logic to calculate revenue;
        $revenue = $numberOfSales * 10; // Assuming $10 per sale;
        $sellingPrice = $allSales->sum('selling_price');
        $totalCost = $allSales->sum('cost_price');

        // Simulated logic to calculate profit;
        $profit = $sellingPrice - $totalCost;

        // Simulated logic to calculate cost;
        $cost = $totalCost;

        // Simulated logic to calculate total loan taken for the day;
        $allLoan = LoanHistory::whereDate('created_at', Carbon::now())
                                ->where(function ($query) {
                                        $query->where('processing_state', 'successful')
                                        ->orWhere('processing_state', 'delivered');
                                })
                                ->where(function ($query) {
                                         $query->where('payment_status', 'pending')
                                          ->orWhere('payment_status', 'partially');
                                })->get();

        $loan = $allLoan->sum('loan_amount'); // Assuming loans are in multiples of $100;

        // Simulated logic to calculate total paid loan for the day;
        $ptdLoan = LoanHistory::whereDate('created_at', Carbon::now())
                                ->where(function ($query) {
                                        $query->where('processing_state', 'successful')
                                        ->orWhere('processing_state', 'delivered');
                                })
                                ->where(function ($query) {
                                    $query->where('payment_status', 'paid')
                                     ->orWhere('payment_status', 'partially');
                                })->get();
        $paidLoan = $ptdLoan->sum('amount_paid'); // Assuming payments in multiples of $100;

        // Simulated logic to calculate total unpaid loan for the day;

        $unpaidLoan = $loan - $paidLoan;

        return view('app.admin.dashboard', compact(
            'customers',
            'newCustomers',
            'numberOfSales',
            'revenue',
            'profit',
            'cost',
            'loan',
            'paidLoan',
            'unpaidLoan'
        ));
    }
}
