<?php

namespace App\Http\Controllers;

use App\Rules\MatchOldPassword;
use App\Report;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        return view('profile');
    }

    public function changeName(Request $req) {
        $user = User::find(Auth::id());
        $user -> name = $req -> name;
        $user -> save();
        return redirect()->back();
    }

    public function changePassword(Request $req) {
        $req->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['same:new_password'],
        ]);
        User::find(Auth::id())->update(['password'=> Hash::make($req->new_password)]);
        return redirect('/panel/ustawienia')->with(['message' => 'Twoje hasło zostało zmienione']);
    }

    public function reportAnError(Request $req) {
        $req->validate([
            'type' => 'required|string|max:50',
            'description' => 'required|string|max:200',
        ]);
        $report = new Report();
        $report -> type = $req -> type;
        $report -> description = $req -> description;
        $report -> user_id = Auth::id();
        $report -> save();
        return redirect()->back();
    }

    public function destroy(Request $req) {
        if (strtolower($req -> delete) == 'usuwam konto') {
            User::destroy(Auth::id());
            return redirect('/');
        }
        return redirect()->back();
    }
}
