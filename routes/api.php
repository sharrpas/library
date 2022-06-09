<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
use App\Http\Controllers\UserController;
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

include 'admin/api.php';

//authentication
Route::post('/signup', [UserController::class, 'signup'])->name('signup');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/logout',[UserController::class,'logout'])->middleware('auth:sanctum')->name('logout');
Route::post('/change/pass',[UserController::class, 'changePass'])->middleware('auth:sanctum')->name('changePass');
Route::get('/info',[UserController::class, 'info'])->middleware('auth:sanctum');

//library
Route::get('library',[LibraryController::class,'index'])->middleware('auth:sanctum');
Route::get('/book/{book}',[LibraryController::class,'show'])->middleware('auth:sanctum');
Route::post('/book/{book}',[LibraryController::class,'store'])->middleware('auth:sanctum');
Route::post('/delete/book/{book}',[LibraryController::class,'destroy'])->middleware('auth:sanctum');

//books
Route::get('/books',[BookController::class, 'index']);
Route::get('/books/search/{search}',[BookController::class, 'search']);

//todo: search


