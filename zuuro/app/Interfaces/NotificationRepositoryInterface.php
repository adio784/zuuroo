<?php

namespace App\Interfaces;

Interface NotificationRepositoryInterface
{
    public function getNotificationByUser($UserId);

    public function createNotification(array $NotificationDetails);

    public function updateNotification($UserId, array $NotificationDetails);

    public function toggleNotification($UserId, $toggleId);

    public function deleteNotificationRecord($Nid);
}