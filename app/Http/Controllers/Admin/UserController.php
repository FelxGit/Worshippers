<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\FileRequest;
use App\Http\Requests\PutUserRequest;
use App\Services\UserService;
use App\Models\User;

class UserController extends Controller
{
    public $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $service
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * User dashboard.
     *
     * @return view
     */
    public function index()
    {
        $users = $this->userService->all();
        return view('admin.user', compact('users'));
    }

    /**
     * User create form.
     *
     * @return view
     */
    public function create()
    {
        $data = [
            'routeURL' => route('admin.user.store'),
            'formType' => __('messages.Create'),
            'title' => __('messages.AddUser')
        ];
        return view('admin.user.form', $data);
    }

    /**
     * User edit form.
     *
     * @param Model $user

     * @return view
     */
    public function edit(User $user)
    {
        $data = [
            'routeURL' => route('admin.user.update', [ 'id' => $user->id ]),
            'formType' => __('messages.Edit'),
            'title' => __('messages.EditUser'),
            'user' => $user,
        ];

        return view('admin.user.form', $data);
    }

    /**
     * Update a user record.
     *
     * @param PutUserRequest $request
     * @param $id
     *
     * @return view
     */
    public function update(PutUserRequest $request, $id)
    {
        $rtn = $this->userService->adjust($request, $id);

        if (!empty($rtn)) {
            return redirect()->route('admin.user')->with('messaage', 'Failed to update.');
        }

        return redirect()->route('admin.user');
    }

    /**
     * Annul a user record.
     *
     * @return view
     */
    public function remove()
    {
        $this->userService->annul();
        return back();
    }

    /**
     * Annul many user records.
     *
     * @return view
     */
    public function bulkRemove()
    {
        $this->userService->annulMany();
        return back();
    }

    /**
     * Save file to tmp.
     *
     * @param FileRequest $request
     *
     * @return boolean|JSON $rtn
     */
    public function upload(FileRequest $request)
    {
        $rtn = false;
        $rtn = $this->userService->upload();
        return response()->json($rtn);
    }
}