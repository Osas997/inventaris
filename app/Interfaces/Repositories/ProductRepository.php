<?php

namespace App\Interfaces\Repositories;

use App\Models\Product;

interface ProductRepository
{
  public function getProducts();
  public function getProduct(string $id);
  public function createProduct(array $productRequest);
  public function updateProduct(array $productRequest, Product $product);
  public function deleteProduct(Product $product);
  public function updateStock(Product $product, int $quantity);
  public function calculateInventoryValue();
}
