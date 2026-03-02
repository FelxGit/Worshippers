<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PostCommentService;

class PostCommentController extends Controller
{
    /**
     * @param PostCommentService $service
     * @return void
     */
    public function __construct(PostCommentService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Reqeust $request
     * @return JSON $rtn
     */
    public function store()
{
        $rtn = null;
        $rtn = $this->service->add();
        return $rtn;
    }

    // /**
    //  * @param Reqeust $request
    //  * @return JSON $rtn
    //  */
    // public function update()
    // {
    //     $rtn = null;
    //     $rtn = $this->service->adjust();
    //     return $rtn;
    // }

    // /**
    //  * @param Reqeust $request
    //  * @return JSON $rtn
    //  */
    // public function destroy()
    // {
    //     $rtn = null;
    //     $rtn = $this->service->annul();
    //     return $rtn;
    // }
}
