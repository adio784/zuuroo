<?php

namespace App\Interfaces;

Interface ProductCategoryRepositoryInterface
{
    public function getAllProductCategories();

    public function getAllProductsCatInfo();
    
    public function getAllProductCategoriesWithOperator();

    public function getProductCategoryById($ProductCategoryId);

    public function deleteProductCategory($ProductCategoryId);

    public function createProductCategory(array $ProductCategoryDetails);

    public function updateProductCategory($ProductCategoryId, array $newDetails);
    
    public function getProductCategoryByStatus($ProductCategoryId);

    public function getProductCategoryByOperator($OperatorId);
}