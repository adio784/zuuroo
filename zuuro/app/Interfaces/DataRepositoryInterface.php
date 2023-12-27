<?php

namespace App\Interfaces;

Interface DataRepositoryInterface
{
    public static function getToken();

    public function createNgData(array $DataDetails);

    public function createIntData(array $DataDetails);

    public function findUser();

}