<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Globals;
use App\Models\Category;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\PostRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\User;
use App\Post;
use Exception;
use DateTime;

class DashboardService
{
    public $userRepository;
    public $postRepository;
    public $categoryRepository;

    /**
     * @param UserService $service
     * @return void
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        PostRepositoryInterface $postRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     *
     * @return JSON $rtn
     */
    public function getDashboard()
    {
        $rtn = [];

        $attributes = [
            'graph_date' => request()->get('graph_date') ?? Globals::GRAPH_YEAR
        ];

        $userCount = $this->userRepository->acquireCountByFilter($attributes);
        $postCount = $this->postRepository->acquireCountByFilter($attributes);
        $totalCategory = $this->categoryRepository->acquireCount();

        $rtn = [
            'user' => $userCount,
            'post' => $postCount,
            'totalUser' => array_sum($userCount),
            'totalPost' => array_sum($postCount),
            'totalCategory' => $totalCategory
        ];

        return $rtn;
    }
}

