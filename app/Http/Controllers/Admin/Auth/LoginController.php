<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Helpers\DecryptionUtility;
use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{
    public $adminService;

    /**
     * @param AdminService $service
     * @return void
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    /**
     * @param Request $request
     * @return redirect
     */
    public function index()
    {
        $encryptedCookieValue = $_COOKIE['remember'] ?? null;
        $remember = DecryptionUtility::decryptCookie($encryptedCookieValue);

        return view('admin.auth.login', [ 'remember' => $remember]);
    }

    /**
     * This will try to login the user
     *
     * @param LoginRequest $request
     *
     * @return redirect
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $loginSuccessful = $this->adminService->login($credentials);

        if ($loginSuccessful) {
            $remember = $request->has('remember');
            $cookieName = 'remember';

            if ($remember) {
                $cookieValue = json_encode(['email' => $credentials['email'], 'password' => $credentials['password']]);
                $expiration = now()->addDays(30)->getTimestamp();

                $cookie = cookie($cookieName, $cookieValue, $expiration);

                return redirect()->route('admin.dashboard')->withCookie($cookie);
            }

            $cookie = \Cookie::forget($cookieName);
            return redirect()->route('admin.dashboard')->withCookie($cookie);
        }

        return redirect()->back()->withInput()->withErrors(['email' => 'Invalid credentials']);
    }
}
