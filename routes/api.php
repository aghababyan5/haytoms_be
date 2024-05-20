<?php

use App\Http\Controllers\Events\DeleteEventController;
use App\Http\Controllers\Events\GetEventsController;
use App\Http\Controllers\Events\ShowEventController;
use App\Http\Controllers\Events\StoreEventController;
use App\Http\Controllers\Events\UpdateEventController;
use App\Http\Controllers\Users\ChangePasswordController;
use App\Http\Controllers\Users\GetAuthUserController;
use App\Http\Controllers\Users\UserLoginController;
use App\Http\Controllers\Users\UserLogoutController;
use App\Http\Controllers\Users\UserStoreController;
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
    Route::get('/events/{id}', ShowEventController::class); // SHOW
    Route::get('/all-events', GetEventsController::class); // GET ALL
    Route::post('/user', UserStoreController::class); // STORE USER OR MODERATOR
    Route::post('/login', UserLoginController::class); // LOGIN
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get(
            '/user',
            GetAuthUserController::class
        ); // GET LOGIN EXAC USERIN IRA EVENTNEROV
        Route::post('/logout', UserLogoutController::class); // LOGOUT
        Route::put('/change-password/{id}', ChangePasswordController::class);
        Route::post('/events', StoreEventController::class); // CREATE
        Route::delete('/events/{id}', DeleteEventController::class); // DELETE
        Route::post('/events/{id}', UpdateEventController::class); // UPDATE
    });
});

// email password confirm password name surname phone number

/*
 * GET http://127.0.0.1/api/events = sax kinonery stanumes
 * GET http://127.0.0.1/api/events/{id} = mi hatik kinon es stanum yst id-i, orinak http://127.0.0.1/api/events/1 kam 2 kam 7 kam 50
 * POST http://127.0.0.1/api/events = kino sarqelu hamar
 */

