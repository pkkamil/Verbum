<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use App\Exercise;
use Illuminate\Support\Facades\Auth;
use App\Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function google() {
        return Socialite::driver('google')->redirect();
    }

    public function googleRedirect() {
        $user = Socialite::driver('google')->user();

        $user = User::firstOrCreate([
            'email' => $user -> email
        ], [
            'name' => $user -> name,
            'password' => Hash::make(Str::random(16))
        ]);

        // Add log
        $log = new Log;
        $log -> type = 2;
        $log -> user_id = $user -> id;
        $log -> save();

        Exercise::create([
            'user_id' => $user -> id,
        ]);
        Auth::login($user, true);

        return redirect('/');
    }
}
