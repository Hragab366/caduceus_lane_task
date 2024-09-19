<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ExportBooksController;
use App\Http\Controllers\importBooksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('guest')->group(function () {
   Route::post('login', LoginController::class);
});


Route::prefix('v1')->middleware(['auth:sanctum'])->group( function () {
    Route::get('/user', function () {
        return auth()->user();
    });
//authors
    Route::group(['prefix' => 'author','middleware' => 'role:Admin','controller' => AuthorController::class],function () {
        Route::get('/','index');
        Route::post('/store','store');
        Route::put('/update/{user}','update');
        route::delete('/delete/{user}','destroy');
    });
//    Excel
    Route::get('/books/export', ExportBooksController::class);
    Route::post('/books/import', importBooksController::class);
//    books
    Route::apiResource('books', BookController::class)->except('update');
    Route::post('/books/update/{book}', [BookController::class,'update']);
//    log out
    Route::post('/logout', LogoutController::class);
});
