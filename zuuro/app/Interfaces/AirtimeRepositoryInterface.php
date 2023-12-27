<?php

namespace App\Interfaces;

Interface AirtimeRepositoryInterface
{
    public static function getToken();

    public function createNgAirtime(array $AirtimeDetails);

    public function createIntAirtime(array $AirtimeDetails);

    public function createVTPassAirtime(array $AirtimeDetails);

    public function findUser();

}
