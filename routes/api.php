<?php

use App\Http\Controllers\Movies\DeleteMovieController;
use App\Http\Controllers\Movies\GetMoviesController;
use App\Http\Controllers\Movies\ShowMovieController;
use App\Http\Controllers\Movies\StoreMovieController;
use App\Http\Controllers\Movies\TestController;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => 'api'], function () {
    Route::post('/movies', StoreMovieController::class); // CREATE
    Route::get('/movies/{id}', ShowMovieController::class); // SHOW
    Route::get('/movies', GetMoviesController::class); // GET ALL
    Route::delete('/movies/{id}', DeleteMovieController::class); // DELETE
//    Route::post('/movies/{id}', UpdateMovieController::class);
});

/*
 * GET http://127.0.0.1/api/movies = sax kinonery stanumes
 * GET http://127.0.0.1/api/movies/{id} = mi hatik kinon es stanum yst id-i, orinak http://127.0.0.1/api/movies/1 kam 2 kam 7 kam 50
 * POST http://127.0.0.1/api/movies = kino sarqelu hamar
 */

