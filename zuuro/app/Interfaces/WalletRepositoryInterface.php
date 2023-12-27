<?php

namespace App\Interfaces;

Interface WalletRepositoryInterface
{
    public function getWalletBalance($UserId);

    public function createWallet(array $WalletDetails);

    public function updateWallet($UserId, array $WalletDetails);

    public function deleteWalletRecord($WalletRef);
}