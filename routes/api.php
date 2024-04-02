<?php

use App\Http\Controllers\Posts\DeletePostController;
use App\Http\Controllers\Posts\GetPostsController;
use App\Http\Controllers\Posts\ShowPostController;
use App\Http\Controllers\Posts\StorePostController;
use App\Http\Controllers\Posts\TestController;
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
    Route::post('/posts', StorePostController::class); // CREATE
    Route::get('/posts/{id}', ShowPostController::class); // SHOW
    Route::get('/posts', GetPostsController::class); // GET ALL
    Route::delete('/posts/{id}', DeletePostController::class); // DELETE
//    Route::post('/movies/{id}', UpdatePostController::class);
});

/*
 * GET http://127.0.0.1/api/movies = sax kinonery stanumes
 * GET http://127.0.0.1/api/movies/{id} = mi hatik kinon es stanum yst id-i, orinak http://127.0.0.1/api/movies/1 kam 2 kam 7 kam 50
 * POST http://127.0.0.1/api/movies = kino sarqelu hamar
 */

