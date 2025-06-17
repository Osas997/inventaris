<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\UpdateStockRequest;
use App\Http\Resources\ProductResource;
use App\Interfaces\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/products",
     *     tags={"products"},
     *     summary="Get all products",
     *     description="Get all products",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *         )
     *     ),
     * )
     */
    public function index()
    {
        $products = $this->productService->getProducts();

        return ApiResponse::responseWithData(ProductResource::collection($products), 'Success get products');
    }

    /**
     * @OA\Post(
     *     path="/api/products",
     *     tags={"products"},
     *     summary="Create a new product",
     *     description="Create a new product",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name", "description", "price", "category_id"},
     *             @OA\Property(property="name",example="product", type="string"),
     *             @OA\Property(property="price",example=100000, type="integer"),
     *             @OA\Property(property="stock_quantity",example=10, type="integer"),
     *             @OA\Property(property="category_id",example=1, type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *         )
     *     ),
     * )
     */
    public function store(CreateProductRequest $request)
    {
        $productRequest = $request->validated();

        $product = $this->productService->createProduct($productRequest);

        return ApiResponse::responseWithData(new ProductResource($product), 'Success create product', 201);
    }

    /**
     * @OA\Get(
     *     path="/api/products/{id}",
     *     tags={"products"},
     *     summary="Get product by id",
     *     description="Get product by id",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         description="product id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example=1,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *         )
     *     ),
     * )
     */
    public function show(string $id)
    {
        $product = $this->productService->getProduct($id);

        return ApiResponse::responseWithData(new ProductResource($product), 'Success get product');
    }

    /**
     * @OA\Put(
     *     path="/api/products/{id}",
     *     tags={"products"},
     *     summary="Update product by id",
     *     description="Update product by id",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         description="product id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example=1,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name",example="product", type="string"),
     *             @OA\Property(property="price",example=100000, type="integer"),
     *             @OA\Property(property="stock_quantity",example=10, type="integer"),
     *             @OA\Property(property="category_id",example=1, type="integer"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *         )
     *     ),
     * )
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        $productRequest = $request->validated();

        $product = $this->productService->updateProduct($productRequest, $id);

        Log::info($productRequest);

        return ApiResponse::responseWithData(new ProductResource($product), 'Success update product');
    }

    /**
     * @OA\Delete(
     *     path="/api/products/{id}",
     *     tags={"products"},
     *     summary="Delete product by id",
     *     description="Delete product by id",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         description="product id",
     *         in="path",
     *         name="id",
     *         required=true,
     *         example=1,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *         )
     *     ),
     * )
     */
    public function destroy(string $id)
    {
        $this->productService->deleteProduct($id);

        return ApiResponse::response('Success delete product');
    }

    /**
     * @OA\Get(
     *     path="/api/products/search",
     *     tags={"products"},
     *     summary="Search products",
     *     description="Search products by name or category",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search by name",
     *         required=false,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         description="Category id",
     *         required=false,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object"
     *         )
     *     ),
     * )
     */
    public function search(Request $request)
    {
        $name = $request->input('search');
        $category = $request->input('category_id');

        $search = ['name' => $name, 'category_id' => $category];

        $products = $this->productService->searchProduct($search);

        return ApiResponse::responseWithData(ProductResource::collection($products), 'Success search product');
    }

    /**
     * @OA\Post(
     *     path="/api/products/update-stock",
     *     tags={"products"},
     *     summary="Update stock product by id",
     *     description="Update stock product by id",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="product_id", type="integer", example=1),
     *             @OA\Property(property="quantity_sold", type="integer", example=10),
     *             required={"product_id", "quantity_sold"}
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="stock_quantity", type="integer", example=10),
     *         )
     *     ),
     * )
     */
    public function updateStock(UpdateStockRequest $request)
    {
        $updateStockRequest = $request->validated();

        $product = $this->productService->updateStock($updateStockRequest);

        return ApiResponse::responseWithData(["stock_quantity" => $product->stock_quantity], 'Success update stock product');
    }

    /**
     * @OA\Get(
     *     path="/api/inventory/value",
     *     tags={"products"},
     *     summary="Get total inventory value",
     *     description="Retrieve the total value of all products in stock",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful response",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="total_value", type="number", format="float", example=1000000),
     *         )
     *     ),
     * )
     */
    public function inventoryValue()
    {
        $value = $this->productService->inventoryValue();

        return ApiResponse::responseWithData(['total_value' => $value], 'Success get inventory value');
    }
}
