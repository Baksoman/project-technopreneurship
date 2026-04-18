<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('user_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->route('admin.login')
            ->with('toastify', json_encode([
                'type' => 'info',
                'message' => 'Anda telah logout dari admin panel.'
            ]));
    }
}
