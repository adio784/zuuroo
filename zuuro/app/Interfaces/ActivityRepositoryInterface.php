<?php

namespace App\Interfaces;

Interface ActivityRepositoryInterface
{
    
    public function getallActivities();

    public function getActivityByStatus($status);

    public function createActivity(array $ActivityDetails);

    public function updateActivity($AccId, array $ActivityDetails);

    public function deleteActivityRecord($AccId);

}