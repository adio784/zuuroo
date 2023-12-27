<?php

namespace App\Interfaces;

Interface FaqRepositoryInterface
{
    public function getAllFaqs();

    public function createFaq(array $FaqDetails);

    public function updateFaq($FaqId, array $FaqDetails);

    public function deleteFaq($FaqId);
}