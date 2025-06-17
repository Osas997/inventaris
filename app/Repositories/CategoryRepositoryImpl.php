<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryRepository;
use App\Models\Category;

class CategoryRepositoryImpl implements CategoryRepository
{
  public function getCategories()
  {
    return Category::latest()->get();
  }

  public function createCategory(array $data)
  {
    return Category::create($data);
  }
}
