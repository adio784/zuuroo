<?php

namespace App\Interfaces;

Interface FundRepositoryInterface
{
    public function getAllFunds();

    public function getFundById($FundId);

    public function deleteFund($FundId);

    public function createFund(array $FundDetails);

    public function updateFund($FundId, array $newDetails);
    
    public function getFulfilledFunds();
}

