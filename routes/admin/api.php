<?php

use App\Http\Controllers\Admin\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    Route::get('books',[BookController::class, 'index'])->middleware(['auth:sanctum','admin.auth:sanctum']);
    Route::get('book/{book}',[BookController::class, 'show'])->middleware(['auth:sanctum','admin.auth:sanctum']);
    Route::post('book',[BookController::class, 'store'])->middleware(['auth:sanctum','admin.auth:sanctum']);
    Route::post('/update/book/{book}',[BookController::class, 'update'])->middleware(['auth:sanctum','admin.auth:sanctum']);
    Route::post('delete/book/{book}',[BookController::class, 'destroy'])->middleware(['auth:sanctum','admin.auth:sanctum']);


});
