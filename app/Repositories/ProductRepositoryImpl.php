<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductRepository;

class ProductRepositoryImpl implements ProductRepository
{
  public function getProducts()
  {
    // TODO: Implement getProducts() method.
  }

  public function getProduct(string $id)
  {
    // TODO: Implement getProduct() method.
  }

  public function createProduct(array $productRequest)
  {
    // TODO: Implement createProduct() method.
  }

  public function updateProduct(array $productRequest, string $id)
  {
    // TODO: Implement updateProduct() method.
  }

  public function deleteProduct(string $id)
  {
    // TODO: Implement deleteProduct() method.
  }

  public function updateStock(string $id, int $quantity)
  {
    // TODO: Implement updateStock() method.
  }
}
