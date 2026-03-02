<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\PostLikeRepositoryInterface;
use App\Models\PostLike;

class PostLikeEloquentRepository extends MainEloquentRepository implements PostLikeRepositoryInterface
{
    /*======================================================================
     * PROPERTIES
     *======================================================================*/

    /**
     * @var Likes $Model
     */
    public $Model = PostLike::class;

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
