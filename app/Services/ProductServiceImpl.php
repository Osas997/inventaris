<?php

namespace App\Services;

use App\Interfaces\Repositories\ProductRepository;
use App\Interfaces\Services\ProductService;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductServiceImpl implements ProductService
{
  public function __construct(
    private ProductRepository $productRepository
  ) {}

  public function getProducts()
  {
    return $this->productRepository->getProducts();
  }

  public function getProduct(string $id)
  {
    $product = $this->productRepository->getProduct($id);

    if (!$product) {
      throw new NotFoundHttpException('Product not found');
    }

    return $product;
  }

  public function createProduct(array $productRequest)
  {
    return $this->productRepository->createProduct($productRequest);
  }

  public function updateProduct(array $productRequest, string $id)
  {
    $product = $this->getProduct($id);
    return $this->productRepository->updateProduct($productRequest, $product);
  }

  public function deleteProduct(string $id)
  {
    $product = $this->getProduct($id);
    return $this->productRepository->deleteProduct($product);
  }

  public function searchProduct(array $search)
  {
    $products = $this->productRepository->getProducts($search);
    return $products;
  }

  public function updateStock(array $updateStockRequest)
  {
    $product = $this->getProduct($updateStockRequest['product_id']);

    if ($product->stock_quantity < $updateStockRequest['quantity_sold']) {
      throw new BadRequestHttpException('Stock Tidak Mencukupi');
    }

    $stock = $product->stock_quantity - $updateStockRequest['quantity_sold'];
    return $this->productRepository->updateStock($product, $stock);
  }

  public function inventoryValue()
  {
    return $this->productRepository->calculateInventoryValue();
  }
}
