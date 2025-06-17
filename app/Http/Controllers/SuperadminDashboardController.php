<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsherCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsherCollectionsExport;

class SuperadminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $usherCollections = UsherCollection::all();

        return view('superadmin.dashboard', compact('usherCollections'));
    }

    public function exportExcel()
    {
        return Excel::download(new UsherCollectionsExport, 'usher_collections.xlsx');
    }
}
