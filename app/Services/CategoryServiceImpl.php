<?php

namespace App\Services;

use App\Helper\ApiResponse;
use App\Interfaces\Repositories\CategoryRepository;
use App\Interfaces\Services\CategoryService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CategoryServiceImpl implements CategoryService
{
  public function __construct(
    protected CategoryRepository $categoryRepository
  ) {}

  public function getCategories()
  {
    try {
      return $this->categoryRepository->getCategories();
    } catch (HttpException $th) {
      throw new HttpResponseException(
        ApiResponse::response($th->getMessage(), $th->getStatusCode() ?? 500)
      );
    }
  }

  public function createCategory(array $categoryRequest)
  {
    try {
      return $this->categoryRepository->createCategory($categoryRequest);
    } catch (HttpException $th) {
      throw new HttpResponseException(
        ApiResponse::response($th->getMessage(), $th->getStatusCode() ?? 500)
      );
    }
  }
}
