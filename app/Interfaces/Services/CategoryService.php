<?php

namespace App\Interfaces\Services;

interface CategoryService
{
  public function getCategories();
  public function createCategory(array $categoryRequest);
}
