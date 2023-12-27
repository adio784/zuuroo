<?php

namespace App\Interfaces;

Interface AirtimeProductRepositoryInterface
{
    public function getAllAirtimeProducts();

    public function getAirtimeProductById($ProductId);

    public function deleteAirtimeProduct($ProductId);

    public function createAirtimeProduct(array $ProductDetails);

    public function updateAirtimeProduct($ProductId, array $newDetails);
    
    public function getAirtimeProductByStatus($ProductId);

    public function getAirtimeProductByOperator($OperatorId);

    public function getAirtimeProductByCategory($CategoryId);
}