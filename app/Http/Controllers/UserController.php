<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\Rules\MatchOldPassword;
use App\Report;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use stdClass;

class UserController extends Controller
{
    public function index() {
        return view('profile');
    }

    public function showRanking($type) {
        if ($type == 'add') {
            $ranking = User::all()->sortBy('words')->reverse();
            return view('ranking-add')->with('ranking', $ranking);
        } else if ($type == 'exercise') {
            $ranks = Exercise::all();
            $keys = [];
            $values = [];
            foreach($ranks as $rank) {
                array_push($keys, $rank -> user_id);
                array_push($values, $rank -> writing + $rank -> matching);
            }
            $ranking = array_combine($keys, $values);
            arsort($ranking);
            return view('ranking-exercise')->with('ranking', $ranking);
        } else if ($type == 'repeat') {
            $ranking = Exercise::orderBy('translation', 'desc')->get();
            return view('ranking-repeat')->with('ranking', $ranking);
        } else {
            return view('404');
        }
    }

    public function list() {
        $users = User::paginate(10);
        return view('users-list')->with('users', $users);
    }

    public function changeName(Request $req) {
        $user = User::find(Auth::id());
        $user -> name = mb_strtolower($req -> name);
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
        $report -> type = mb_strtolower($req -> type);
        $report -> description = mb_strtolower($req -> description);
        $report -> user_id = Auth::id();
        $report -> save();
        return redirect()->back();
    }

    public function destroy(Request $req) {
        if (mb_strtolower($req -> delete) == 'usuwam konto') {
            User::destroy(Auth::id());
            return redirect('/');
        }
        return redirect()->back();
    }

    public function details($id) {
        $user = user::find($id);
        if (!$user) {
            return redirect(url()->previous());
        }
        return view('user-details')->with('user', $user);
    }

    public function editUserName(Request $req) {
        $req->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $user = User::find($req -> user_id);
        $user -> name = mb_strtolower($req -> name);
        $user -> save();
        return redirect()->back();
    }

    public function editUserEmail(Request $req) {
        $req->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
        $user = User::find($req -> user_id);
        $user -> email = mb_strtolower($req -> email);
        $user -> save();
        return redirect()->back();
    }

    public function deleteUser(Request $req) {
        if (mb_strtolower($req -> delete) == 'usuwam użytkownika') {
            User::destroy($req -> user_id);
            return redirect('/admin/users');
        }
        return redirect()->back();
    }
}
