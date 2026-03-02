<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Interfaces\CategoryRepositoryInterface;
use Exception;

class CategoryService
{
    /**
     * @param CategoryService $service
     * @return void
     */
    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @return JSON $category
     */
    public function all()
    {
        $category = $this->repository->acquireAll();
        return $category;
    }
}

