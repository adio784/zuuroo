<?php

namespace App\Interfaces;

Interface UserBankDetailsRepositoryInterface
{
    public function getAllUserBankDetails();

    public function getDetailsById($UsersId);

    public function deleteUserDetails($UsersId);

    public function createUserAccountDetails(array $UserDetails);

    public function updateUserDetails($UsersId, array $newDetails);
    
    public function getActiveUserBank();
}

