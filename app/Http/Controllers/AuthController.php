<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function view()
    {
        return view('auth.register');
    }

    public function register(RegisterValidation $request)
    {
        User::query()->create([
            "name" => $request->input('email'),
            "email" => $request->input('email'),
            "password" => Hash::make($request->input('pass')),
            "is_admin" => $request->input('is_admin')
        ]);
        return redirect()->route('home');
    }

    public function loginIndex()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $auth = Auth::attempt([
            "email" => $request->input('email'),
            "password" => $request->input('pass')
        ], 1);

        if (!$auth) {
            return redirect()->back();
        }

        return redirect()->route('home');
    }
}
