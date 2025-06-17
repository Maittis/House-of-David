<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsherCollectionController;

use App\Http\Controllers\DonationController;
use App\Http\Controllers\CollectionController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/donations/verify-qr', [DonationController::class, 'verifyQrPayment'])
    ->middleware('auth:sanctum');




Route::post('/public-collections', [CollectionController::class, 'storePublicCollection']);
Route::post('/usher-login', [CollectionController::class, 'usherLogin']);
Route::post('/usher-collections', [CollectionController::class, 'storeUsherCollection']);
Route::post('/admin-login', [CollectionController::class, 'adminLogin']);
Route::get('/admin/reports', [CollectionController::class, 'fetchUsherCollections']);
