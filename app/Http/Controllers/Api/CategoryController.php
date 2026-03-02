<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @param CategoryService $service
     * @return void
     */
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Reqeust $request
     * @return JSON $rtn
     */
    public function index(Request $request)
    {
        $rtn = null;
        $rtn = $this->service->all();
        return $rtn;
    }
}
