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
    private CategoryRepository $categoryRepository
  ) {}

  public function getCategories()
  {
    return $this->categoryRepository->getCategories();
  }

  public function createCategory(array $categoryRequest)
  {
    return $this->categoryRepository->createCategory($categoryRequest);
  }
}
