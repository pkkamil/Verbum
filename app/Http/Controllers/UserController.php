<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return view('profile');
    }

    public function changeName(Request $req) {
        dd('nosz kurw*');
    }

    public function changePassword(Request $req) {

    }

    public function reportAnError(Request $req) {

    }

    public function destroy(Request $req) {

    }
}
