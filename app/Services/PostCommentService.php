<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostComment;
use App\Interfaces\PostCommentRepositoryInterface;
use Exception;

class PostCommentService
{
    /**
     * @param CategoryService $service
     * @return void
     */
    public function __construct(PostCommentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     *
     * @return JSON $category
     */
    public function add()
    {
        $data = [
          'user_id' => auth()->user()->id,
          'post_id' => request()->get('post_id'),
          'description' => request()->get('description')
        ];

        $comment = $this->repository->add($data);
        \Cache::pull('posts');
        return $comment;
    }

    // /**
    //  *
    //  * @return JSON $category
    //  */
    // public function adjust()
    // {
    //     $id = request()->get('id');
    //     $data = [
    //         'deleted_at' => null
    //     ];

    //     $Comment = $this->repository->adjust($id, $data);
    //     return $Comment;
    // }

    // /**
    //  *
    //  * @return JSON $category
    //  */
    // public function annul()
    // {
    //     $id = request()->get('id');

    //     $Comment = $this->repository->annul($id);
    //     return $Comment;
    // }
}

