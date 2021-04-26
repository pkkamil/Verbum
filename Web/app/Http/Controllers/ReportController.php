<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Browser;
use App\Log;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create(Request $req) {
        $req->validate([
            'type' => 'required|string|max:50',
            'description' => 'required|string|max:200',
        ]);
        $report = new Report();
        $report -> type = mb_strtolower($req -> type);
        $report -> description = mb_strtolower($req -> description);
        $report -> user_id = Auth::id();
        $report -> save();

        // Add log
        $log = new Log;
        $log -> type = 13;
        $log -> user_id = Auth::id();
        $log -> type_id = $report -> id;
        $log -> save();

        return redirect()->back();
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

        // Add log
        $log = new Log;
        $log -> type = 13;
        $log -> user_id = Auth::id();
        $log -> type_id = $req -> report_id;
        $log -> save();

        return redirect()->back();
    }
}
