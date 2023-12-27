<?php

namespace App\Interfaces;

Interface SupportRepositoryInterface
{
    public function getAllSupports();

    public function createSupport(array $SupportDetails);

    public function updateSupport($SupportId, array $SupportDetails);
    
    public function deleteSupportRecord($SupportId);
}