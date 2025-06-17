<?php

namespace App\Interfaces\Repositories;

interface CategoryRepository
{
  public function getCategories();
  public function createCategory(array $data);
}
