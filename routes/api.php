<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
  //  return $request->user();
//});

Route::Post('register', [UserController::class , 'register']);
Route::Post('login', [UserController::class , 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::Post('logout', [UserController::class , 'logout']);
    Route::get('product', [ProductController::class , 'index'] ) ;  
    Route::get('product/{id}', [ProductController::class , 'show'] );
    Route::Post('saveproduct', [ProductController::class , 'store'] ) ;
    Route::Post('{id}/updateproduct', [ProductController::class , 'update'] ) ;
    Route::get('deleteproduct/{id}' , [ProductController::class , 'destroy'] ) ;
    Route::Post('createorder' , [ProductController::class , 'createorder']);
    Route::get('incompleteorder', [ProductController::class , 'get_incomplete_order'] );
    Route::Post('startorder', [ProductController::class , 'startorder'] );
    Route::Post('indelevered', [ProductController::class , 'indelevered'] );
});



