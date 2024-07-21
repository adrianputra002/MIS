<?php

use App\Http\Controllers\ClaimsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[ClaimsController::class, 'home'])->name('home');
Route::get('/viewDBPenampung', [ClaimsController::class, 'ViewDBPenampung'])->name('homepenampung');
Route::get('/create',[ClaimsController::class, 'create'])->name('create');
Route::post('/submit-claim', [ClaimsController::class, 'store'])->name('store');
Route::post('/integrate', [ClaimsController::class, 'integrate'])->name('integrate');
