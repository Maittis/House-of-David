<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/members/create', [DashboardController::class, 'create'])->name('members.create');
Route::post('/members', [DashboardController::class, 'store'])->name('members.store');
Route::get('/members/{member}/edit', [DashboardController::class, 'edit'])->name('members.edit');
Route::put('/members/{member}', [DashboardController::class, 'update'])->name('members.update');
Route::delete('/members/{member}', [DashboardController::class, 'destroy'])->name('members.destroy');
