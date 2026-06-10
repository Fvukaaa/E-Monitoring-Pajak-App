<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginr(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('dashboard');
        }

        return redirect()->back()->with('error', 'Invalid credentials');
    }

    public function regis()
    {
        return view('auth.regis');
    }

    public function regisr(Request $request)
    {
        $user = User::create($request->all());
        return redirect('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
