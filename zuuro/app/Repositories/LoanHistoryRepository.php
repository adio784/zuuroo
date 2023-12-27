<?php

namespace App\Repositories;

use App\Interfaces\LoanHistoryRepositoryInterface;
use App\Models\LoanHistory;

class LoanHistoryRepository implements LoanHistoryRepositoryInterface
{
    public function getAllLoanHistories()
    {
        return LoanHistory::join('users', 'users.id', 'loan_histories.user_id')->join('operators', 'loan_histories.operator_code', '=', 'operators.operator_code')
                            ->join('countries', 'loan_histories.country_code', '=', 'countries.country_code')
                            ->select('users.name', 'loan_histories.selling_price', 'loan_histories.payment_status', 'loan_histories.plan', 'loan_histories.phone_number', 'loan_histories.selling_price', 'loan_histories.due_date', 'loan_histories.repayment', 'loan_histories.receive_currency', 'loan_histories.purchase', 'loan_histories.transfer_ref', 'loan_histories.selling_price', 'loan_histories.receive_value', 'loan_histories.commission_applied', 'loan_histories.processing_state', 'loan_histories.created_at', 'operators.operator_name', 'countries.country_name')
                            ->orderBy('loan_histories.id', 'DESC')
                            ->distinct()
                            ->get();
        // DB::table('users')->where('loan_record.repayment', '<=', $today)
        // ->join('loan_record', 'users.id', '=', 'loan_record.user_id')
        // ->join('transactions', 'loan_record.referrence_id', '=', 'transactions.TransferRef')
        // ->orderBy('transactions.id', 'DESC')
        // ->get(),
    }

    public function getDebtors()
    {
        return LoanHistory::join('users', 'loan_histories.user_id', '=', 'users.id')
                            ->where('payment_status', 'pending')
                            ->where('repayment', '<=', NOW())
                            ->select('loan_histories.plan', 'loan_histories.user_id', 'loan_histories.phone_number', 'loan_histories.selling_price', 'loan_histories.due_date', 'loan_histories.repayment', 'loan_histories.receive_currency', 'loan_histories.purchase', 'loan_histories.transfer_ref', 'loan_histories.selling_price', 'loan_histories.receive_value', 'loan_histories.commission_applied', 'loan_histories.processing_state', 'loan_histories.created_at', 'users.name', 'users.mobile', 'users.email')
                            ->groupBy('users.id')
                            ->orderBy('loan_histories.id', 'DESC')
                            ->distinct()
                            ->get();
    }

    public function getPaidLoan()
    {
        return LoanHistory::join('users', 'loan_histories.user_id', '=', 'users.id')
                            ->where('payment_status', 'paid')
                            ->where('repayment', '<=', NOW())
                            ->select('loan_histories.plan', 'loan_histories.phone_number', 'loan_histories.selling_price', 'loan_histories.due_date', 'loan_histories.repayment', 'loan_histories.receive_currency', 'loan_histories.purchase', 'loan_histories.transfer_ref', 'loan_histories.selling_price', 'loan_histories.receive_value', 'loan_histories.commission_applied', 'loan_histories.processing_state', 'loan_histories.created_at', 'users.name', 'users.mobile', 'users.email')
                            ->groupBy('users.id')
                            ->orderBy('loan_histories.id', 'DESC')
                            ->distinct()
                            ->get();

    }

    public function TotalLoan()
    {
        return LoanHistory::where('payment_status', 'pending')->sum('loan_amount');
    }

    public function DueLoan()
    {
        return LoanHistory::where('repayment', '<=', NOW())
                            ->where('payment_status', 'pending')
                            ->sum('loan_amount');
    }

    public function TotalPaid()
    {
        return LoanHistory::where('payment_status', 'paid')
                            ->sum('loan_amount');
    }

    public function getLoanHistoryById($HistoryId)
    {
        return LoanHistory::findOrFail($HistoryId);
    }

    public function getUserLoan($UserId)
    {
        return LoanHistory::where('user_id', $UserId)->where('payment_status', 'pending')->orWhere('payment_status', 'partially')->where('processing_state', 'successful')->first();
    }

    public function deleteLoanHistory($HistoryId)
    {
        LoanHistory::destroy($HistoryId);
    }

    public function createLoanHistory(array $HistoryDetails)
    {
        return LoanHistory::create($HistoryDetails);
    }

    public function updateLoanHistory($HistoryId, array $newDetails)
    {
        return LoanHistory::whereId($HistoryId)->update($newDetails);
    }

    public function LoanHistoryByStatus()
    {
        return LoanHistory::where('payment_status', true)->get();
    }

}
