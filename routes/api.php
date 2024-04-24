<?php

use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Events\DeleteEventController;
use App\Http\Controllers\Events\GetEventsController;
use App\Http\Controllers\Events\ShowEventController;
use App\Http\Controllers\Events\StoreEventController;
use App\Http\Controllers\Events\UpdateEventController;
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
    Route::post('/events', StoreEventController::class); // CREATE
    Route::get('/events/{id}', ShowEventController::class); // SHOW
    Route::get('/events', GetEventsController::class); // GET ALL
    Route::delete('/events/{id}', DeleteEventController::class); // DELETE
    Route::post('/events/{id}', UpdateEventController::class); // UPDATE
    Route::post('/admin', AdminLoginController::class); // Admin login
});

/*
 * GET http://127.0.0.1/api/movies = sax kinonery stanumes
 * GET http://127.0.0.1/api/movies/{id} = mi hatik kinon es stanum yst id-i, orinak http://127.0.0.1/api/movies/1 kam 2 kam 7 kam 50
 * POST http://127.0.0.1/api/movies = kino sarqelu hamar
 */

