<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryEloquentRepository extends MainEloquentRepository implements CategoryRepositoryInterface
{
    /*======================================================================
     * PROPERTIES
     *======================================================================*/

    /**
     * @var Category $Model
     */
    public $Model = Category::class;

    /*======================================================================
     * METHODS
     *======================================================================*/

    public function acquireAll($paginationPerPage = 10)
    {
        return parent::acquireAll($paginationPerPage);
    }

    /**
     *
     * @return Integer $rtn
     */
    public function acquireCount()
    {
        $rtn = 0;
        $rtn = parent::acquireCount();
        return $rtn;
    }

    public function acquire($id)
    {
        return parent::acquire($id);
    }

    public function add(array $attributes)
    {
        return parent::add($attributes);
    }

    public function adjust(int $id, array $attributes)
    {
        return parent::adjust($id, $attributes);
    }

    public function annul(int $id)
    {
        return parent::annul($id);
    }
}
