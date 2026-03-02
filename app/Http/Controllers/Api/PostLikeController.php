<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PostLikeService;

class PostLikeController extends Controller
{
    /**
     * PostLikeController constructor.
     *
     * @param PostLikeService $service
     *
     * @return void
     */
    public function __construct(PostLikeService $service)
    {
        $this->service = $service;
    }

    /**
     * This will add like to the user post.
     *
     * @param Request $request
     *
     * @return JSON $rtn
     */
    public function store()
    {
        $rtn = $this->service->add();
        return response()->json($rtn);
    }

    /**
     * This will toggle adjust the user like.
     *
     * @param Request $request
     *
     * @return JSON $rtn
     */
    public function update()
    {
        $rtn = $this->service->adjust();
        return response()->json($rtn);
    }

    /**
     * This will annul user.
     *
     * @param Reqeust $request
     *
     * @return JSON $rtn
     */
    public function destroy()
    {
        $rtn = $this->service->annul();
        return response()->json($rtn);
    }
}
