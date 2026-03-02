<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Models\User;

class DashboardController extends Controller
{
    public $dashboardService;

    /**
     * @param DashboardService $service
     * @return void
     */
    public function __construct(DashboardService $dashboardService)
    {
        // $this->middleware('auth');
        $this->dashboardService = $dashboardService;
    }

    /**
     * @return view\json
     */
    public function dashboard()
    {
        $data = $this->dashboardService->getDashboard();
        $user = auth()->user();

        if (request()->get('graph_date')) {
            return response()->json($data);
        }

        return view('admin.dashboard', [ 'user' => $user, 'data' => $data ]);
    }
}