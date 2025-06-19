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

        $totalTithe = UsherCollection::where('collection_type', 'tithe')->sum('amount');
        $totalOffering = UsherCollection::where('collection_type', 'offering')->sum('amount');
        $totalDonations = UsherCollection::where('collection_type', 'donation')->sum('amount');

        return view('superadmin.dashboard', compact('usherCollections', 'totalTithe', 'totalOffering', 'totalDonations'));
    }

    public function exportExcel()
    {
        return Excel::download(new UsherCollectionsExport, 'usher_collections.xlsx');
    }
}
