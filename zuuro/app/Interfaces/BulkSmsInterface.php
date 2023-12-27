<?php

namespace App\Interfaces;

Interface BulkSmsInterface
{
    public function getToken();

    public function processMobileVer(array $smsDetails);

    public function verifyMobile($MobileRef);
}
