<?php
namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Upload;
use App\Helpers\Websocket;
use App\Http\Requests\PutUserRequest;
use App\Models\User;
use App\Notifications\ResetPasswordLink;
use App\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Exception;
use Socialite;

class UserService
{
    public $repository;

    /**
     * @param UserService $service
     * @return void
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return array $rtn
     */
    public function all()
    {
        $rtn = [];
        $rtn = $this->repository->acquireAll();
        return $rtn;
    }
    /**
     * This will login the user.
     *
     * @return array $rtn
     */
    public function login()
    {
        $rtn = [];

        $data = request()->only('email', 'password');
        // $user = $this->service->acquireByAttributes($data);

        if (\Auth::attempt($data)) {
            $user = \Auth::user();

            $rtn = [
                'token' => $user->createToken('chronoknowledge')->accessToken,
                'user' => $user
            ];
        } else {
            throw new \Exception("The given data was invalid.");
        }

        return $rtn;
    }

    /**
     * Login google user
     *
     * @return Array $data
     */
    public function loginGoogle()
    {
        $data = [];

        try {
            \DB::beginTransaction();

            $user = null;
            $g_user = Socialite::driver('google')->stateless()->user();
            $user = User::where('email', $g_user->email)->first();
            $existEmailButNotLinked = $user && empty($user->google_id);

            if ($existEmailButNotLinked) {
                $adjustAttributes = [ 'google_id' => $g_user->id ];
                $user = $this->repository->adjust($user->id, $adjustAttributes);
            } else if (empty($user)) {
                // create the user
                $attributes = [
                    'google_id' => $g_user->id,
                    'role_id' => User::NORMAL_USER,
                    'email' => $g_user->email,
                    'username' => $g_user->name,
                    'firstname' => $g_user->user['given_name'],
                    'lastname' => $g_user->user['family_name'],
                    'name' => $g_user->name,
                    'avatar' => $g_user->user['picture'],
                    'password' => \Hash::make(User::PASSWORD_DEFAULT),
                    'zip_code' => 0000,
                    'address' => '--',
                    'tel' => '0000000000',
                    'email_verified_at' => Carbon::now()
                ];

                $user = $this->repository->add($attributes);
            } else {
                //
            }

            $user = \Auth::login($user);

            if ($user = \Auth::user()) {
                $data = [
                    'token' => $user->createToken('chronoknowledge')->accessToken,
                    'user' => $user->toArray()
                ];
            }

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());
        }

        return $data;
    }

    /**
     * Login facebook user
     *
     * @return Array $data
     */
    public function loginFacebook()
    {
        $data = [];

        try {
            \DB::beginTransaction();

            $user = null;
            $f_user = Socialite::driver('facebook')->stateless()->user();
            $user = User::where('email', $f_user->email)->first();
            $existEmailButNotLinked = $user && empty($user->facebook_id);

            if ($existEmailButNotLinked) {
                $adjustAttributes = [ 'facebook_id' => $f_user->id ];
                $user = $this->repository->adjust($user->id, $adjustAttributes);
            } else if (empty($user)) {

                // create the user
                $attributes = [
                    'facebook_id' => $f_user->id,
                    'role_id' => User::NORMAL_USER,
                    'email' => $f_user->email,
                    'username' => $f_user->name,
                    'nick_name' => $f_user->nickname,
                    'name' => $f_user->name,
                    'avatar' => $f_user->avatar,
                    'password' => \Hash::make(User::PASSWORD_DEFAULT),
                    'zip_code' => 0000,
                    'address' => '--',
                    'tel' => '00000000000',
                    'email_verified_at' => Carbon::now()
                ];

                $user = $this->repository->add($attributes);
            } else {
                //
            }
            \Auth::login($user);

            if ($user = \Auth::user()) {
                $data = [
                    'token' => $user->createToken('chronoknowledge')->accessToken,
                    'user' => $user->toArray()
                ];
            }
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollback();
            \Log::error($e->getMessage());
        }

        return $data;
    }

    /**
     * This will register the user.
     *
     * @return Array $user
     */
    public function registerUser()
    {
        $user = [];

        $data = [
            'role_id' => User::NORMAL_USER,
            'email' => request()->get('email'),
            'username' => request()->get('username'),
            'password' => \Hash::make(request()->get('password')),
            'name' => request()->get('name'),
            'nick_name' => request()->get('nick_name'),
            'birth_date' => request()->get('birth_date'),
            'gender' => request()->get('gender'),
            'zip_code' => request()->get('zip_code'),
            'address' => request()->get('address'),
            'tel' => request()->get('tel'),
            'email_verified_at' => request()->get('email_verified_at'),
            'deleted_at' => request()->get('deleted_at')
        ];

        \DB::beginTransaction();

        try {
            $user = $this->repository->add($data);
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
        }

        return $user;
    }

    /**
     * This will send notification to the user's email.
     *
     * @return array $data
     */
    public function sendResetLinkEmail()
    {
        $reset_token = $this->randStr(10);
        $data = [
            'url' => env('APP_URL') . '?reset_token=' . $reset_token,
            'reset_token' => $reset_token,
            'email' => request()->get('email')
        ];

        $user = User::where('email', $data['email'])->get();

        try {
            \Notification::send($user, new ResetPasswordLink($data));
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }

        return $data;
    }

    /**
     *
     * @return JSON $randomString
     */
    public function randStr($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

    /**
     * Reset the user password.
     *
     * @return array $rtn
     */
    public function reset()
    {
        $rtn = [];

        $adjustAttributes = [
            'password' => \Hash::make(request()->get('new_password'))
        ];

        $whereAttributes = [
            'email' => request()->get('email')
        ];

        try {
            $rtn = $this->repository->adjustByAttributes($whereAttributes, $adjustAttributes);
        } catch (\Exception $e) {
            \Log::error('Exception: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }

        return $rtn;
    }

    /**
     * Update user record
     *
     * @param $id
     *
     * @return boolean $rtn
     */
    public function adjust(Request $request, $id)
    {
        $rtn = false;

        $attributes = [
            'firstname' => $request->get('firstname'),
            'middlename' => $request->get('middlename'),
            'lastname' => $request->get('lastname'),
            'username' => $request->get('username'),
            'name' => $request->get('name'),
            'nick_name' => $request->get('nick_name'),
            'avatar' => $request->get('avatar'),
            'birth_date' => $request->get('birth_date'),
            'avatar' => $request->get('avatar'),
            'gender' => $request->get('gender'),
            'zip_code' => $request->get('zip_code'),
            'address' => $request->get('address'),
            'tel' => $request->get('tel')
        ];

        $avatarUrl = Upload::saveFromUrl($attributes['avatar']);

        if ($avatarUrl) {
            $attributes['avatar'] = $avatarUrl;
            $rtn = $this->repository->adjust($id, $attributes);
        }

        return $rtn;
    }

    /**
     * Delete one user
     *
     * @return JSON $rtn
     */
    public function annul()
    {
        $rtn = [];
        $userId = request()->get('id');

        $rtn = $this->repository->annul($userId);
        return $rtn;
    }

    /**
     * Delete one user
     *
     * @return JSON $rtn
     */
    public function annulMany()
    {
        $rtn = [];
        $ids = explode(',', request()->get('ids', ''));

        $rtn = $this->repository->annulMany($ids);
        return $rtn;
    }

    /**
     * Upload file
     *
     * @return boolean|string $rtn
     */
    public function upload()
    {
        $rtn = false;

        $file = request()->file('avatarImg');
        $fileType = request()->input('fileType');

        if ($fileType == \Globals::FILETYPE_IMAGE) {
            $rtn = Upload::saveTemp($file, $fileType);
        }

        return $rtn;
    }
}

