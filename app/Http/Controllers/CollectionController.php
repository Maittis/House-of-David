<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\UsherCollection;

class CollectionController extends Controller
{
    // Store public collections
    public function storePublicCollection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Store the public collection (in-memory or database)
        // For simplicity, we can use session or a simple array
        $publicCollections = session('publicCollections', []);
        $publicCollections[] = [
            'type' => $request->type,
            'amount' => $request->amount,
            'timestamp' => now(),
        ];
        session(['publicCollections' => $publicCollections]);

        return response()->json(['success' => true, 'message' => 'Public collection recorded']);
    }

    // Usher login
    public function usherLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Just return the usher name
        return response()->json(['success' => true, 'usherName' => $request->name]);
    }

    // Store usher collections
    public function storeUsherCollection(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'usherName' => 'required|string',
            'collectionType' => 'required|string',
            'amount' => 'required|numeric|min:0.01',
            'signatureDataUrl' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        // Store usher collection in database
        UsherCollection::create([
            'usher_name' => $request->usherName,
            'collection_type' => $request->collectionType,
            'amount' => $request->amount,
            'date_time' => now(),
            'signature' => $request->signatureDataUrl,
        ]);

        return response()->json(['success' => true, 'message' => 'Usher collection recorded']);
    }

    // Superadmin login
    public function adminLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string',
        ]);

        if ($validator->fails() || $request->password !== 'superadmin123') {
            return response()->json(['error' => 'Incorrect password'], 401);
        }

        // Generate a simple token (for demo purposes)
        $token = bin2hex(random_bytes(16));
        session(['superadmin_token' => $token]);

        return response()->json(['success' => true, 'token' => $token]);
    }

    // Fetch usher collections for superadmin
    public function fetchUsherCollections(Request $request)
    {
        if ($request->session()->get('superadmin_token') !== $request->header('Authorization')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $usherCollections = UsherCollection::all();
        return response()->json(['success' => true, 'usherCollections' => $usherCollections]);
    }
}
