<?php

namespace App\Interfaces;

Interface PaymentGatewayRepositoryInterface
{
    public function getAllPaymentGateways();

    public function getPaymentGatewayById($PaymentGatewayId);

    public function deletePaymentGateway($PaymentGatewayId);

    public function createPaymentGateway(array $PaymentGatewayDetails);

    public function updatePaymentGateway($PaymentGatewayId, array $newDetails);
    
    public function getFulfilledPaymentGateways();
}

