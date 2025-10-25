<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $req)
    {
        $req->validate(['email'=>'required|email','password'=>'required']);
        if (Auth::attempt($req->only('email','password'), $req->boolean('remember'))) {
            $req->session()->regenerate();
            return $this->apiResponse(true, 'Logged in', route('admin.dashboard'));
        }
        return $this->apiResponse(false, 'Invalid credentials', null, 422);
    }

    public function register(Request $req)
    {
        $req->validate([
            'email'=>'required|email|unique:users,email',
            'fullname'=>'required|string|max:100',
            'username'=>'required|string|max:50|unique:users,username',
            'password'=>'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name' => $req->fullname,
            'email' => $req->email,
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'is_admin' => false,
        ]);

        Auth::login($user);
        return $this->apiResponse(true, 'Account created', route('home'));
    }

    public function logout(Request $req)
    {
        Auth::logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect('/');
    }

    protected function apiResponse($ok, $msg, $redirect=null, $status=200)
    {
        return response()->json(['ok'=>$ok,'message'=>$msg,'redirect'=>$redirect], $status);
    }
}
