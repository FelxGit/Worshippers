<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $service;

    /**
     * @param DashboardService $service
     * @return void
     */
    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }

    /**
     * Acquire data by filter
     *
     * @return json $rtn
     */
    public function index()
    {
        $rtn = '';
        $rtn = $this->service->all();
        return $rtn;
    }
}
