<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Interfaces\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/categories",
     *     tags={"categories"},
     *     summary="Get all categories",
     *     description="Get all categories",
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
        $categories = $this->categoryService->getCategories();

        return ApiResponse::responseWithData(CategoryResource::collection($categories), 'Success get categories');
    }

    /**
     * @OA\Post(
     *     path="/api/categories",
     *     tags={"categories"},
     *     summary="Create a new category",
     *     description="Create a new category",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             required={"name"},
     *             @OA\Property(property="name",example="category", type="string")
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
    public function store(CreateCategoryRequest $request)
    {
        $categoryRequest = $request->validated();

        $category = $this->categoryService->createCategory($categoryRequest);

        return ApiResponse::responseWithData(CategoryResource::make($category), 'Success create category');
    }
}
