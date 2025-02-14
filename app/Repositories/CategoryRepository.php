<?php

namespace App\Repositories;

use App\Models\Category;
use App\repositories\Contracts\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function getAllCategories()
    {
        return Category::latest()->get();
    }
}