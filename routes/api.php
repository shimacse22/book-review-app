<?php

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BooksController;
use App\Http\Controllers\Api\ReviewsController;

Route::controller(AuthController::class)->group(function(){
Route::post('register','register');
Route::post('login','login');

Route::get('profile','userProfile')->middleware('auth:sanctum');
Route::get('logout','destroy')->middleware('auth:sanctum');
});


// ✅ Public routes for books (no auth required)
Route::get('/books', [BooksController::class, 'index']);
Route::get('/books/{id}', [BooksController::class, 'show']);
Route::get('/books/{id}/similar', [BooksController::class, 'getSimilarBooks']);
Route::get('/books/{id}/reviews', [ReviewsController::class, 'getReviews']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reviews', [ReviewsController::class, 'index']);
    Route::get('/reviews/{id}', [ReviewsController::class, 'show']);
    Route::post('/reviews', [ReviewsController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewsController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewsController::class, 'destroy']);
    
});


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
