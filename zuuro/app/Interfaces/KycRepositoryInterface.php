<?php

namespace App\Interfaces;

Interface KycRepositoryInterface
{
    public static function getToken();
    
    public function getMonnifyToken();

    public function getAllKycs();

    public function getKycById($KycId);
    
    public function getKycByUserId($UserId);

    public function deleteKyc($KycId);

    public function createKyc(array $KycDetails);

    public function updateKyc($KycId, array $newDetails);
    
    public function getFulfilledKycs();

    public function verifyBvn(array $newDetails);
    
    public function verifyBvnMonnify(array $newDetails);

    public function getBvnDetailByUser($UserId, array $newDetails);

    public function getVerifiedUser();
}

