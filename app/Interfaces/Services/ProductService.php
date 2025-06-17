<?php

namespace App\Interfaces\Services;

interface ProductService
{
  public function getProducts();
  public function getProduct(string $id);
  public function createProduct(array $productRequest);
  public function updateProduct(array $productRequest, string $id);
  public function deleteProduct(string $id);
  public function searchProduct(array $search);
  public function updateStock(array $updateStockRequest);
  public function inventoryValue();
}
