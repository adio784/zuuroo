<?php

namespace App\Interfaces;

Interface HistoryRepositoryInterface
{
    public function getAllHistories();

    public function getAllDataHistories();

    public function getAllAirtimeHistories();

    public function getAllHistoryByUser($UserId);

    public function getPurchaseHistoryByUser($Purchase, $UserId);

    public function getHistoryById($HistoryId);

    public function deleteHistory($HistoryId);

    public function createHistory(array $HistoryDetails);

    public function updateHistory($HistoryId, array $newDetails);

    public function HistoryByStatus();
}

