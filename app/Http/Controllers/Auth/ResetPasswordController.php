<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with(['token'=>$token,'email'=>$request->query('email')]);
    }

    public function reset(Request $request)
    {
        $request->validate(['token'=>'required','email'=>'required|email','password'=>'required|confirmed|min:6']);
        $status = Password::reset(
            $request->only('email','password','password_confirmation','token'),
            function($user,$password){ $user->forceFill(['password'=>Hash::make($password)])->save(); Auth::login($user); }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('home')->with('status','Password reset successful. You are logged in.')
            : back()->withErrors(['email'=>[__($status)]]);
    }
}
