<?php

namespace App\Interfaces;

Interface PaystackRepositoryInterface
{
    public function getToken();

    public function processPayment(array $PaymentDetails);

    public function verifyPayment($PaymentRef);

    public function verifyWebhookPaystack(array $PaymentDetails);
    
    public function initialize_recurring(array $Details);

    public function charge_recurring(array $Details);
}