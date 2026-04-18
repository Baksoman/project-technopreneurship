<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{
    public function showAuth()
    {
        if (session()->has('user_id')) {
            return redirect()->route('build');
        }
        return view('user.auth');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {
            $request->session()->regenerate();
            $request->session()->put([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'last_activity_time' => time()
            ]);

            return redirect()->intended(route('build'))->with('success', 'Login berhasil! Selamat datang, ' . $user->name);
        }

        return back()->with('error', 'Email atau password salah')->onlyInput('email');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        $request->session()->regenerate();
        $request->session()->put([
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'last_activity_time' => time()
        ]);

        return redirect(route('build'))->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name);
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect(route('build'))->with('info', 'Anda telah logout. Sampai jumpa lagi!');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::where('google_id', $googleUser->id)
                ->orWhere('email', $googleUser->email)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => bcrypt(Str::random(24)),
                    'email_verified_at' => now(),
                    'is_active' => true,
                ]);

                $user->assignRole('user');
            } else {
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->id]);
                }
            }

            if (!$user->is_active) {
                return redirect()->route('auth')->with('error', 'Akun dinonaktifkan.');
            }

            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'last_activity_time' => time()
            ]);
            request()->session()->regenerate();

            return redirect(route('build'))->with('success', 'Login berhasil, Selamat datang, ' . $user->name);

        } catch (\Exception $e) {
            return redirect()->route('auth')->with('error', 'Login gagal');
        }
    }
}
