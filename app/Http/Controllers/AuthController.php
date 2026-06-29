<?php

namespace App\Http\Controllers;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        if (Sentinel::check()) {
            return redirect()->route('index');
        }

        return view('auth.login')->with('error', 'Login failed');
    }


    public function loginPost(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ];

        $customMessages = [
            'email.required' => trans('Email is required'),
            'password.required' => trans('Password is required'),
        ];

        $this->validate($request, $rules, $customMessages);

        try {
            if (Sentinel::authenticate($request->only(['email', 'password']), $request->get('remember-me', 0))) {
                return redirect()->route('index')->with('success', 'Welcome back');
            } else {
                return redirect()->route('auth.login')->withInput()->with('error', 'Login failed invalid credentials');
            }

        } catch (Exception $e) {
            return redirect()->route('auth.login')->withInput()->with('error', 'Login failed ' . $e->getMessage());
        }
    }

    public function logout()
    {
        if (Sentinel::check()) {
            Sentinel::logout();
        }

        return redirect()->route('auth.login')->with('success', 'You have successfully logged out!');
    }
}
