<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\BackupDatabaseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 
Route::resource('columns', ColumnController::class);
Route::resource('cards', CardController::class);
Route::post('columns/orderchange', [ColumnController::class, 'orderchange']);
Route::post('cards/arrow', [CardController::class, 'arrow']);
Route::post('backup', [BackupDatabaseController::class, 'backup']);