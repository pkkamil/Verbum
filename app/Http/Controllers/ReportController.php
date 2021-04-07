<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Browser;

class ReportController extends Controller
{
    public function index() {

    }

    public function list() {
        if (Browser::isTablet())
            $reports = report::paginate(20);
        else
            $reports = report::paginate(10);
        return view('reports-list')->with('reports', $reports);
    }

    public function destroy(Request $req) {
        Report::destroy($req -> report_id);
        return redirect()->back();
    }
}
