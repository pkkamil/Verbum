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
use App\Suggestion;
use App\Trash;
use App\Word;
use App\Record;

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
        $log -> type = 25;
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
        $log -> type = 23;
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
        $log -> type = 26;
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
        $log -> type = 28;
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
        $log -> type = 27;
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
            $log -> type = 29;
            $log -> user_id = Auth::id();
            $log -> type_id = $req -> user_id;
            $log -> save();

            return redirect('/admin/users');
        }

        return redirect()->back();
    }

    public function trash() {
        if (Browser::isTablet())
            $trash = Trash::paginate(20);
        else
            $trash = Trash::paginate(10);
        return view('trash')->with('trash', $trash);
    }

    public function undo(Request $req) {
        $item = Trash::find($req -> item_id);
        if ($item -> type == 'suggestion') {
            $suggestion = new Suggestion();
            $suggestion -> user_id = $item -> user_id;
            $suggestion -> word = $item -> word;
            $suggestion -> translation = $item -> translation;
            $suggestion -> save();

            // Add log
            $log = new Log;
            $log -> type = 10;
            $log -> user_id = Auth::id();
            $log -> type_id = $suggestion -> id;
            $log -> save();
        } else {
            $word = new Word();
            $word -> user_id = $item -> user_id;
            $word -> word = $item -> word;
            $word -> translation = $item -> translation;
            $word -> save();

            $user = User::find($item -> user_id);
            $user -> words = $user -> words + 1;
            $user -> save();

            // Add Record
            $record = Record::whereDate('date', $item -> deleted_at)->where('user_id', $item -> user_id)->first();
            if (isset($record)) {
                $record -> words = $record -> words + 1;
                $record -> save();
            }

            // Add log
            $log = new Log;
            $log -> type = 13;
            $log -> user_id = Auth::id();
            $log -> type_id = $word -> id;
            $log -> save();
        }
        Trash::destroy($req -> item_id);
        return redirect('/admin/trash');
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
        // 10 - Undo deleted suggestion
        // 11 - Edit word
        // 12 - Delete word
        // 13 - Undo deleted word
        // 14 - Write report
        // 15 - Delete report
        // 16 - Add remembered word
        // 17 - Delete remembered word
        // 18 - Add section
        // 19 - Edit section
        // 20 - Delete section
        // 21 - Exercise - matching
        // 22 - Exercise - writing
        // 23 - Change password
        // 24 - Change email
        // 25 - Change name
        // 26 - Delete account
        // 27 - Change somebody's email
        // 28 - Change somebody's name
        // 29 - Delete somebody's account
        $logs = Log::orderByDesc('date')->paginate(10);
        return view('logs')->with('logs', $logs);
    }
}
