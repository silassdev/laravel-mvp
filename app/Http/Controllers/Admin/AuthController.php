<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required','email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Optional: restrict to admins only (if you have is_admin flag)
            if (Auth::user()->is_admin ?? false) {
                return redirect()->intended(route('admin.dashboard'));
            }

            // not admin: logout and reject
            Auth::logout();
            return redirect()->back()->with('admin_error', 'Unauthorized (not an admin).');
        }

        return redirect()->back()->with('admin_error', 'Invalid credentials.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
