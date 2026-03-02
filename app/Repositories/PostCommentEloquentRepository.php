<?php

namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Interfaces\PostCommentRepositoryInterface;
use App\Models\PostComment;

class PostCommentEloquentRepository extends MainEloquentRepository implements PostCommentRepositoryInterface
{
    /*======================================================================
     * PROPERTIES
     *======================================================================*/

    /**
     * @var Likes $Model
     */
    public $Model = PostComment::class;

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
