<?php

namespace App\Interfaces;

Interface SmsDebtorRepositoryInterface
{
    
    public function getAllSmsDebtors();

    public function getSmsDebtorById($SmsDebtorId);

    public function deleteSmsDebtor($SmsDebtorId);

    public function createSmsDebtor(array $SmsDebtorDetails);

    public function updateSmsDebtor($SmsDebtorId, array $newDetails);
    
    public function getFulfilledSmsDebtors();
}

