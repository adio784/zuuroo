<?php

namespace App\Interfaces;

Interface UserRepositoryInterface
{
    public function getAllUsers();
    
    public function getAllUsersWithWalletBal();

    public function getUserById($UsersId);

    public function deleteUser($UsersId);

    public function createUser(array $UsersDetails);

    public function updateUser($UsersId, array $newDetails);
    
    public function getActiveUser();

    public function createUserAccountDetails(array $bankDetails);

    public function getTermsCondition();

    public function getPricing($provider);
}