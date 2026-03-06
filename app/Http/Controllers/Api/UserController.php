<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * @param UserService $service
     * @return void
     */
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @param User $user
     * @return JSON $user
     */
    public function index()
    {
        $users = $this->service->all();
        return response()->json($users);
    }

    /**
     * @param User $user
     * @return JSON $user
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * This login the user.
     *
     * @param Request $request
     *
     * @return JSON $data
     */
    public function login()
    {
        $data = $this->service->login();
        return response()->json($data);
    }

    /**
     * This will register the user.
     *
     * @param UserRequest $request
     *
     * @return JSON $rtn
     */
    public function register(UserRequest $request)
    {
        $user = $this->service->registerUser();
        return response()->json($user);
    }

    /**
     * This will sent reset link to user's email.
     *
     * @param Request $request
     *
     * @return array $rtn
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users'
        ]);

        $rtn = $this->service->sendResetLinkEmail();
        return response()->json($rtn);
    }

    /**
     * Reset the user password.
     *
     * @param Request $request
     *
     * @return JSON $rtn
     */
    public function reset(Request $request)
    {
        $validated = $request->validate([
            'new_password' => 'required',
            'password_confirmation' => 'required|same:new_password'
        ]);

        $rtn = $this->service->reset();
        return response()->json($rtn, 200);
    }

    /**
     * Reset the user password.
     *
     * @param $id
     *
     * @return JSON $rtn
     */
    public function delete($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->forceDelete();
        }

        return response()->json(['success' => true]);
    }
}
