<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

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

Route::post('/anime/list', [AnimeController::class, 'listAll']);

Route::get('/anime/cast/{anime}', [AnimeController::class, 'getCast']);

Route::resource('/anime', AnimeController::class)->except([
    'index', 'create', 'edit'
]);
