<?php

namespace App\Interfaces;

Interface PaymentRepositoryInterface
{
    public function createPayment(array $PaymentDetails);

    public function getAllPayments();

    public function getTodayPayments();

    public function getMonthPayments();

    public function getPaystackPayments();

    public function getAllPPayments();
    public function getTodayPPayments();
    public function getMonthPPayments();

    public function getAllMPayments();
    public function getTodayMPayments();
    public function getMonthMPayments();

    public function getMonnifyPayments();

    public function getPaymentsById($UserId);

    public function getPaymentByStatus($status);

    public function getPaymentByRef($PaymentRef);

    public function deletePaymentRecord($PaymentRef);

    public function updatePayment($UserId, array $PaymentDetails);
}
