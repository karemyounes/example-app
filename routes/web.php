<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Laravel\Socialite\Facades\Socialite;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('product', [ProductController::class , 'index'] ) ;
Route::get('product/{id}', [ProductController::class , 'show'] ) -> middleware('auth') ;
Route::get('createproduct', [ProductController::class , 'create'] ) -> middleware('auth') ;
Route::Post('saveproduct', [ProductController::class , 'store'] ) -> middleware('auth') ;
Route::get('editproduct/{id}', [ProductController::class , 'edit'] ) -> middleware('auth') ;
Route::Post('{id}/updateproduct', [ProductController::class , 'update'] ) -> middleware('auth') ;
Route::get('deleteproduct/{id}' , [ProductController::class , 'destroy'] ) -> middleware('auth') ;
//Route::Post('order' , [ProductController::class , 'order']) -> middleware('auth') ;
Route::Post('createorder' , [ProductController::class , 'createorder']);
Route::get('order', [ProductController::class , 'orderpage'] );
Route::get('startorder', [ProductController::class , 'startorder'] );


/*Route::get('auth/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('auth/callback', function () {
    $user = Socialite::driver('facebook')->user();

    // $user->tokennpm install
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

*/