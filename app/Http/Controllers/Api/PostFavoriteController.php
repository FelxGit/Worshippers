<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PostFavoriteService;

class PostFavoriteController extends Controller
{
    /**
     * PostFavoriteController constructor
     *
     * @param PostFavoriteService $service
     *
     * @return void
     */
    public function __construct(PostFavoriteService $service)
    {
        $this->service = $service;
    }

    /**
     * This will set post as favorite.
     *
     * @return JSON $rtn
     */
    public function store()
    {
        $rtn = $this->service->add();
        return response()->json($rtn);
    }

    /**
     * This will adjust toggle post favorite.
     *
     * @return JSON $rtn
     */
    public function update()
    {
        $rtn = $this->service->adjust();
        return $rtn;
    }

    /**
     * This will annul the post favorite.
     *
     * @return JSON $rtn
     */
    public function destroy()
    {
        $rtn = $this->service->annul();
        return response()->json($rtn);
    }
}
