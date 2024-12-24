<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AuthenticationController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/logout', [AuthenticationController::class, 'logout']);

Route::group(['middleware' => ['auth:sanctum']], function(){

//user
Route::post('/user', [UserController::class, 'store']);
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user{id}', [UserController::class, 'update']);
Route::delete('/user/{id}', [UserController::class, 'destroy']);

//book
Route::get('/book', [BookController::class, 'index']);
Route::post('/book', [BookController::class, 'store']);
Route::get('/book/{id}', [BookController::class, 'show']);
Route::put('/book/{id}', [BookController::class, 'update']);
Route::delete('/book/{id}', [BookController::class, 'destroy']);


//transaction request books history
Route::post('/request-book', [TransactionController::class, 'requestBooks']);
Route::put('/approve-request/{id}', [TransactionController::class, 'approveRequest']);
Route::put('/return-book/{id}', [TransactionController::class, 'returnBook']);
Route::get('/borrow-history/{id}', [TransactionController::class, 'viewBorrowHistory']);




});


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
