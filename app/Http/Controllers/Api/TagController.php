<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TagService;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * 
     * @param PostService $service
     * @return void
     */
    public function __construct(TagService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Reqeust $request
     * @return JSON $rtn
     */
    public function index()
    {
        $rtn = null;
        $rtn = $this->service->all();
        return $rtn;
    }
}
