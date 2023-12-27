<?php

namespace App\Interfaces;

Interface TermConditionRepositoryInterface
{    
    public function getAllTermConditions();

    public function getTermConditionById($TermConditionId);

    public function deleteTermCondition($TermConditionId);

    public function createTermCondition(array $TermConditionDetails);

    public function updateTermCondition($TermConditionId, array $newDetails);
    
    public function getFulfilledTermConditions();
}

