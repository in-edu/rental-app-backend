<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ResidentialPropertyController;

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

Route::get('residentialProperty/', [ResidentialPropertyController::class, 'showWithParams']);
Route::get('residentialProperty/categories', [ResidentialPropertyController::class, 'getCategories']);
Route::get('residentialProperty/{id}', [ResidentialPropertyController::class, 'getOne']);
Route::get('fileupload/{id}', [FileuploadController::class, 'getName']);
Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);

        //for liked homes
        Route::post('likedHome', [LikedHomeController::class, 'store']);
        Route::delete('likedHome', [LikedHomeController::class, 'deleteLikedApartment']);
        Route::post('likedHomes', [LikedHomeController::class, 'getAllLikedHomesOfUser']);

        //for store, update and delete home
        Route::post('residentialProperty', [ResidentialPropertyController::class, 'store']);
        Route::put('residentialProperty/{id}', [ResidentialPropertyController::class, 'update']);
        Route::delete('residentialProperty/{id}', [ResidentialPropertyController::class, 'delete']);

        //store file
        Route::resource('fileupload', FileuploadController::class);
        Route::get('fileuploads/{residentialProperty_id}', [FileuploadController::class, 'getImagesOfHome']);
    });
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
