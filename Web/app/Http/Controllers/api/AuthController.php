<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Log;

class AuthController extends Controller
{
    public function register(Request $req)
    {
        $req->validate([
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'name' => 'required|string|min:2|max:15',
        ]);
        $user = new User([
            'name' => $req -> name,
            'email' => $req -> email,
            'password' => Hash::make($req -> password),
        ]);
        $user->save();

        // Add log
        $log = new Log;
        $log -> type = 1;
        $log -> user_id = $user -> id;
        $log -> save();

        return response()->json(['message' => 'OK']);
    }

    public function login(Request $req)
    {
        $req->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = Request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json(['message' => 'Podano błędne dane logowania'], 401);
        $user = $req->user();

        // Add log
        $log = new Log;
        $log -> type = 2;
        $log -> user_id = $user -> id;
        $log -> save();

        return response()->json($user);
    }

    // public function logout(Request $req)
    // {
    //     $req->user()->token()->revoke();

    //     // Add log
    //     $log = new Log;
    //     $log -> type = 3;
    //     $log -> user_id = $req -> user() -> id;
    //     $log -> save();

    //     return response()->json(['message' => 'Wylogowano']);
    // }
}
