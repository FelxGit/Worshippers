<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AdminService
{
    public $userRepository;

    /**
     * @param UserRepositoryInterface $service
     * @return void
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Login the user
     *
     * @return boolean
     */
    public function login()
    {
        $credentials = [
            'email' => request()->get('email'),
            'password' => request()->get('password')
        ];

        if (\Auth::attempt($credentials)) {
            return true;
        }

        return false;
    }
}

