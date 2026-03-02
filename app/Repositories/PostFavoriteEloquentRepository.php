<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\PostFavoriteRepositoryInterface;
use App\Models\PostFavorite;

class PostFavoriteEloquentRepository extends MainEloquentRepository implements PostFavoriteRepositoryInterface
{
    /*======================================================================
     * PROPERTIES
     *======================================================================*/

    /**
     * @var Likes $Model
     */
    public $Model = PostFavorite::class;

    /*======================================================================
     * METHODS
     *======================================================================*/
    public function add(array $attributes)
    {
        return parent::add($attributes);
    }

    public function annul(int $id)
    {
        return parent::annul($id);
    }
}
