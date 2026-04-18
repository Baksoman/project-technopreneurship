<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = User::with('builds')->findOrFail(session('user_id'));
        
        return view('user.profile', [
            'user' => $user,
            'buildsCount' => $user->builds()->count(),
            'memberSince' => $user->created_at->format('Y')
        ]);
    }
}
