<?php

use App\Http\Controllers\Admin\BookController;
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


Route::prefix('admin')->group(function () {

    Route::get('books',[BookController::class, 'index']);
    Route::get('book/{book}',[BookController::class, 'show']);
    Route::post('book',[BookController::class, 'store']);
    Route::put('book',[BookController::class, 'update']);
    Route::delete('book',[BookController::class, 'destroy']);


});
