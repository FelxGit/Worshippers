<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * The admin dashboard home
     *
     * @return view
     */
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * The admin dashboard home
     *
     * @return view
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}