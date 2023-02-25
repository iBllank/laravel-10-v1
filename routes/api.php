<?php

use Illuminate\Http\Request;
use App\Http\Middleware\langApi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\BlogsController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\UsersAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


*/

Route::middleware([langApi::class])->group(function () {

    // REGISTER AND LOGIN + SANCTUM TOKEN
    Route::resource('users', UsersController::class)->only(['store']);
    Route::post('userLogin',[UsersAuthController::class,'userLogin']);

    //LARAVEL SANCTUM
    Route::middleware(['auth:sanctum'])->group(function () {

        Route::post('userRevokeCurrentToken',[UsersAuthController::class,'userRevokeCurrentToken']);

        Route::resource('users', UsersController::class)->only([
            'index',
            'show',
            'update',
            'destroy'
        ]);

        Route::apiResource('blogs', BlogsController::class);

    });

});























