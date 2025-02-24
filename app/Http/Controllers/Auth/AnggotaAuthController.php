<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AnggotaAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login_anggota');
    }

    public function showRegisterForm()
    {
        return view('auth.register_anggota');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('anggota')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'nim' => [
                'required',
                'unique:anggotas,nim',
                'digits_between:1,10',
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'unique:anggotas,email',
                'regex:/^[a-zA-Z0-9._%+-]+@binus(\.[a-zA-Z]+)+$/'
            ],
            'password' => 'required|min:11',
        ]);

        $anggota = Anggota::create([
            'nim' => $validated['nim'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        if ($anggota) {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            if (Auth::guard('anggota')->attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->intended('/');
            }
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('anggota')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
