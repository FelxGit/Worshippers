<?php
namespace App\Services;

use App\Helpers\Globals;
use App\Helpers\Websocket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Models\Post;
use App\Models\Notification as NotifModel;
use App\Interfaces\PostLikeRepositoryInterface;
use App\Interfaces\NotificationRepositoryInterface;

class PostLikeService
{
    public $repository;
    public $notiRepository;

    /**
     * PostLikeService constructor.
     *
     * @param PostLikeRepositoryInterface $service
     * @param NotificationRepositoryInterface $service
     *
     * @return void
     */
    public function __construct(
        PostLikeRepositoryInterface $repository,
        NotificationRepositoryInterface $notiRepository
    ) {
        $this->repository = $repository;
        $this->notiRepository = $notiRepository;
    }

    /**
     * This will like a user post.
     *
     * @return array $like
     */
    public function add()
    {
        $like = [];

        $data = [
          'user_id' => auth()->user()->id,
          'post_id' => request()->get('post_id'),
        ];

        $like = $this->repository->add($data);

        if (!empty($like)) {

            try {
                \DB::beginTransaction();

                $this->notiRepository->notifyPostUsers($like);

                \DB::commit();
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::error('Exception: ' . $e->getMessage());
            }

            \Cache::pull('posts');
        }

        return $like;
    }

    /**
     * This will toggle adjust the post like.
     *
     * @return array $like
     */
    public function adjust()
    {
        $like = [];
        $id = request()->get('id');
        $data = [
            'deleted_at' => null
        ];

        $like = $this->repository->adjust($id, $data);

        if (!empty($like)) {

            try {
                \DB::beginTransaction();

                $this->notiRepository->notifyPostUsers($like);

                \DB::commit();
                \Cache::pull('posts');
            } catch (\Exception $e) {
                \DB::rollback();
                \Log::error('Exception: ' . $e->getMessage());
            }
        }

        \Cache::pull('posts');

        return $like;
    }

    /**
     *
     * @return JSON $category
     */
    public function annul()
    {
        $id = request()->get('id');

        $like = $this->repository->annul($id);
        \Cache::pull('posts');
        return $like;
    }
}

