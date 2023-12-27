<?php

namespace App\Interfaces;

Interface ProductRepositoryInterface
{
    public function getAllProducts();

    public function getAllProductsInfo();

    public function getProductById($ProductId);

    public function deleteProduct($ProductId);

    public function createProduct(array $ProductDetails);

    public function updateProduct($ProductId, array $newDetails);

    public function getProductByStatus($ProductId);

    public function getProductByOperator($OperatorId);

    public function getProductByCategory($CategoryId);

    public function ProductByOperator($OperatorId);
}
