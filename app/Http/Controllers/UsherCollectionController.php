<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UsherCollection;

class UsherCollectionController extends Controller
{
    public function dashboard()
    {
        // Fetch usher collections grouped by usher_name and collection_type with totals
        $collections = UsherCollection::selectRaw('usher_name, collection_type, SUM(amount) as total_amount')
            ->groupBy('usher_name', 'collection_type')
            ->get()
            ->groupBy('usher_name');

        // Prepare summary data per usher
        $usherSummaries = [];
        foreach ($collections as $usherName => $groupedCollections) {
            $summary = [
                'tithe' => 0,
                'offering' => 0,
                'donation' => 0,
            ];
            foreach ($groupedCollections as $collection) {
                $type = strtolower($collection->collection_type);
                if (array_key_exists($type, $summary)) {
                    $summary[$type] = $collection->total_amount;
                }
            }
            $usherSummaries[$usherName] = $summary;
        }

        return view('usher.dashboard', [
            'usherSummaries' => $usherSummaries,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'usherName' => 'required|string|max:255',
            'payerName' => 'required|string|max:255',
            'collectionType' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'signatureDataUrl' => 'required|string',
        ]);

        $collection = new UsherCollection();
        $collection->usher_name = $validated['usherName'];
        $collection->payer_name = $validated['payerName'];
        $collection->date_time = now();
        $collection->collection_type = $validated['collectionType'];
        $collection->amount = $validated['amount'];
        $collection->signature = $validated['signatureDataUrl'];
        $collection->save();

        return response()->json(['message' => 'Collection saved successfully']);
    }
}
