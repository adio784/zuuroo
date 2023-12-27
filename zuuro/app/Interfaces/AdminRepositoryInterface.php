<?php

namespace App\Interfaces;

Interface AdminRepositoryInterface
{
    public function getAllAdmins();

    public function getAdminById($AdminId);

    public function deleteAdmin($AdminId);

    public function createAdmin(array $AdminDetails);

    public function AuthAdmin(array $AdminDetails);

    public function updateAdmin($AdminId, array $newDetails);
    
    public function getActiveAdmins();

    public function getExistingAdmin($AdminEmail);

    public function getSuperAdmin($roleId);

    public function getDingConnectBal();
}

