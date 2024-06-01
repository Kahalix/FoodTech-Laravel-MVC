<?php

namespace App\Http\Controllers;

use App\Models\employees;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('employee.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('login', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }
}
