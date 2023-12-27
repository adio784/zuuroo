<?php

namespace App\Interfaces;

Interface OperatorRepositoryInterface
{
    public function getAllOperators();

    public function getAllOperatorsInfo();

    public function getOperatorById($OperatorId);

    public function deleteOperator($OperatorId);

    public function createOperator(array $OperatorDetails);

    public function updateOperator($OperatorId, array $newDetails);
    
    public function getOperatorByStatus($OperatorId);

    public function getOperatorByCountry($CountryIso);
}

