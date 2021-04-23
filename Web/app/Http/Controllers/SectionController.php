<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SectionController extends Controller
{
    public function index($id) {
        $section = Section::find($id);
        return view('section')->with('section', $section);
    }

    public function editPage($id) {

    }

    public function edit(Request $req) {

    }

    public function list() {
        $words = Word::all();
        $sections = Section::where('user_id', Auth::id())->paginate(15);
        return view('sections-list') -> with('sections', $sections);
    }

    public function createPage() {
        return view('section-create');
    }

    public function create(Request $req) {
        $req->validate([
            'name' => 'required|string|min:2|max:50',
        ]);
        $section = new Section();
        $section -> name = $req -> name;
        $section -> user_id = Auth::id();
        $section -> save();
        $words = explode(',', $req -> words);
        foreach($words as $word ) {
            DB::insert('insert into elements_of_section (section_id, word_id) values (?, ?)', [$section -> id, $word]);
        }
        return redirect('/profile/sections');
    }

    public function destroy(Request $req) {
        Section::destroy($req -> section_id);
        return redirect()->back();
    }
}
