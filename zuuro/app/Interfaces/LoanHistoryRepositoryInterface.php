<?php

namespace App\Interfaces;

Interface LoanHistoryRepositoryInterface
{
    public function getAllLoanHistories();

    public function getDebtors();

    public function TotalLoan();

    public function DueLoan();
    
    public function TotalPaid();

    public function getLoanHistoryById($HistoryId);
    
    public function getUserLoan($UserId);

    public function deleteLoanHistory($HistoryId);

    public function createLoanHistory(array $HistoryDetails);

    public function updateLoanHistory($HistoryId, array $newDetails);

    public function LoanHistoryByStatus();
}

