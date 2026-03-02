<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Globals;
use App\Models\Tag;
use App\Interfaces\TagRepositoryInterface;
use App\Interfaces\PostTagRepositoryInterface;
use Exception;

class TagService
{
    /**
     * @param TagService $service
     * @return void
     */
    public function __construct(
        TagRepositoryInterface $repository,
        PostTagRepositoryInterface $postTagRepository
    )
    {
        $this->repository = $repository;
        $this->postTagRepository = $postTagRepository;
    }

    /**
     *
     * @return JSON $rtn
     */
    public function all()
    {
        $rtn = [];

        $expiry = 604800; // 1 week

        if (!empty(request()->get('acquireByPopularity'))) {
            $rtn = \Cache::remember('tagsByPopularity', $expiry, function () {
                $count = Globals::mTag()::POPULARITY_MAX_COUNT;

                $postTags = $this->postTagRepository->acquireByPopularity($count)->toArray();
                $tags = $this->repository->acquireAllWithSort($postTags);
                return $tags;
            });
        } else {
            $rtn = \Cache::remember('tags', $expiry, function () {
                $tags = $this->repository->acquireAll();
                return $tags;
            });
        }

        return $rtn;
    }

    /**
     *
     * @return JSON $tag
     */
    public function store()
    {
        $tag = $this->repository->add();
        \Cache::pull('tags');
        return $tag;
    }
}

