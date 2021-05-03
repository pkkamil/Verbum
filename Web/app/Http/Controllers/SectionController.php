<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Word;
use App\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Log;

class SectionController extends Controller
{
    public function index($id) {
        $section = Section::find($id);
        return view('section')->with('section', $section);
    }

    public function editPage($id) {
        $section = Section::find($id);
        if ($section -> user_id == Auth::id())
            return view('section-edit')->with('section', $section);
        else
            return redirect()-back();
    }

    public function edit(Request $req) {
        $req->validate([
            'name' => 'required|string|min:2|max:50',
        ]);
        $section = Section::where('id', $req -> section_id)->where('user_id', Auth::id())->first();
        $section -> name = $req -> name;
        $section -> save();
        $words = explode(',', $req -> words);
        DB::table('elements_of_section')->where('section_id', $req -> section_id)->delete();
        foreach($words as $word ) {
            DB::table('elements_of_section')->insert(
                ['section_id' => $section -> id, 'word_id' => $word]
            );
        }

        // Add log
        $log = new Log;
        $log -> type = 19;
        $log -> user_id = Auth::id();
        $log -> type_id = $section -> id;
        $log -> save();

        return redirect('/profile/sections');
    }

    public function list() {
        $words = Word::all();
        $sections = Section::where('user_id', Auth::id())->paginate(10);
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
            DB::table('elements_of_section')->insert(
                ['section_id' => $section -> id, 'word_id' => $word]
            );
        }

        // Add log
        $log = new Log;
        $log -> type = 18;
        $log -> user_id = Auth::id();
        $log -> type_id = $section -> id;
        $log -> save();

        return redirect('/profile/sections');
    }

    public function destroy(Request $req) {
        Section::destroy($req -> section_id);
        DB::table('elements_of_section')->where('section_id', $req -> section_id)->delete();

        // Add log
        $log = new Log;
        $log -> type = 20;
        $log -> user_id = Auth::id();
        $log -> type_id = $req -> section_id;
        $log -> save();

        return redirect()->back();
    }
}
