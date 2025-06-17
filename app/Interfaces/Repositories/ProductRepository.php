<?php

namespace App\Interfaces\Repositories;

interface ProductRepository
{
  public function getProducts();
  public function getProduct(string $id);
  public function createProduct(array $productRequest);
  public function updateProduct(array $productRequest, string $id);
  public function deleteProduct(string $id);
  public function updateStock(string $id, int $quantity);
}
