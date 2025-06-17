<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductRepository;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepositoryImpl implements ProductRepository
{
  public function getProducts($search = null)
  {
    $products = Product::with('category')->latest();

    if ($search) {
      if (!empty($search['name'])) {
        $products->where('name', 'like', '%' . $search['name'] . '%');
      }

      if (!empty($search['category_id'])) {
        $products->where('category_id', $search['category_id']);
      }
    }

    return $products->get();
  }

  public function getProduct(string $id)
  {
    return Product::with('category')->find($id);
  }

  public function createProduct(array $productRequest)
  {
    return Product::create($productRequest);
  }

  public function updateProduct(array $productRequest, Product $product)
  {
    $product->update($productRequest);
    return $product;
  }

  public function deleteProduct(Product $product)
  {
    return $product->delete();
  }

  public function updateStock(Product $product, int $quantity)
  {
    $product->update(['stock_quantity' => $quantity]);
    return $product;
  }

  public function calculateInventoryValue()
  {
    return Product::sum(DB::raw('price * stock_quantity'));
  }
}
