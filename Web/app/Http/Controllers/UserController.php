<?php

namespace App\Http\Controllers;

use App\Exercise;
use App\Rules\MatchOldPassword;
use App\Report;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Browser;
use App\Log;

class UserController extends Controller
{
    public function index() {
        $data = True;
        if (count(Auth::user() -> records) < 21)
            $data = False;
        return view('profile')->with('data', $data);
    }

    public function showRanking($type) {
        if ($type == 'add') {
            $ranking = User::orderBy('words', 'desc')->SimplePaginate(15);
            // dd($ranking -> links() -> paginator -> perPage());
            return view('ranking-add')->with('ranking', $ranking);
        } else if ($type == 'exercise') {
            $ranking = Exercise::orderBy(DB::raw("`writing` + `matching`"), 'desc')->SimplePaginate(15);
            return view('ranking-exercise')->with('ranking', $ranking);
        } else if ($type == 'repeat') {
            $ranking = Exercise::orderBy('translation', 'desc')->SimplePaginate(15);
            return view('ranking-repeat')->with('ranking', $ranking);
        } else {
            return view('404');
        }
    }

    public function list() {
        if (Browser::isTablet())
            $users = User::paginate(20);
        else
            $users = User::paginate(10);
        return view('users-list')->with('users', $users);
    }

    public function changeName(Request $req) {
        $user = User::find(Auth::id());
        $user -> name = mb_strtolower($req -> name);
        $user -> save();

        // Add log
        $log = new Log;
        $log -> type = 23;
        $log -> user_id = Auth::id();
        $log -> save();

        return redirect()->back();
    }

    public function changePassword(Request $req) {
        $req->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required', 'string', 'min:8'],
            'confirm_password' => ['same:new_password'],
        ]);
        User::find(Auth::id())->update(['password'=> Hash::make($req->new_password)]);

        // Add log
        $log = new Log;
        $log -> type = 21;
        $log -> user_id = Auth::id();
        $log -> save();

        return redirect('/panel/ustawienia')->with(['message' => 'Twoje hasło zostało zmienione']);
    }

    public function destroy(Request $req) {
        if (mb_strtolower($req -> delete) == 'usuwam konto') {
            User::destroy(Auth::id());
            return redirect('/');
        }

        // Add log
        $log = new Log;
        $log -> type = 24;
        $log -> user_id = Auth::id();
        $log -> save();

        return redirect()->back();
    }

    public function details($id) {
        $user = user::find($id);
        if (!$user) {
            return redirect()->back();
        }
        $data = True;
        if (count($user -> records) < 21)
            $data = False;
        return view('user-details', compact('user', 'data'));
    }

    public function editUserName(Request $req) {
        $req->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $user = User::find($req -> user_id);
        $user -> name = mb_strtolower($req -> name);
        $user -> save();

        // Add log
        $log = new Log;
        $log -> type = 26;
        $log -> user_id = Auth::id();
        $log -> type_id = $user -> id;
        $log -> save();

        return redirect()->back();
    }

    public function editUserEmail(Request $req) {
        $req->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
        $user = User::find($req -> user_id);
        $user -> email = mb_strtolower($req -> email);
        $user -> save();

        // Add log
        $log = new Log;
        $log -> type = 25;
        $log -> user_id = Auth::id();
        $log -> type_id = $user -> id;
        $log -> save();

        return redirect()->back();
    }

    public function deleteUser(Request $req) {
        if (mb_strtolower($req -> delete) == 'usuwam użytkownika') {
            User::destroy($req -> user_id);

            // Add log
            $log = new Log;
            $log -> type = 27;
            $log -> user_id = Auth::id();
            $log -> type_id = $req -> user_id;
            $log -> save();

            return redirect('/admin/users');
        }

        return redirect()->back();
    }

    public function logs() {
        // 1 - Create account
	    // 2 - Log in
	    // 3 - Log out
        // 4 - Forgot password - Not Yet Included
        // 5 - Add suggestion
        // 6 - Accept suggestion
        // 7 - Replace word
        // 8 - Edit suggestion
        // 9 - Delete suggestion
        // 10 - Edit word
        // 11 - Delete word
        // 12 - Write report
        // 13 - Delete report
        // 14 - Add remembered word
        // 15 - Delete remembered word
        // 16 - Add section
        // 17 - Edit section
        // 18 - Delete section
        // 19 - Exercise - matching
        // 20 - Exercise - writing
        // 21 - Change password
        // 22 - Change email
        // 23 - Change name
        // 24 - Delete account
        // 25 - Change somebody's email
        // 26 - Change somebody's name
        // 27 - Delete somebody's account
        $logs = Log::orderByDesc('date')->paginate(10);
        return view('logs')->with('logs', $logs);
    }
}
