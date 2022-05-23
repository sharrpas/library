<?php

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
