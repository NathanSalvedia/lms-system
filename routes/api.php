<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\FinesController;
use App\Http\Controllers\AuthenticationController;


Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);

//user
Route::post('/user', [UserController::class, 'store']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user', [UserController::class, 'show']);
Route::put('/user', [UserController::class, 'update']);
Route::delete('/user', [UserController::class, 'destroy']);

//book
Route::post('/book', [BookController::class, 'store']);
Route::get('/book', [BookController::class, 'index']);
Route::get('/book', [BookController::class, 'show']);
Route::put('/book', [BookController::class, 'update']);
Route::delete('/book', [BookController::class, 'destroy']);

//Transaction
Route::post('/transaction', [TransactionController::class, 'store']);
Route::get('/transaction', [TransactionController::class, 'index']);
Route::get('/transaction', [TransactionController::class, 'show']);
Route::put('/transaction', [TransactionController::class, 'update']);
Route::delete('/transaction', [TransactionController::class, 'destroy']);


//Fines
Route::post('/fines', [FinesController::class, 'store']);
Route::get('/fines', [FinesController::class, 'index']);
Route::get('/fines', [FinesController::class, 'show']);
Route::put('/fines', [FinesController::class, 'update']);
Route::delete('/fines', [FinesController::class, 'destroy']);



Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
